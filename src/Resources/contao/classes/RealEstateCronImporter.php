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


use Contao\Frontend;
use Contao\System;

/**
 * Handles real estate update cron jobs
 *
 * @author Fabian Ekert <https://github.com/eki89>
 */
class RealEstateCronImporter extends Frontend
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
                $minDiff = $timeDiff / 60;

                if ($minDiff - intval($objInterface->autoSync) >= 0)
                {
                    $this->sync($objInterface->current());
                }
            }
        }
    }

    /**
     * Synchronize an interface
     *
     * @param InterfaceModel $objInterface
     */
    protected function sync($objInterface)
    {
        // HOOK: add custom logic
        if (isset($GLOBALS['CEM_HOOKS']['realEstateImportBeforeCronSync']) && \is_array($GLOBALS['CEM_HOOKS']['realEstateImportBeforeCronSync']))
        {
            foreach ($GLOBALS['CEM_HOOKS']['realEstateImportBeforeCronSync'] as $callback)
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

        // ToDo: Use array_filter to remove duplicate files (may its possible if file is not completely transferred)

        $files = \array_slice(array_reverse($files), 0, $objInterface->filesPerSync);

        foreach ($files as $file)
        {
            $this->importer->importStatus = 1;
            $this->importer->importMessage = 'File imported';
            $this->importer->originalSyncFile = html_entity_decode($file['file']);
            $this->importer->startSync($this->importer->getSyncFile($this->importer->originalSyncFile));
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

        $days = intval($objInterface->deleteFilesOlderThen);
        $now = time();

        foreach($syncFiles as $syncFile)
        {
            $timeDiff = $now - $syncFile['time'];
            $daysDiff = $timeDiff / 60 / 60 / 24;

            if ($daysDiff > $days)
            {
                unlink(System::getContainer()->getParameter('kernel.project_dir') . '/' . $syncFile['file']);
            }
        }
    }
}
