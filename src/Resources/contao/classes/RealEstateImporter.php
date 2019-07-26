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
     * Import folder model for contact person
     * @var \FilesModel
     */
    protected $objFilesFolderContactPerson;

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
     * @var boolean
     */
    public $updateSyncTime = true;

    /**
     * @var string
     */
    protected $uniqueProviderValue;

    /**
     * @var string
     */
    protected $uniqueValue;

    /**
     * @var string
     */
    protected $username;

    /**
     * Set an object property
     *
     * @param string $strKey
     * @param mixed  $varValue
     */
    public function __set($strKey, $varValue)
    {
        switch ($strKey)
        {
            case 'username':
                $this->username = $varValue;
                break;
        }

        return parent::__set($strKey, $varValue);
    }

    /**
     * Return an object property
     *
     * @param string $strKey
     *
     * @return mixed
     */
    public function __get($strKey)
    {
        switch ($strKey)
        {
            case 'interface':
                return $this->objInterface;
                break;
            case 'importFolder':
                return $this->objImportFolder;
                break;
            case 'filesFolder':
                return $this->objFilesFolder;
                break;
            case 'filesFolderContactPerson':
                return $this->objFilesFolderContactPerson;
                break;
            case 'interfaceMapping':
                return $this->objInterfaceMapping;
                break;
            case 'uniqueProviderValue':
                return $this->uniqueProviderValue;
                break;
            case 'uniqueValue':
                return $this->uniqueValue;
                break;
            case 'username':
                return $this->username;
                break;
        }

        return parent::__get($strKey);
    }

    /**
     * Generate module
     */
    protected function compile() {}

    /**
     * Prepare interface, file models and interface mappings
     *
     * @param integer $id
     *
     * @return boolean
     */
    public function initializeInterface($id)
    {
        $this->objInterface = InterfaceModel::findByPk($id);

        if ($this->objInterface === null)
        {
            return false;
        }

        $this->objImportFolder = \FilesModel::findByUuid($this->objInterface->importPath);
        $this->objFilesFolder = \FilesModel::findByUuid($this->objInterface->filesPath);

        if ($this->objImportFolder === null || $this->objFilesFolder === null)
        {
            return false;
        }

        $this->objFilesFolderContactPerson = \FilesModel::findByUuid($this->objInterface->filesPathContactPerson);

        $this->objInterfaceMapping = InterfaceMappingModel::findByPid($id);

        if ($this->objInterfaceMapping === null)
        {
            return false;
        }

        return true;
    }

    /**
     * Syncs OpenImmo export data with database
     *
     * @param \DataContainer $dc
     *
     * @return string
     */
    public function sync($dc)
    {
        if (!$this->initializeInterface($dc->id))
        {
            //\Message::addInfo('Interface could not been initialized.');
            return;
        }

        // HOOK: add custom logic
        if (isset($GLOBALS['TL_HOOKS']['realEstateImportBeforeSync']) && \is_array($GLOBALS['TL_HOOKS']['realEstateImportBeforeSync']))
        {
            foreach ($GLOBALS['TL_HOOKS']['realEstateImportBeforeSync'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($this);
            }
        }

        $this->import('BackendUser', 'User');
        $this->username = $this->User->username;

        if (\Input::post('FORM_SUBMIT') === 'tl_real_estate_import' && ($this->syncFile = \Input::post('file')) !== '')
        {
            if (($this->syncFile = $this->getSyncFile($this->syncFile)) !== false)
            {
                $this->startSync();
            }
            else
            {
                //\Message::addError('OpenImmo file could not be loaded.');
                //$this->addLog('OpenImmo file could not be loaded.', 0, 'error');
            }
        }

        \System::loadLanguageFile('tl_real_estate_sync');

        $this->Template = new \BackendTemplate($this->strTemplate);

        $files = $this->getSyncFiles();

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
     * Syncs OpenImmo export data with database
     *
     * @param string $syncFile
     */
    public function startSync($syncFile='')
    {
        if ($syncFile !== '')
        {
            $this->syncFile = $syncFile;
        }

        @ini_set('max_execution_time', 0);

        // Consider the suhosin.memory_limit (see #7035)
        if (\extension_loaded('suhosin'))
        {
            if (($limit = ini_get('suhosin.memory_limit')) !== '')
            {
                @ini_set('memory_limit', $limit);
            }
        }
        else
        {
            @ini_set('memory_limit', -1);
        }

        //$this->addLog('Start import from file: ' . $this->syncFile, 0, 'success');

        if (($this->loadData()))
        {
            //$this->addLog('OpenImmo data loaded', 1, 'success');

            if ($this->syncData())
            {
                //$this->addLog('Import and synchronization was successful', 0, 'success');
                //\Message::addConfirmation('Import and synchronization was successful');
            }
            else
            {
                //$this->addLog('OpenImmo data could not be synchronized.', 0, 'error');
                //\Message::addError('OpenImmo data could not be synchronized.');
            }
        }
        else
        {
            //\Message::addError('OpenImmo data could not be loaded.');
            //$this->addLog('OpenImmo data could not be loaded.', 0, 'error');
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
            //$this->addLog('Invalid OpenImmo data.', 1, 'error');
            return false;
        }

        $arrProvider = $this->data->xpath('anbieter');

        if (count($arrProvider) === 0)
        {
            //$this->addLog('No provider data available.', 1, 'error');
            return false;
        }

        $contactPersonRecords = array();
        $realEstateRecords = array();

        foreach ($arrProvider as $provider)
        {
            $this->uniqueProviderValue = trim(current($provider->{$this->objInterface->uniqueProviderField}));

            if ($this->objInterface->anbieternr !== $this->uniqueProviderValue && !$this->objInterface->importThirdPartyProvider)
            {
                //$this->addLog('Skip real estate due to missing provider', 1, 'info');
                continue;
            }

            $arrRealEstate = $provider->xpath('immobilie');

            foreach ($arrRealEstate as $realEstate)
            {
                $skip = false;
                $this->uniqueValue = $this->getUniqueValue($realEstate);

                $contactPerson = array();
                $re = array
                (
                    'ANBIETER' => $this->uniqueProviderValue,
                    'AKTIONART' => current($realEstate->verwaltung_techn->aktion)['aktionart']
                );

                // HOOK: add custom logic
                if (isset($GLOBALS['TL_HOOKS']['realEstateImportPrePrepareRecord']) && \is_array($GLOBALS['TL_HOOKS']['realEstateImportPrePrepareRecord']))
                {
                    foreach ($GLOBALS['TL_HOOKS']['realEstateImportPrePrepareRecord'] as $callback)
                    {
                        $this->import($callback[0]);
                        $this->{$callback[0]}->{$callback[1]}($realEstate, $re, $contactPerson, $skip, $this);
                    }
                }

                if ($skip)
                {
                    continue;
                }

                //$this->addLog('Import real estate: ' . $this->uniqueValue, 1, 'highlight', $realEstate);

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
                                if ($interfaceMapping->forceActive)
                                {
                                    switch ($interfaceMapping->type)
                                    {
                                        case 'tl_contact_person':
                                            $contactPerson[$interfaceMapping->attribute] = $interfaceMapping->forceValue;
                                            break;
                                        case 'tl_real_estate':
                                            $re[$interfaceMapping->attribute] = $interfaceMapping->forceValue;
                                            break;
                                    }
                                }

                                continue;
                            }
                        }

                        $field = $interfaceMapping->oiField;

                        if (strrpos($field, '/') !== false)
                        {
                            $tmpGroup = $group;
                            list($group, $field) = $this->getPath($group, $field);
                        }

                        $value = $this->getFieldData($field, $group);

                        // Skip if value is not set
                        if ($value === null)
                        {
                            continue;
                        }

                        // Save image if needed
                        if ($re['AKTIONART'] !== 'DELETE' && $interfaceMapping->saveImage && !$this->saveImage($interfaceMapping, $tmpGroup, $value, $values))
                        {
                            continue;
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

    /**
     * Sync OpenImmo data with database
     *
     * @param array $contactPersonRecords
     * @param array $realEstateRecords
     *
     * @return boolean
     */
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

            if (!$exists && $realEstateRecords[$i]['AKTIONART'] === 'DELETE')
            {
                continue;
            }

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

            $this->loadDataContainer('tl_real_estate');

            // Trigger the save_callback
            if (\is_array($GLOBALS['TL_DCA']['tl_real_estate']['fields']['alias']['save_callback']))
            {
                $dc = new \stdClass();
                $dc->id = $objRealEstate->id;

                foreach ($GLOBALS['TL_DCA']['tl_real_estate']['fields']['alias']['save_callback'] as $callback)
                {
                    if (\is_array($callback))
                    {
                        $this->import($callback[0]);
                        $objRealEstate->alias = $this->{$callback[0]}->{$callback[1]}($objRealEstate->alias, $dc, $objRealEstate->objekttitel);
                    }
                    elseif (\is_callable($callback))
                    {
                        $objRealEstate->alias = $callback($objRealEstate->alias, $dc, $objRealEstate->objekttitel);
                    }
                }
            }

            $objRealEstate->save();
        }

        if ($this->updateSyncTime)
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

        // Create history entry
        $objInterfaceHistory = new InterfaceHistoryModel();
        $objInterfaceHistory->pid = $this->objInterface->id;
        $objInterfaceHistory->tstamp = time();
        $objInterfaceHistory->source = $this->syncFile;
        $objInterfaceHistory->action = 'SUCCESS';
        $objInterfaceHistory->username = $this->username;
        $objInterfaceHistory->text = 'Die Datei "' . $this->syncFile . '" wurde erfolgreich importiert.';
        $objInterfaceHistory->status = 1;
        $objInterfaceHistory->save();

        return true;
    }

    /**
     * Returns a list of syncable files
     *
     * @param boolean $searchForZip
     *
     * @return array
     */
    public function getSyncFiles($searchForZip=true)
    {
        try {
            $folder = new \Folder($this->objImportFolder->path);
        } catch (\Exception $e) {
            return array();
        }

        if ($folder->isEmpty())
        {
            return array();
        }

        $arrFiles = array();
        $lasttime = time();

        $syncFiles = FilesHelper::scandirByExt($this->objImportFolder->path, $searchForZip ? array('zip', 'xml') : array('xml'));

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

        usort($arrFiles, function($a, $b) {
            if ($a == $b) return 0;
            return ($a["time"] > $b["time"]) ? -1 : 1;
        });

        return $arrFiles;
    }

    public function getSyncFile($file)
    {
        if (FilesHelper::fileExt($file) === 'ZIP')
        {
            $this->unzipArchive($file);

            $syncFile = FilesHelper::scandirByExt($this->objImportFolder->path . '/tmp', array('xml'));

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

            return $this->getSyncFile($syncFile[0]);
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

    protected function getUniqueValue($realEstate)
    {
        // ToDo: Create specific method in model
        $interfaceMappingUniqueField = InterfaceMappingModel::findOneBy(array('pid=? && attribute=?'), array($this->objInterface->id, $this->objInterface->uniqueField));

        $groups = $realEstate->xpath($interfaceMappingUniqueField->oiFieldGroup);

        return $this->getFieldData($interfaceMappingUniqueField->oiField, $groups[0]);
    }

    public function getFieldData($field, $group)
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
                    case 'removespecialchar':
                        $value = $this->standardizeSpecialChars($value);
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
                        $value = '0';
                    }
                }
                elseif ($value && ($value === '1' || $value === 'true'))
                {
                    $value = '1';
                }
                else
                {
                    $value = '0';
                }
                break;
        }

        return $value;
    }

    protected function standardizeSpecialChars($content)
    {
        // Convert microsoft special characters
        $replace = array(
            "‘" => "'",
            "’" => "'",
            "”" => '"',
            "“" => '"',
            "" => '"',
            "" => '"',
            "–" => "-",
            "—" => "-",
            "" => "-",
            "…" => "&#8230;"
        );

        foreach($replace as $k => $v)
        {
            $content = str_replace($k, $v, $content);
        }

        // Remove any non-ascii character
        // $content = preg_replace('/[^\x20-\x7E]*/','', $content);

        return $content;
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

    /**
     * Download and save a file
     *
     * @return boolean
     */
    protected function saveImage($interfaceMapping, $tmpGroup, &$value, &$values)
    {
        $skip = false;

        $objFilesFolder = $interfaceMapping->attribute === 'tl_contact_person' ? $this->objFilesFolderContactPerson : $this->objFilesFolder;

        $check = next($tmpGroup->check);

        // HOOK: add custom logic
        if (isset($GLOBALS['TL_HOOKS']['realEstateImportSaveImage']) && \is_array($GLOBALS['TL_HOOKS']['realEstateImportSaveImage']))
        {
            foreach ($GLOBALS['TL_HOOKS']['realEstateImportSaveImage'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($objFilesFolder, $value, $tmpGroup, $values, $skip, $this);
            }
        }

        if ($skip)
        {
            return false;
        }

        $existingFile = \FilesModel::findByPath($objFilesFolder->path . '/' . $this->uniqueProviderValue . '/' . $this->uniqueValue . '/' . $value);

        if ($existingFile !== null && $existingFile->hash === $check)
        {
            $values[] = $existingFile->uuid;
            //$this->addLog('Skip image: ' . ($existingFile->hash === $check ? 'Image already exists and has not changed' : 'Image does not exist'), 3, 'info', array(
            //    'filePath' => $objFilesFolder->path . '/' . $this->uniqueProviderValue . '/' . $this->uniqueValue . '/',
            //    'fileName' => $value
            //));
            return false;
        }

        $objFile = $this->copyFile($value, $objFilesFolder, $this->uniqueProviderValue, $this->uniqueValue);

        // Delete file, if hash dont match
        if ($objFile->hash !== $check)
        {
            $objFile->delete();
            return false;
        }

        if (($titel = current($tmpGroup->anhangtitel)) !== '')
        {
            //$this->addLog('Image added: ' . $value, 3, 'success', array(
            //    'title' => $titel,
            //    'fileName' => $value
            //));

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

    protected function copyFile($fileName, $objFolder, $providerDirectoryName, $directoryName)
    {
        if (FilesHelper::isWritable($objFolder->path))
        {
            $objFiles = \Files::getInstance();

            $filePathProvider = $objFolder->path . '/' . $providerDirectoryName;
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

    protected function addLog($strMessage, $level=0, $strType='raw', $data=null)
    {
        // ToDo: In Datei auslagern
        return;

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
