<?php
/**
 * Created by PhpStorm.
 * User: dscia
 * Date: 11.02.2019
 * Time: 15:36
 */

namespace Oveleon\ContaoImmoManagerBundle;


class ImmoManager
{

    public static function checkLicenses($licenceKey, $arrLicences){
        return in_array(md5($licenceKey), $arrLicences);
    }
}