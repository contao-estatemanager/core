<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerBundle;

/**
 * Expose module "gallery".
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class ExposeModuleGallery extends ExposeModule
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'expose_mod_gallery';

    /**
     * Template for gallery items
     * @var string
     */
    protected $strItemTemplate = 'expose_mod_gallery_items';

    /**
     * Do not display the module if there are no real estate
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['gallery'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=expose_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        $strBuffer = parent::generate();
        return $this->isEmpty ? '' : $strBuffer;
    }

    /**
     * Generate the module
     */
    protected function compile()
    {
        $arrModules = \StringUtil::deserialize($this->galleryModules);

        if($arrModules)
        {
            $items = $this->parseGallery($arrModules);

            $this->Template->images = $items;
        }
    }

    /**
     * Parse gallery
     *
     * @param array  $arrModules
     *
     * @return string
     */
    protected function parseGallery($arrModules)
    {
        $limit = null;

        if ($this->numberOfItems > 0)
        {
            $limit = $this->numberOfItems;
        }

        $arrImages = $this->realEstate->getImageBundle($arrModules, $limit);

        $objFiles = \FilesModel::findMultipleByUuids($arrImages);

        // set default image
        if($objFiles === null)
        {
            if($this->gallerySkipOnEmpty)
            {
                $this->isEmpty = true;
                return '';
            }

            $defaultImage = \Config::get('defaultImage');

            if($defaultImage)
            {
                $objFiles = \FilesModel::findMultipleByUuids([$defaultImage]);
            }

            if($objFiles === null){
                $this->isEmpty = true;
                return '';
            }
        }

        $images = array();
        $body = array();

        // parse images
        while ($objFiles->next())
        {
            // continue if the files has been processed or does not exist
            if (isset($images[$objFiles->path]) || !file_exists(TL_ROOT . '/' . $objFiles->path))
            {
                continue;
            }

            $objFile = new \File($objFiles->path);

            if (!$objFile->isImage)
            {
                continue;
            }

            // add the image
            $images[$objFiles->path] = array
            (
                'id'         => $objFiles->id,
                'uuid'       => $objFiles->uuid,
                'name'       => $objFile->basename,
                'singleSRC'  => $objFiles->path,
                'filesModel' => $objFiles->current(),
                'size'       => $this->imgSize,
            );

            $objCell = new \stdClass();

            $this->addImageToTemplate($objCell, $images[$objFiles->path], null, null, $images[$objFiles->path]['filesModel']);

            $body[] = $objCell;
        }

        // set custom template
        if ($this->galleryItemTemplate)
        {
            $strTemplate = $this->galleryItemTemplate;
        }
        else
        {
            $strTemplate = $this->strItemTemplate;
        }

        // create Template
        $objTemplate = new \FrontendTemplate($strTemplate);
        $objTemplate->body = $body;

        return $objTemplate->parse();
    }
}