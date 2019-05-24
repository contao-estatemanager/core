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
            $items = $this->parseSlides($arrModules);

            $this->Template->gallery = $items;
        }
    }

    /**
     * Parse gallery
     *
     * @param array  $arrModules
     *
     * @return string
     */
    protected function parseSlides($arrModules)
    {
        $limit = null;
        $availableSlots = null;
        $arrSlides = array();

        if ($this->numberOfItems > 0)
        {
            $limit = $this->numberOfItems;
            $availableSlots = $limit;
        }

        // set custom template
        $strTemplate = $this->strItemTemplate;

        if ($this->galleryItemTemplate)
        {
            $strTemplate = $this->galleryItemTemplate;
        }

        // create Template
        $objTemplate = new \FrontendTemplate($strTemplate);

        // valid image fields
        $arrValidFields = array('titleImageSRC', 'imageSRC', 'planImageSRC', 'interiorViewImageSRC', 'exteriorViewImageSRC', 'mapViewImageSRC', 'panoramaImageSRC', 'epassSkalaImageSRC', 'logoImageSRC', 'qrImageSRC');

        foreach ($arrModules as $module)
        {
            if(in_array($module, $arrValidFields))
            {
                $arrImages = $this->realEstate->getImageBundle([$module], $availableSlots);
                $objFiles = \FilesModel::findMultipleByUuids($arrImages);

                // parse and add images to the slides array
                $this->parseImagesAndAddToSlides($objFiles, $arrSlides);

                // set new available slot count
                if($availableSlots !== null)
                {
                    $availableSlots -= count($arrImages);
                }
            }
            else
            {
                // HOOK: add custom logic for gallery single slide
                if (isset($GLOBALS['TL_HOOKS']['parseSlideExposeGallery']) && \is_array($GLOBALS['TL_HOOKS']['parseSlideExposeGallery']))
                {
                    foreach ($GLOBALS['TL_HOOKS']['parseSlideExposeGallery'] as $callback)
                    {
                        $this->import($callback[0]);
                        $this->{$callback[0]}->{$callback[1]}($objTemplate, $module, $arrSlides, $this->realEstate, $this);

                        // set new available slot count
                        if($availableSlots !== null)
                        {
                            $availableSlots--;
                        }
                    }
                }
            }

            if($availableSlots !== null && $availableSlots <= 0)
            {
                break;
            }
        }

        // HOOK: add custom logic for gallery slides
        if (isset($GLOBALS['TL_HOOKS']['parseSlidesExposeGallery']) && \is_array($GLOBALS['TL_HOOKS']['parseSlidesExposeGallery']))
        {
            foreach ($GLOBALS['TL_HOOKS']['parseSlidesExposeGallery'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($objTemplate, $arrSlides, $this->realEstate, $this);
            }
        }

        // set default image on empty
        if(!count($arrSlides))
        {
            if($this->gallerySkipOnEmpty)
            {
                $this->isEmpty = true;
                return '';
            }

            // get default image from local config
            $defaultImage = \Config::get('defaultImage');

            if($defaultImage)
            {
                // get default image
                $objFiles = \FilesModel::findMultipleByUuids([$defaultImage]);

                if($objFiles !== null)
                {
                    // add image to slides array
                    $this->parseImagesAndAddToSlides($objFiles, $arrSlides);
                }
            }

            if(!count($arrSlides))
            {
                $this->isEmpty = true;
                return '';
            }
        }

        $objTemplate->slides = $arrSlides;

        return $objTemplate->parse();
    }

    /**
     * Parse images and add them to the slides array
     *
     * @param $objFiles
     * @param $arrSlides
     */
    protected function parseImagesAndAddToSlides($objFiles, &$arrSlides)
    {
        if($objFiles !== null)
        {
            $arrImages = array();

            // parse images
            while ($objFiles->next())
            {
                // continue if the files has been processed or does not exist
                if (isset($arrImages[$objFiles->path]) || !file_exists(TL_ROOT . '/' . $objFiles->path)) {
                    continue;
                }

                $objFile = new \File($objFiles->path);

                if (!$objFile->isImage) {
                    continue;
                }

                // add the image
                $arrImages[$objFiles->path] = array
                (
                    'id' => $objFiles->id,
                    'uuid' => $objFiles->uuid,
                    'name' => $objFile->basename,
                    'singleSRC' => $objFiles->path,
                    'filesModel' => $objFiles->current(),
                    'size' => $this->imgSize,
                );

                $objCell = new \stdClass();
                $objCell->isImage = true;

                $this->addImageToTemplate($objCell, $arrImages[$objFiles->path], null, null, $arrImages[$objFiles->path]['filesModel']);

                $arrSlides[] = $objCell;
            }
        }
    }
}