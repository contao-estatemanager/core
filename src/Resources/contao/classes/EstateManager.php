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

use Contao\Config;
use Contao\Dbafs;
use Contao\Files;
use Contao\FilesModel;
use Contao\Input;
use Contao\Message;
use Contao\System;

/**
 * Collection of core functions for EstateManager.
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class EstateManager
{
    /**
     * Check Addon Licenses
     *
     * @param $licenceKey
     * @param $arrLicences
     * @param $strAddon
     *
     * @return bool
     */
    public static function checkLicenses($licenceKey, $arrLicences, $strAddon){
        if (strtolower($licenceKey) === 'demo')
        {
            $expAddon = $strAddon . '_demo';
            $expTime  = Config::get($expAddon);
            $curTime  = time();

            if (!$expTime)
            {
                Config::persist($expAddon, $curTime);
                $expTime = $curTime;
            }

            return strtotime('+2 weeks', $expTime) > $curTime && $expTime <= $curTime;
        }

        return in_array(md5($licenceKey), $arrLicences);
    }

    /**
     * Import default field formats and actions
     *
     * @return string
     */
    public function importFieldFormats()
    {
        $bundleResources = System::getContainer()->getParameter('kernel.project_dir') . '/vendor/contao-estatemanager/core/src/Resources';

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
                $objFieldFormat->fieldname = $data['field'][0] ?? '';
                $objFieldFormat->cssClass = $data['field'][1] ?? '';
                $objFieldFormat->useCondition = $data['field'][2] ?? '';
                $objFieldFormat->conditionFields = $data['field'][3] ?? '';
                $objFieldFormat->forceOutput = $data['field'][4] ?? '';

                $objFieldFormat = $objFieldFormat->save();
                $actionIndex = 0;

                if($data['actions'] != null)
                {
                    foreach ($data['actions'] AS $actions)
                    {
                        $objMarkupAction = new FieldFormatActionModel();

                        $objMarkupAction->pid = $objFieldFormat->id;
                        $objMarkupAction->tstamp = time();
                        $objMarkupAction->action = $actions[0] ?? '';
                        $objMarkupAction->decimals = $actions[1] ?? '';
                        $objMarkupAction->text = $actions[2] ?? '';
                        $objMarkupAction->seperator = $actions[3] ?? '';
                        $objMarkupAction->necessary = $actions[4] ?? '';
                        $objMarkupAction->elements = \StringUtil::deserialize($actions[5]);
                        $objMarkupAction->customFunction = $actions[6] ?? '';
                        $objMarkupAction->sorting = $actionIndex ?? '';

                        $objMarkupAction->save();

                        $actionIndex++;
                    }
                }
            }

            Message::addConfirmation($GLOBALS['TL_LANG']['tl_field_format']['imported'][0]);
            $message = $GLOBALS['TL_LANG']['tl_field_format']['imported'][1];
        }else{
            Message::addError($GLOBALS['TL_LANG']['tl_field_format']['import_error'][0]);
            $message = $GLOBALS['TL_LANG']['tl_field_format']['import_error'][1];
        }

        return \Message::generate() . '<div id="tl_buttons"><a href="/contao?do=field_format" class="header_back" title="'.\StringUtil::specialchars($GLOBALS['TL_LANG']['MSC']['backBTTitle']).'" accesskey="b">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a></div>' . ($message ? '<div class="tl_listing_container">' . $message . '</div>' : '');
    }

    /**
     * Resotes interface default mappings
     *
     * @return string
     */
    public function importDefaultMappings()
    {
        $bundleResources = System::getContainer()->getParameter('kernel.project_dir') . '/vendor/contao-estatemanager/core/src/Resources';

        $importData = include $bundleResources . '/contao/data/import_interface_mappings.php';

        $pid = Input::get('id');

        if ($importData != null && count($importData))
        {
            // Delete all existing mappings of interface
            if (($objInterfaceMappings = InterfaceMappingModel::findByPid($pid)) != null)
            {
                while ($objInterfaceMappings->next())
                {
                    $objInterfaceMappings->delete();
                }
            }

            foreach ($importData as $data)
            {
                $objInterfaceMapping = new InterfaceMappingModel();

                $objInterfaceMapping->pid = $pid;
                $objInterfaceMapping->tstamp = time();
                $objInterfaceMapping->type = $data[0];
                $objInterfaceMapping->attribute = $data[1];
                $objInterfaceMapping->oiFieldGroup = $data[2];
                $objInterfaceMapping->oiField = $data[3];

                // format action
                if(isset($data[4]))
                {
                    $objInterfaceMapping->formatType = $data[4][0] ?? '';

                    switch($data[4][0])
                    {
                        case 'boolean':
                            $objInterfaceMapping->booleanCompareValue = $data[4][1] ?? '';
                            break;
                        case 'number':
                            $objInterfaceMapping->decimals = $data[4][1] ?? '';
                            break;
                        case 'date':
                            $objInterfaceMapping->dateFormat = $data[4][1] ?? '';
                            break;
                        case 'text':
                            $objInterfaceMapping->textTransform = $data[4][1] ?? '';
                            break;
                    }
                }

                // condition
                if(isset($data[5]))
                {
                    $objInterfaceMapping->oiConditionField = $data[5][0] ?? '';
                    $objInterfaceMapping->oiConditionValue = $data[5][1] ?? '';
                }

                // serialize
                if(isset($data[6]))
                {
                    $objInterfaceMapping->serialize = $data[6];
                }

                // save
                if(isset($data[7]))
                {
                    $objInterfaceMapping->saveImage = true;
                }

                $objInterfaceMapping->save();
            }

            Message::addConfirmation($GLOBALS['TL_LANG']['tl_interface_mapping']['imported'][0]);
            $message = $GLOBALS['TL_LANG']['tl_interface_mapping']['imported'][1];
        }
        else
        {
            Message::addError($GLOBALS['TL_LANG']['tl_interface_mapping']['import_error'][0]);
            $message = $GLOBALS['TL_LANG']['tl_interface_mapping']['import_error'][1];
        }

        return Message::generate() . '<div id="tl_buttons"><a href="/contao?do=interface" class="header_back" title="'.\StringUtil::specialchars($GLOBALS['TL_LANG']['MSC']['backBTTitle']).'" accesskey="b">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a></div>' . ($message ? '<div class="tl_listing_container">' . $message . '</div>' : '');
    }

    public function clearRealEstates()
    {
        $objInterface = InterfaceModel::findByPk(Input::get('id'));

        if ($objInterface === null)
        {
            return;
        }

        $objRealEstates = RealEstateModel::findAll();

        if ($objRealEstates === null)
        {
            return;
        }

        $arrUnique = array();

        while ($objRealEstates->next())
        {
            $arrUnique[] = $objRealEstates->objektnrIntern;
        }

        $filesHandler = Files::getInstance();

        $objFilesPath = FilesModel::findByUuid($objInterface->filesPath);

        $arrProviderFolder = scandir(TL_ROOT . '/' . $objFilesPath->path);

        foreach ($arrProviderFolder as $providerFolder)
        {
            if ($providerFolder === '.' || $providerFolder === '..')
            {
                continue;
            }

            $arrRealEstateFolder = scandir(TL_ROOT . '/' . $objFilesPath->path . '/' . $providerFolder);

            foreach ($arrRealEstateFolder as $realEstateFolder)
            {
                if ($realEstateFolder === '.' || $realEstateFolder === '..')
                {
                    continue;
                }

                if (!in_array($realEstateFolder, $arrUnique))
                {
                    $deleteFolder = $objFilesPath->path . '/' . $providerFolder . '/' . $realEstateFolder;

                    $filesHandler->rrdir($deleteFolder);
                    Dbafs::deleteResource($deleteFolder);
                }
            }
        }
    }
}
