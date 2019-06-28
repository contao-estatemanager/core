<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

namespace ContaoEstateManager;


use Contao\Dbafs;
use Contao\FilesModel;

class RealEstateImporter extends \BackendModule
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'be_real_estate_sync';

    /**
     * Messages
     * @var array
     */
    protected $messages = array();

    /**
     * Interface
     * @var InterfaceModel
     */
    protected $objInterface;

    /**
     * Import folder model
     * @var \FilesModel
     */
    protected $objImportFolder;

    /**
     * Import folder model
     * @var \FilesModel
     */
    protected $objFilesFolder;

    /**
     * Import folder model
     * @var \Model\Collection
     */
    protected $objInterfaceMapping;

    /**
     * Path of sync file
     * @var string
     */
    protected $syncFile;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var integer
     */
    protected $startTime;

    /**
     * Generate module
     */
    protected function compile() {}

    /**
     * Syncs OpenImmo export data with database
     *
     * @param \DataContainer $dc
     *
     * @return string
     */
    protected function sync($dc)
    {
        $this->objInterface = InterfaceModel::findByPk($dc->id);
        $this->objImportFolder = \FilesModel::findByUuid($this->objInterface->importPath);
        $this->objFilesFolder = \FilesModel::findByUuid($this->objInterface->filesPath);
        $this->objInterfaceMapping = InterfaceMappingModel::findByPid($dc->id);

        \System::loadLanguageFile('tl_real_estate_sync');

        if (\Input::get('downloadWibXml'))
        {
            $syncTime = time();
            $syncUrl = html_entity_decode($this->objInterface->syncUrl) . '&lastChange=' . $this->objInterface->lastSync;
            $fileName = 'export_' . $syncTime . '.xml';

            $content = $this->getFileContent($syncUrl);

            if (strpos($content, 'uebertragung') !== false)
            {
                \File::putContent($this->objImportFolder->path . '/' . $fileName, $content);

                $this->objInterface->lastSync = $syncTime;
                $this->objInterface->save();

                \Message::addConfirmation('The file was downloaded successfully: ' . $fileName);
            }
            else
            {
                \Message::addInfo('The downloaded file was empty and was skipped.');
            }
        }

        if (\Input::post('FORM_SUBMIT') === 'tl_real_estate_import' && ($this->syncFile = \Input::post('file')) !== '')
        {
            $this->startTime = time();

            ini_set('max_execution_time', -1);

            $this->addLog('Start import from file: ' . $this->syncFile, 0, 'success');

            if (($this->syncFile = $this->getSyncFile($this->objImportFolder->path, $this->syncFile)) !== false)
            {
                if (($this->loadData()))
                {
                    $this->addLog('OpenImmo data loaded', 1, 'success');

                    if ($this->syncData())
                    {
                        $this->addLog('Import and synchronization was successful', 0, 'success');
                        \Message::addConfirmation('Import and synchronization was successful');
                    }
                    else
                    {
                        $this->addLog('OpenImmo data could not be synchronized.', 0, 'error');
                        \Message::addError('OpenImmo data could not be synchronized.');
                    }
                }
                else
                {
                    \Message::addError('OpenImmo data could not be loaded.');
                    $this->addLog('OpenImmo data could not be loaded.', 0, 'error');
                }
            }
            else
            {
                \Message::addError('OpenImmo file could not be loaded.');
                $this->addLog('OpenImmo file could not be loaded.', 0, 'error');
            }
        }

        $this->Template = new \BackendTemplate($this->strTemplate);

        $files = $this->getSyncFiles($this->objImportFolder->path);

        $this->Template->setData(array
        (
            'syncAvailable' => $this->objInterface->type === 'wib',
            'syncUrl'       => 'syncUrl',
            'files'         => $files,
            'messages'      => $this->messages
        ));


        return $this->Template->parse();
    }

    /**
     * Returns a list of syncable files
     *
     * @param string  $importPath
     * @param boolean $searchForZip
     *
     * @return array
     */
    public function getSyncFiles($importPath, $searchForZip=true)
    {
        try {
            $folder = new \Folder($importPath);
        } catch (\Exception $e) {
            return array();
        }

        if ($folder->isEmpty())
        {
            return array();
        }

        $arrFiles = array();
        $lasttime = time();

        $syncFiles = FilesHelper::scandirByExt($importPath, $searchForZip ? array('zip', 'xml') : array('xml'));

        $arrSynced = array();
        $objHistory = InterfaceHistoryModel::findMultipleBySources($syncFiles);

        if ($objHistory !== null)
        {
            while ($objHistory->next())
            {
                $arrSynced[$objHistory->source] = $objHistory->current();
            }
        }

        foreach ($syncFiles as $i => $file)
        {
            $mtime = FilesHelper::fileModTime($file);
            $size = FilesHelper::fileSizeFormated($file);

            if (array_key_exists($file, $arrSynced))
            {
                $syncedMtime = intval($arrSynced[$file]->tstamp);

                if ($syncedMtime > 0) {
                    $mtime = $syncedMtime;
                }
            }
            else
            {
                if ($lasttime > $mtime) {
                    $lasttime = $mtime;
                }
            }

            $arrFiles[] = array(
                "file" => $file,
                "time" => $mtime,
                "size" => $size,
                "user" => $arrSynced[$file]->username,
                "status" => intval($arrSynced[$file]->status),
                "synctime" => intval($arrSynced[$file]->tstamp),
                "checked" => false
            );
        }

        usort($arrFiles, array('\ContaoEstateManager\RealEstateImporter', 'sortFilesByTime'));

        return $arrFiles;
    }

    public function getSyncFile($importPath, $file)
    {
        if (FilesHelper::fileExt($file) === 'ZIP')
        {
            $this->unzipArchive($file);

            $syncFile = FilesHelper::scandirByExt($importPath . '/tmp', array('xml'));

            if (count($syncFile) === 0)
            {
                $this->addLog('No OpenImmo file was found in archive.', 0, 'error');
                return false;
            }

            if (count($syncFile) > 1)
            {
                $this->addLog('More than one OpenImmo file was found in archive. Only one OpenImmo file is allowed per transfer.', 0, 'error');
                return false;
            }

            return $this->getSyncFile($importPath, $syncFile[0]);
        }

        return $file;
    }

    /**
     * Unpack zip archive by path
     *
     * @param string $path path to zip file
     *
     * @throws \Exception
     */
    public function unzipArchive($path)
    {
        try {
            $tmpFolder = new \Folder(FilesHelper::fileDirPath($path) . 'tmp');
        } catch (\Exception $e) {
            return;
        }

        // Clear tmp folder if not empty
        if (!$tmpFolder->isEmpty())
        {
            $tmpFolder->purge();
        }

        $tmpPath = $tmpFolder->__get('value');

        $zip = new \ZipReader($path);
        $files = $zip->getFileList();
        $zip->first();

        foreach ($files as $file)
        {
            $content = $zip->unzip();
            $filePath = TL_ROOT . '/' . $tmpPath . '/' . $file;
            $dir = dirname($filePath);

            if (!file_exists($dir))
            {
                mkdir($dir);
            }

            file_put_contents(TL_ROOT . '/' . $tmpPath . '/' . $file, $content);
            $zip->next();
        }
    }

    /**
     * Loads the xml in a sync file
     *
     * @return boolean
     */
    protected function loadData()
    {
        $data = file_get_contents(TL_ROOT . '/' . $this->syncFile);

        /* FlowFact
        $data = str_replace('<imo:', '<', $data);
        $data = str_replace('</imo:', '</', $data);

        $oi_open_pos = strpos($data, '<openimmo');
        $oi_close_pos = strpos(substr($data, $oi_open_pos), '>');
        $data = substr($data, 0, $oi_open_pos) . '<openimmo>' . substr($data, $oi_close_pos + $oi_open_pos + 1);
        */

        try {
            $this->data = simplexml_load_string($data);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Sync OpenImmo data with database
     *
     * @return boolean
     */
    protected function syncData()
    {
        if ($this->data->getName() !== 'openimmo')
        {
            $this->addLog('Invalid OpenImmo data.', 1, 'error');
            return false;
        }

        $arrProvider = $this->data->xpath('anbieter');

        if (count($arrProvider) === 0)
        {
            $this->addLog('No provider data available.', 1, 'error');
            return false;
        }

        $contactPersonRecords = array();
        $realEstateRecords = array();

        foreach ($arrProvider as $provider)
        {
            $uniqueProviderValue = trim(current($provider->anbieternr));

            if ($this->objInterface->anbieternr !== $uniqueProviderValue && !$this->objInterface->importThirdPartyProvider)
            {
                $this->addLog('Skip real estate due to missing provider', 1, 'info');
                continue;
            }

            $arrRealEstate = $provider->xpath('immobilie');

            foreach ($arrRealEstate as $realEstate)
            {
                $uniqueValue = $this->getUniqueValue($realEstate);

                $contactPerson = array();
                $re = array
                (
                    'ANBIETER' => $uniqueProviderValue,
                    'AKTIONART' => current($realEstate->verwaltung_techn->aktion)['aktionart']
                );
                $addImageLog = true;

                $this->addLog('Import real estate: ' . $uniqueValue, 1, 'highlight', $realEstate);

                while ($this->objInterfaceMapping->next())
                {
                    $interfaceMapping = $this->objInterfaceMapping->current();

                    $groups = $realEstate->xpath($interfaceMapping->oiFieldGroup);
                    $values = array();

                    foreach ($groups as $group)
                    {
                        // Skip if condition dont match
                        if ($interfaceMapping->oiConditionField && $interfaceMapping->oiConditionValue)
                        {
                            if ($interfaceMapping->oiConditionValue !== $this->getFieldData($interfaceMapping->oiConditionField, $group))
                            {
                                continue;
                            }
                        }

                        $field = $interfaceMapping->oiField;

                        if (strrpos($field, '/') !== false)
                        {
                            $tmpGroup = $group;
                            $tmpField = $field;

                            list($group, $field) = $this->getPath($group, $field);
                        }

                        $value = $this->getFieldData($field, $group);

                        // Skip if value is not set
                        if ($value === null)
                        {
                            continue;
                        }

                        // Save image if needed
                        if ($interfaceMapping->saveImage)
                        {
                            $format = current($tmpGroup->format);
                            $check = next($tmpGroup->check);

                            if($addImageLog)
                            {
                                $this->addLog('Add images', 2);
                                $addImageLog = false;
                            }

                            if ($this->objInterface->type === 'wib')
                            {
                                $fileName = $this->getValueFromStringUrl($value, 'imageId');

                                $extension = $this->getExtension($format);
                                $completeFileName = $fileName . $extension;

                                $existingFile = FilesModel::findByPath($this->objFilesFolder->path . '/' . $uniqueProviderValue . '/' . $uniqueValue . '/' . $completeFileName);

                                if ($existingFile !== null && $existingFile->hash === $check)
                                {
                                    $values[] = $existingFile->uuid;
                                    $this->addLog('Skip image: Image already exists and has not changed', 3, 'info', array(
                                        'filePath' => $this->objFilesFolder->path . '/' . $uniqueProviderValue . '/' . $uniqueValue . '/',
                                        'fileName' => $completeFileName
                                    ));
                                    continue;
                                }

                                $this->downloadFile($value, $this->objImportFolder, $completeFileName);

                                if ($fileSize = FilesHelper::fileSize($this->objImportFolder->path . '/tmp/' . $completeFileName) > 2500000)
                                {
                                    $this->addLog('Skip image: File size is too large or the image is broken', 3, 'error', array(
                                        'fileSize' => $fileSize
                                    ));
                                    continue;
                                }

                                $value = $completeFileName;
                            }
                            else
                            {
                                $existingFile = FilesModel::findByPath($this->objFilesFolder->path . '/' . $uniqueProviderValue . '/' . $uniqueValue . '/' . $value);

                                if ($existingFile !== null && $existingFile->hash === $check)
                                {
                                    $this->addLog('Skip image: ' . ($existingFile->hash === $check ? 'Image already exists and has not changed' : 'Image does not exist'), 3, 'info', array(
                                        'filePath' => $this->objFilesFolder->path . '/' . $uniqueProviderValue . '/' . $uniqueValue . '/',
                                        'fileName' => $value
                                    ));
                                    continue;
                                }
                            }

                            $objFile = $this->copyFile($value, $uniqueProviderValue, $uniqueValue);

                            if (($titel = current($tmpGroup->anhangtitel)) !== '')
                            {
                                $this->addLog('Image added: ' . $value, 3, 'success', array(
                                    'title' => $titel,
                                    'fileName' => $value
                                ));

                                $meta = array
                                (
                                    'de' => array
                                    (
                                        'title'   => $titel,
                                        'alt'     => $titel,
                                        'link'    => '',
                                        'caption' => ''
                                    )
                                );

                                $objFile->meta = serialize($meta);

                                $objFile->save();
                            }

                            $value = $objFile->uuid;
                        }

                        $value = $this->formatValue($value);

                        $values[] = $value;
                    }

                    if (!count($values))
                    {
                        continue;
                    }

                    $tmpValue = $interfaceMapping->serialize ? serialize($values) : $values[0];

                    switch ($interfaceMapping->type)
                    {
                        case 'tl_contact_person':
                            $contactPerson[$interfaceMapping->attribute] = $tmpValue;
                            break;
                        case 'tl_real_estate':
                            $re[$interfaceMapping->attribute] = $tmpValue;
                            break;
                    }
                }

                $this->objInterfaceMapping->reset();

                $contactPersonRecords[] = $contactPerson;
                $realEstateRecords[] = $re;

                $this->addLog('Fields have been assigned', 2, 'success', $re);
            }
        }

        return $this->updateCatalog($contactPersonRecords, $realEstateRecords);
    }

    protected function getExtension($format)
    {
        switch ($format)
        {
            case 'image/jpeg':
            case 'image/jpg':
                $extension = '.jpg';
                break;
            case 'image/png':
                $extension = '.png';
                break;
            case 'image/gif':
                $extension = '.gif';
                break;
            default:
                if (strpos('/', $extension) === false)
                {
                    $extension = '.' . strtolower($extension);
                }
                else
                {
                    $extension = '.jpg';
                }
        }

        return $extension;
    }

    protected function updateCatalog($contactPersonRecords, $realEstateRecords)
    {
        $actions = \StringUtil::deserialize($this->objInterface->contactPersonActions, true);

        $allowCreate = in_array('create', $actions);
        $allowUpdate = in_array('update', $actions);

        $this->addLog('Update database', 1, 'highlight');

        foreach ($contactPersonRecords as $i => $contactPerson)
        {
            if ($realEstateRecords[$i]['ANBIETER'] !== $this->objInterface->anbieternr && $this->objInterface->importThirdPartyProvider)
            {
                if (in_array($realEstateRecords[$i]['AUFTRAGSART'], array('R', 'V', 'S')))
                {
                    continue;
                }

                if ($realEstateRecords[$i]['vermarktungsartKauf'])
                {
                    $objContactPerson = ContactPersonModel::findByPk($this->objInterface->assignContactPersonKauf);
                }
                else if ($realEstateRecords[$i]['vermarktungsartMietePacht'])
                {
                    $objContactPerson = ContactPersonModel::findByPk($this->objInterface->assignContactPersonMietePacht);
                }
                else if ($realEstateRecords[$i]['vermarktungsartErbpacht'])
                {
                    $objContactPerson = ContactPersonModel::findByPk($this->objInterface->assignContactPersonErbpacht);
                }
                else if ($realEstateRecords[$i]['vermarktungsartLeasing'])
                {
                    $objContactPerson = ContactPersonModel::findByPk($this->objInterface->assignContactPersonLeasing);
                }
            }
            else
            {
                list($arrColumns, $arrValues) = $this->getContactPersonParameters($contactPerson);

                $exists = ContactPersonModel::countBy($arrColumns, $arrValues);

                // Skip if no contact person found and not allowed to create
                if (!$allowCreate && !$exists)
                {
                    $this->addLog('Skip real estate ' . $realEstateRecords[$i][$this->objInterface->uniqueField] . ': No contact person was found and no contact person may be created', 2, 'info');
                    continue;
                }

                if (!$exists)
                {
                    // Create new contact person
                    $objContactPerson = new ContactPersonModel();
                    $objContactPerson->setRow($contactPerson);
                    $objContactPerson->pid = $this->objInterface->provider;
                    $objContactPerson->published = 1;
                    $objContactPerson->save();

                    $this->addLog('New contact person was added: ' . $contactPerson['vorname'] . ' ' . $contactPerson['name'], 2, 'success');
                }
                else
                {
                    // Find contact person
                    $objContactPerson = ContactPersonModel::findOneBy($arrColumns, $arrValues);
                }

                if ($allowUpdate)
                {
                    // Update contact person
                    $objContactPerson->mergeRow($contactPerson);
                    $objContactPerson->save();

                    $this->addLog('Contact person was updated: ' . $contactPerson['vorname'] . ' ' . $contactPerson['name'], 2, 'success');
                }
            }

            $arrColumns = array($this->objInterface->uniqueField.'=?');
            $arrValues  = array($realEstateRecords[$i][$this->objInterface->uniqueField]);

            $exists = RealEstateModel::countBy($arrColumns, $arrValues);

            if (!$exists)
            {
                // Create new real estate
                $objRealEstate = new RealEstateModel();
                $objRealEstate->dateAdded = time();

                $this->addLog('New real estate was added: ' . $realEstateRecords[$i][$this->objInterface->uniqueField], 2, 'success');
            }
            else
            {
                // Find real estate
                $objRealEstate = RealEstateModel::findOneBy($arrColumns, $arrValues);

                if ($realEstateRecords[$i]['AKTIONART'] === 'DELETE')
                {
                    // Delete real estate
                    $objRealEstate->delete();
                    $this->addLog('Real estate was deleted: ' . $realEstateRecords[$i][$this->objInterface->uniqueField], 2, 'success');
                    continue;
                }else{
                    $this->addLog('Real estate was updated: ' . $realEstateRecords[$i][$this->objInterface->uniqueField], 2, 'success');
                }
            }

            if ($realEstateRecords[$i]['AKTIONART'] === 'REFERENZ')
            {
                $objRealEstate->referenz = 1;
            }

            $realEstateRecords[$i]['anbieternr'] = $realEstateRecords[$i]['ANBIETER'];

            unset($realEstateRecords[$i]['ANBIETER']);
            unset($realEstateRecords[$i]['AUFTRAGSART']);
            unset($realEstateRecords[$i]['AKTIONART']);

            foreach ($realEstateRecords[$i] as $field => $value)
            {
                $objRealEstate->{$field} = $value;
            }

            $objRealEstate->provider = $this->objInterface->provider;
            $objRealEstate->contactPerson = $objContactPerson->id;
            $objRealEstate->tstamp = time();
            $objRealEstate->published = 1;

            $objRealEstate->save();
        }

        if ($this->objInterface->type === 'openimmo')
        {
            $this->objInterface->lastSync = time();
            $this->objInterface->save();
        }

        try {
            $tmpFolder = new \Folder($this->objImportFolder->path . '/tmp');
        } catch (\Exception $e) {
            return;
        }

        // Clear tmp folder
        $tmpFolder->purge();

        $this->import('BackendUser', 'User');

        // Create history entry
        $objInterfaceHistory = new InterfaceHistoryModel();
        $objInterfaceHistory->pid = $this->objInterface->id;
        $objInterfaceHistory->tstamp = time();
        $objInterfaceHistory->source = $this->syncFile;
        $objInterfaceHistory->action = 'SUCCESS';
        $objInterfaceHistory->username = $this->User->username;
        $objInterfaceHistory->text = 'Die Datei "' . $this->syncFile . '" wurde erfolgreich importiert.';
        $objInterfaceHistory->status = 1;
        $objInterfaceHistory->save();

        return true;
    }

    protected function getContactPersonParameters($contactPerson)
    {
        $arrColumns = array('pid=?');
        $arrValues = array($this->objInterface->provider);

        switch ($this->objInterface->contactPersonUniqueField)
        {
            case 'name_vorname':
                $arrColumns[] = 'name=? && vorname=?';
                $arrValues[] = $contactPerson['name'];
                $arrValues[] = $contactPerson['vorname'];
                break;

            default:
                $arrColumns[] = $this->objInterface->contactPersonUniqueField.'=?';
                $arrValues[] = $contactPerson[$this->objInterface->contactPersonUniqueField];
        }

        return array($arrColumns, $arrValues);
    }

    protected function getValueFromStringUrl($url, $parameter)
    {
        $parts = parse_url($url);
        if (isset($parts['query']))
        {
            parse_str($parts['query'], $query);
            if (isset($query[$parameter]))
            {
                return $query[$parameter];
            }
        }

        return null;
    }

    protected function downloadFile($path, $targetDirectory, $fileName, $tmpFolder=true)
    {
        $content = $this->getFileContent($path);

        $this->addLog('Download: ' . $path, 3, 'raw', array(
            'source' => $path,
            'target' => $targetDirectory->path . '/' . ($tmpFolder ? 'tmp/' : '') . $fileName)
        );

        \File::putContent($targetDirectory->path . '/' . ($tmpFolder ? 'tmp/' : '') . $fileName, $content);
    }

    protected function getFileContent($path)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }

    protected function formatValue($value)
    {
        switch ($this->objInterfaceMapping->formatType)
        {
            case 'number':
                $value = number_format(floatval($value), $this->objInterfaceMapping->decimals, '.', '');

                if ($this->objInterfaceMapping->decimals == 0)
                {
                    $value = intval($value);
                }
                break;
            case 'date':
                $value = strtotime($value);
                break;
            case 'text':
                switch ($this->objInterfaceMapping->textTransform)
                {
                    case 'lowercase';
                        $value = strtolower($value);
                        break;
                    case 'uppercase';

                        $value = strtoupper($value);
                        break;
                    case 'capitalize';
                        $value = ucfirst($value);
                        break;
                }
                if ($this->objInterfaceMapping->trim)
                {
                    $value = trim($value);
                }
                break;
            case 'boolean':
                if ($this->objInterfaceMapping->booleanCompareValue)
                {
                    if ($this->objInterfaceMapping->booleanCompareValue === $value)
                    {
                        $value = '1';
                    }
                    else
                    {
                        $value = '';
                    }
                }
                elseif ($value && ($value === '1' || $value === 'true'))
                {
                    $value = '1';
                }
                else
                {
                    $value = '';
                }
                break;
        }

        return $value;
    }

    protected function getUniqueValue($realEstate)
    {
        // ToDo: Create specific method in model
        $interfaceMappingUniqueField = InterfaceMappingModel::findOneBy(array('pid=? && attribute=?'), array($this->objInterface->id, $this->objInterface->uniqueField));

        $groups = $realEstate->xpath($interfaceMappingUniqueField->oiFieldGroup);

        return $this->getFieldData($interfaceMappingUniqueField->oiField, $groups[0]);
    }

    protected function copyFile($fileName, $providerDirectoryName, $directoryName)
    {
        if (FilesHelper::isWritable($this->objFilesFolder->path))
        {
            $objFiles = \Files::getInstance();

            $filePathProvider = $this->objFilesFolder->path . '/' . $providerDirectoryName;
            $filePathRecord = $filePathProvider . '/' . $directoryName;
            $filePath = $filePathRecord . '/' . $fileName;

            if (!file_exists($filePathProvider))
            {
                mkdir($filePathProvider);
            }

            if (!file_exists($filePathRecord))
            {
                mkdir($filePathRecord);
            }

            $objFiles->copy($this->objImportFolder->path . '/tmp/' . $fileName, $filePath);

            $objFile = Dbafs::addResource($filePath);

            return $objFile;
        }
    }

    protected function getFieldData($field, $group)
    {
        $attr = false;
        $attr_pos = strrpos($field, '@');

        if ($attr_pos !== false)
        {
            $attr = substr($field, $attr_pos + 1);
            $field = substr($field, 0, $attr_pos);
        }

        $xmlNodes = $field === '' ? array($group) : $group->xpath($field);
        $results = array();

        foreach ($xmlNodes as $i => $xmlNode)
        {
            if ($attr)
            {
                $attributes = $xmlNode->attributes();

                switch ($attr)
                {
                    case '*':
                        // Returns a serialized array of all attributes.
                        $results[$i] = serialize(current($attributes));
                        break;
                    case '+':
                        // Returns a single name out of a set of attributes whose value is true.
                        foreach (current($attributes) as $index => $a) {
                            if ($a === 'true' || $a === '1') {
                                $results[$i] = $index;
                            }
                        }
                        break;
                    case '#':
                        // Returns a serialized array of attribute names whose values are true.
                        $tmp = [];
                        if ($attributes->count()) {
                            foreach (current($attributes) as $index => $a) {
                                if ($a === 'true' || $a === '1') {
                                    $tmp[] = $index;
                                }
                            }
                        }
                        $results[$i] = serialize($tmp);
                        break;
                    case '[1]':
                        // Returns the first child nodes name.
                        $index = 0;
                        foreach ($xmlNode->children() as $c) {
                            if ($index === 0) {
                                $results[$i] = $c->getName();
                            }
                            $index++;
                        }
                        break;
                    case '[2]':
                        // Returns the first child nodes name.
                        $index = 0;
                        foreach ($xmlNode->children() as $c) {
                            if ($index === 1) {
                                $results[$i] = $c->getName();
                            }
                            $index++;
                        }
                        break;
                    case '[3]':
                        // Returns the first child nodes name.
                        $index = 0;
                        foreach ($xmlNode->children() as $c) {
                            if ($index === 2) {
                                $results[$i] = $c->getName();
                            }
                            $index++;
                        }
                        break;
                    default:
                        // Returns the value of an XML element.
                        $results[$i] = current($attributes)[$attr];
                        break;
                }
            }
            else
            {
                if ($xmlNode->attributes()->count())
                {
                    $results[$i] = next($xmlNode);
                }
                else
                {
                    $results[$i] = current($xmlNode);
                }
            }
        }

        if (count($results) === 1)
        {
            // Trim strings
            if (is_string($results[0]))
            {
                $results[0] = trim($results[0]);
            }

            return $results[0];
        }
        elseif (count($results) > 1)
        {
            return serialize($results);
        }

        return null;
    }

    protected function getPath($group, $strPath)
    {
        $fieldPos = strrpos($strPath, '/');
        $field    = substr($strPath, $fieldPos + 1);
        $path     = substr($strPath, 0, $fieldPos);

        return array($group->xpath($path)[0], $field);
    }

    /**
     * Sync files with database
     *
     * @param string $file
     * @param string $filesPath
     *
     * @return boolean
     */
    protected function syncFiles($file, $filesPath)
    {
        $dataPath = dirname($file);

        $syncFiles = FilesHelper::scandirByExt($dataPath, array('jpg', 'jpeg', 'png', 'gif', 'pdf'));

        if (FilesHelper::isWritable($filesPath))
        {
            $objFiles = \Files::getInstance();

            foreach ($syncFiles as $file)
            {
                $strName = FilesHelper::filename($file);
                $objFiles->copy($dataPath . '/' . $strName, $filesPath . '/' . $strName);
                $objFiles->delete($dataPath . '/' . $strName);
            }

            $this->addLog(count($syncFiles) . ' files copied from "' . $dataPath . '" to "' . $filesPath . '".');

            \Dbafs::syncFiles();
        }
        else
        {
            $this->addLog('Cannot copy import files. Directory "' . $filesPath . '" is not writable.', 0, 'error');
            return false;
        }

        return true;
    }

    public static function sortFilesByTime($a, $b)
    {
        if ($a == $b) return 0;
        return ($a["time"] > $b["time"]) ? -1 : 1;
    }

    protected function addLog($strMessage, $level=0, $strType='raw', $data=null)
    {
        if($data !== null)
        {
            if(is_object($data))
            {
                $data = json_decode(json_encode($data), true);
            }

            $data = serialize($data);
        }

        $objLog = new InterfaceLogModel();
        $objLog->pid = $this->objInterface->id;
        $objLog->text = $strMessage;
        $objLog->data = $data;
        $objLog->action = $strType;
        $objLog->level = $level;
        $objLog->source = $this->syncFile;
        $objLog->tstamp = time();

        // ToDo: username= Username | Cron

        $objLog->save();
    }
}
