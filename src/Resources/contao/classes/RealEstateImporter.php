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

        if (\Input::post('FORM_SUBMIT') === 'tl_real_estate_import' && ($this->syncFile = \Input::post('file')) !== '')
        {
            ini_set('max_execution_time', -1);

            if (($this->syncFile = $this->getSyncFile($this->objImportFolder->path, $this->syncFile)) !== false)
            {
                $this->addMessage('OpenImmo file: ' . $this->syncFile);

                if (($this->loadData()))
                {
                    $this->addMessage('OpenImmo data loaded');

                    if ($this->syncData())
                    {

                    }
                    else
                    {
                        $this->addMessage('OpenImmo data could not be synchronized.', 'error');
                    }
                }
                else
                {
                    $this->addMessage('OpenImmo data could not be loaded.', 'error');
                }
            }
            else
            {
                $this->addMessage('OpenImmo file could not be loaded.', 'error');
            }
        }

        $this->Template = new \BackendTemplate($this->strTemplate);

        $this->Template->setData(array
        (
            'syncAvailable' => $this->objInterface->type === 'wib',
            'syncUrl'       => 'syncUrl',
            'files'         => $this->getSyncFiles($this->objImportFolder->path)
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

        $arrSynced = array();

        $objHistory = InterfaceHistoryModel::findAll();

        if ($objHistory !== null)
        {
            while ($objHistory->next())
            {
                $arrSynced[$objHistory->file] = $objHistory->current();
            }
        }

        $arrFiles = array();
        $lasttime = time();

        $syncFiles = FilesHelper::scandirByExt($importPath, $searchForZip ? array('zip', 'xml') : array('xml'));

        foreach ($syncFiles as $i => $file)
        {
            $mtime = FilesHelper::fileModTime($file);
            $size = FilesHelper::fileSizeFormated($file);

            if (array_key_exists($file, $arrSynced))
            {
                $syncedMtime = intval($arrSynced[$file]->filetime);

                if ($syncedMtime > 0) {
                    $mtime = $syncedMtime;
                }

                $user = $arrSynced[$file]->user;
                $status = intval($arrSynced[$file]->status);
                $synctime = intval($arrSynced[$file]->synctime);
            }
            else
            {
                $user = '';
                $status = 0;
                $synctime = 0;
                if ($lasttime > $mtime) {
                    $lasttime = $mtime;
                }
            }

            $arrFiles[] = array(
                "file" => $file,
                "time" => $mtime,
                "size" => $size,
                "user" => $user,
                "status" => $status,
                "synctime" => $synctime,
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
                $this->addMessage('No OpenImmo file was found in archive.');
                return false;
            }

            if (count($syncFile) > 1)
            {
                $this->addMessage('More than one OpenImmo file was found in archive. Only one OpenImmo file is allowed per transfer.');
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
            $this->addMessage('Invalid OpenImmo data.', 'error');
            return false;
        }

        $arrProvider = $this->data->xpath('anbieter');

        if (count($arrProvider) === 0)
        {
            $this->addMessage('No provider data available.', 'error');
            return false;
        }

        $contactPersonRecords = array();
        $realEstateRecords = array();

        foreach ($arrProvider as $provider)
        {
            $uniqueProviderValue = trim(current($provider->anbieternr));

            if ($this->objInterface->anbieternr !== $uniqueProviderValue && !$this->objInterface->importThirdPartyProvider)
            {
                continue;
            }

            $arrRealEstate = $provider->xpath('immobilie');

            foreach ($arrRealEstate as $realEstate)
            {
                $uniqueValue = $this->getUniqueValue($realEstate);

                $contactPerson = array();
                $re = array();

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

                            if ($this->objInterface->type === 'wib')
                            {
                                $fileName = $this->getValueFromStringUrl($value, 'imageId');

                                $extension = $this->getExtension($format);
                                $completeFileName = $fileName . $extension;

                                $existingFile = FilesModel::findByPath($this->objFilesFolder->path . '/' . $uniqueProviderValue . '/' . $uniqueValue . '/' . $completeFileName);

                                if ($existingFile !== null && $existingFile->hash === $check)
                                {
                                    continue;
                                }

                                $this->downloadFile($value, $this->objImportFolder, $completeFileName);

                                $value = $completeFileName;
                            }
                            else
                            {
                                $existingFile = FilesModel::findByPath($this->objFilesFolder->path . '/' . $uniqueProviderValue . '/' . $uniqueValue . '/' . $value);

                                if ($existingFile !== null && $existingFile->hash === $check)
                                {
                                    continue;
                                }
                            }

                            $objFile = $this->copyFile($value, $uniqueProviderValue, $uniqueValue);

                            if (($titel = current($tmpGroup->anhangtitel)) !== '')
                            {
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

                $re['aktionart'] = current($realEstate->verwaltung_techn->aktion)['aktionart'];

                $contactPersonRecords[] = $contactPerson;
                $realEstateRecords[] = $re;
            }
        }

        $this->updateCatalog($contactPersonRecords, $realEstateRecords);
    }

    protected function getExtension($format)
    {
        $extension = '.jpg';

        switch ($format)
        {
            case 'image/jpeg':
            case 'image/jpg':
            case 'JPEG':
                $extension = '.jpg';
                break;
            case 'image/png':
                $extension = '.png';
                break;
            case 'image/gif':
                $extension = '.gif';
                break;
        }

        return $extension;
    }

    protected function updateCatalog($contactPersonRecords, $realEstateRecords)
    {
        $actions = \StringUtil::deserialize($this->objInterface->contactPersonActions, true);

        $allowCreate = in_array('create', $actions);
        $allowUpdate = in_array('update', $actions);

        foreach ($contactPersonRecords as $i => $contactPerson)
        {
            $arrColumns = array($this->objInterface->contactPersonUniqueField.'=?');
            $arrValues  = array($contactPerson[$this->objInterface->contactPersonUniqueField]);

            $exists = ContactPersonModel::countBy($arrColumns, $arrValues);

            // Skip if no contact person found and not allowed to create
            if (!$allowCreate && !$exists)
            {
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
            }


            $arrColumns = array($this->objInterface->uniqueField.'=?');
            $arrValues  = array($realEstateRecords[$i][$this->objInterface->uniqueField]);

            $exists = RealEstateModel::countBy($arrColumns, $arrValues);

            if (!$exists)
            {
                // Create new real estate
                $objRealEstate = new RealEstateModel();
                $objRealEstate->dateAdded = time();
            }
            else
            {
                // Find real estate
                $objRealEstate = RealEstateModel::findOneBy($arrColumns, $arrValues);

                if ($realEstateRecords[$i]['aktionart'] === 'DELETE')
                {
                    // Delete real estate
                    $objRealEstate->delete();
                    continue;
                }
            }

            foreach ($realEstateRecords[$i] as $field => $value)
            {
                $objRealEstate->{$field} = $value;
            }

            $objRealEstate->provider = $this->objInterface->provider;
            $objRealEstate->contactPerson = $objContactPerson->id;
            $objRealEstate->published = 1;

            $objRealEstate->save();
        }
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

    protected function downloadFile($path, $targetDirectory, $fileName)
    {
        $content = $this->getFileContent($path);

        \File::putContent($targetDirectory->path . '/tmp/' . $fileName, $content);
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
                elseif (boolval($value))
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

            $this->addMessage(count($syncFiles) . ' files copied from "' . $dataPath . '" to "' . $filesPath . '".');

            \Dbafs::syncFiles();
        }
        else
        {
            $this->addMessage('Cannot copy import files. Directory "' . $filesPath . '" is not writable.', 'error');
            return false;
        }

        return true;
    }

    public static function sortFilesByTime($a, $b)
    {
        if ($a == $b) return 0;
        return ($a["time"] > $b["time"]) ? -1 : 1;
    }

    protected function addMessage($strMessage, $strType='info')
    {
        $this->messages[] = array
        (
            'message' => $strMessage,
            'type'    => $strType
        );
    }
}
