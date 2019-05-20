<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerBundle;

class ImmoManager
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
