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


/**
 * Handles real estate update cron jobs
 *
 * @author Fabian Ekert <fabian@oveleon.de>
 */
class RealEstateCronImporter extends \Frontend
{
    /**
     * @var RealEstateImporter
     */
    protected $importer;

    /**
     * Trigger interface synchronization
     */
    public function run()
    {
        $objInterface = InterfaceModel::findAll();

        if ($objInterface === null)
        {
            return;
        }

        while ($objInterface->next())
        {
            $this->importer = new RealEstateImporter();

            if (!$this->importer->initializeInterface($objInterface->id))
            {
                //$this->addLog('Interface could not been initialized.', 0, 'error');
                return;
            }

            if ($objInterface->deleteFilesOlderThen != 0)
            {
                $this->deleteFiles($objInterface->current());
            }

            if ($objInterface->autoSync > 0)
            {
                $timeDiff = time() - intval($objInterface->lastSync);

                if (($timeDiff / $objInterface->autoSync) >= 1)
                {
                    $this->sync();
                }
            }
        }
    }

    /**
     * Synchronize an interface
     */
    protected function sync()
    {
        // HOOK: add custom logic
        if (isset($GLOBALS['TL_HOOKS']['realEstateImportBeforeCronSync']) && \is_array($GLOBALS['TL_HOOKS']['realEstateImportBeforeCronSync']))
        {
            foreach ($GLOBALS['TL_HOOKS']['realEstateImportBeforeCronSync'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($this->importer);
            }
        }

        $this->importer->username = 'Cron';

        $files = array();
        $syncFiles = $this->importer->getSyncFiles();

        foreach ($syncFiles as $syncFile)
        {
            if ($syncFile['synctime'] === 0)
            {
                $files[] = $syncFile;
            }
        }

        $files = array_reverse($files);

        foreach ($files as $file)
        {
            $this->importer->startSync($this->importer->getSyncFile($file['file']));
        }
    }

    /**
     * Delete old sync files
     *
     * @param InterfaceModel $objInterface
     */
    protected function deleteFiles($objInterface)
    {
        $syncFiles = $this->importer->getSyncFiles();

        $days = intval($objInterface->deleteFilesOlderThen);#
        $now = time();

        foreach($syncFiles as $syncFile)
        {
            $timeDiff = $now - $syncFile['time'];
            $daysDiff = $timeDiff / 60 / 60 / 24;

            if ($daysDiff > $days)
            {
                unlink(TL_ROOT . '/' . $this->importer->importFolder->path . '/' . $syncFile['file']);
            }
        }
    }
}
