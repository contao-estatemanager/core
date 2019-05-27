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
    /**
     * Check Addon Licenses
     *
     * @param $licenceKey
     * @param $arrLicences
     * @param $strAddon
     * @return bool
     */
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

    /**
     * Import default field formats and actions
     *
     * @return string
     */
    public function importFieldFormats()
    {
        $bundleResources = \System::getContainer()->getParameter('kernel.project_dir') . '/vendor/contao-estatemanager/core/src/Resources';

        $importData = include $bundleResources . '/contao/data/import_field_formats.php';

        if ($importData != null && count($importData))
        {
            // delete actions
            $objFieldFormatActions = FieldFormatActionModel::findAll();
            if ($objFieldFormatActions != null)
            {
                do {
                    $objFieldFormatActions->delete();
                } while ($objFieldFormatActions->next());
            }

            // delete field formats
            $objFieldFormats = FieldFormatModel::findAll();
            if ($objFieldFormats != null)
            {
                do {
                    $objFieldFormats->delete();
                } while ($objFieldFormats->next());
            }

            foreach ($importData as $data)
            {
                $objFieldFormat = new FieldFormatModel();

                $objFieldFormat->tstamp = time();
                $objFieldFormat->fieldname = $data['field'][0];
                $objFieldFormat->cssClass = $data['field'][1];
                $objFieldFormat->useCondition = $data['field'][2];
                $objFieldFormat->conditionFields = $data['field'][3];

                $objFieldFormat = $objFieldFormat->save();
                $actionIndex = 0;

                foreach ($data['actions'] AS $actions)
                {
                    $objMarkupAction = new FieldFormatActionModel();

                    $objMarkupAction->pid = $objFieldFormat->id;
                    $objMarkupAction->tstamp = time();
                    $objMarkupAction->action = $actions[0];
                    $objMarkupAction->decimals = $actions[1];
                    $objMarkupAction->text = $actions[2];
                    $objMarkupAction->seperator = $actions[3];
                    $objMarkupAction->necessary = $actions[4];
                    $objMarkupAction->elements = \StringUtil::deserialize($actions[5]);
                    $objMarkupAction->customFunction = $actions[6];
                    $objMarkupAction->sorting = $actionIndex;

                    $objMarkupAction->save();

                    $actionIndex++;
                }
            }

            // Notify the user
            \Message::addConfirmation($GLOBALS['TL_LANG']['tl_field_format']['imported'][0]);
            $message = $GLOBALS['TL_LANG']['tl_field_format']['imported'][1];
        }else{
            // Notify the user
            \Message::addError($GLOBALS['TL_LANG']['tl_field_format']['import_error'][0]);
            $message = $GLOBALS['TL_LANG']['tl_field_format']['import_error'][1];
        }

        return \Message::generate() . '<div id="tl_buttons"><a href="/contao?do=field_format" class="header_back" title="'.\StringUtil::specialchars($GLOBALS['TL_LANG']['MSC']['backBTTitle']).'" accesskey="b">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a></div>' . ($message ? '<div class="tl_listing_container">' . $message . '</div>' : '');
    }
}
