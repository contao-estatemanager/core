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
class CronHandler extends \Frontend
{
    public function run()
    {
        $objInterface = InterfaceModel::findAll();

        if ($objInterface === null)
        {
            return;
        }

        while ($objInterface->next())
        {
            if ($objInterface->autoSync !== 'never')
            {
                $needsSync = false;
                $timeDiff = time() - intval($objInterface->lastSync);

                switch ($objInterface->autoSync)
                {
                    case '10min':
                        if (($timeDiff / 600) >= 1) $needsSync = true;
                        break;
                    case '30min':
                        if (($timeDiff / 1800) >= 1) $needsSync = true;
                        break;
                    case 'hourly':
                        if (($timeDiff / 3600) >= 1) $needsSync = true;
                        break;
                    case 'daily':
                        if (($timeDiff / 86400) >= 1) $needsSync = true;
                        break;
                    case 'weekly':
                        if (($timeDiff / 604800) >= 1) $needsSync = true;
                        break;
                }

                if ($needsSync)
                {
                    $this->sync($objInterface->current());
                }
            }
        }
    }

    protected function sync($objInterface)
    {
        $importer = new RealEstateImporter();

        \Input::setPost('FORM_SUBMIT', 'tl_real_estate_import');

        if ($objInterface->type === 'wib')
        {
            \Input::setGet('downloadWibXml', 1);
            $importer->sync($objInterface, true);
        }

        if ($objInterface->type === 'openimmo')
        {

        }
    }
}
