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

class EstateManager
{
    public static function checkLicenses($licenceKey, $arrLicences, $strAddon){
        // Demo
        if (strtolower($licenceKey) === 'demo')
        {
            $expAddon = $strAddon . '_demo';
            $expTime  = \Config::get($expAddon);
            $curTime  = time();

            if (!$expTime)
            {
                \Config::persist($expAddon, $curTime);
                $expTime = $curTime;
            }

            return strtotime('+2 weeks', $expTime) > $curTime && $expTime <= $curTime;
        }

        // License
        return in_array(md5($licenceKey), $arrLicences);
    }
}
