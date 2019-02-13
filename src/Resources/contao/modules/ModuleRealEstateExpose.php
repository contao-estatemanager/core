<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerBundle;

use Patchwork\Utf8;

/**
 * Front end module "real estate expose".
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class ModuleRealEstateExpose extends ModuleRealEstate
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_realEstateExpose';

    /**
     * Real estate object
     * @var RealEstate
     */
    protected $realEstate;

    /**
     * Real estate type model
     * @var RealEstateTypeModel
     */
    protected $objRealEstateType;

    /**
     * Template
     * @var string
     */
    protected $strTable = 'tl_real_estate';

    /**
     * Do not display the module if there are no real etates
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['realEstateExpose'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        // Set the item from the auto_item parameter
        if (!isset($_GET['items']) && \Config::get('useAutoItem') && isset($_GET['auto_item']))
        {
            \Input::setGet('items', \Input::get('auto_item'));
        }

        // Return an empty string if "items" is not set (to combine list and reader on same page)
        if (!\Input::get('items'))
        {
            return '';
        }

        \System::loadLanguageFile('tl_real_estate_expose');

        // HOOK: real estate expose generate
        if (isset($GLOBALS['TL_HOOKS']['generateExpose']) && \is_array($GLOBALS['TL_HOOKS']['generateExpose']))
        {
            foreach ($GLOBALS['TL_HOOKS']['generateExpose'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($this);
            }
        }

        return parent::generate();
    }

    /**
     * Generate the module
     */
    protected function compile()
    {
        /** @var \PageModel $objPage */
        global $objPage;

        $objRealEstate = RealEstateModel::findPublishedByIdOrAlias(\Input::get('items'));

        $this->realEstate = new RealEstate($objRealEstate, null);
        $this->objRealEstateType = $this->realEstate->getType();

        $this->Template->realEstateId = $objRealEstate->id;

        $this->updateVisitedSession($objRealEstate->id);

        $this->Template->gallery = $this->parseGallery($this->realEstate);
        $this->Template->floorPlanGallery = $this->parseFloorPlanGallery($this->realEstate);
        $this->Template->title = $this->realEstate->getTitle();
        $this->Template->address = $this->realEstate->getLocationString();
        $this->Template->mainDetails = $this->realEstate->getMainDetails(6);
        $this->Template->mainAttributes = $this->realEstate->getMainAttributes();
        $this->Template->mainPrice = $this->realEstate->getMainPrice();
        $this->Template->mainArea = $this->realEstate->getMainArea();
        $this->Template->details = $this->realEstate->getDetails(['price', 'energie'], true);
        $this->Template->texts = $this->realEstate->getTexts();
        $this->Template->form = $this->parseForm();
        $this->Template->contactPerson = $this->parseContactPerson();

        $this->Template->links = $this->realEstate->links;

        $this->Template->referer = 'javascript:history.go(-1)';
        $this->Template->back = $GLOBALS['TL_LANG']['MSC']['goBack'];

        $this->Template->headlineDetails = Translator::translateExpose('headlineDetails');
        $this->Template->headlinePrice = Translator::translateExpose('headlinePrice');
        $this->Template->headlineEnergiepass = Translator::translateExpose('headlineEnergiepass');
        $this->Template->headlineSimilarObjects = Translator::translateExpose('headlineSimilarObjects');
        $this->Template->headlineFutherLinks = Translator::translateExpose('headlineFutherLinks');
        $this->Template->headlineFloorPlans = Translator::translateExpose('headlineFloorPlans');
        $this->Template->headlineContactPerson = Translator::translateExpose('headlineContactPerson');
        $this->Template->headlineVirtualTour = Translator::translateExpose('headlineVirtualTour');

        $this->Template->optionPrint = Translator::translateExpose('optionPrint');
    }

    /**
     * Parse properties contact person
     *
     * @return string
     */
    protected function parseContactPerson(){
        $contactPerson = $this->realEstate->getContactPerson();
        $strTemplate = 'real_estate_contact_person_default';

        // Use a custom template
        if ($this->realEstateContactPersonTemplate != '')
        {
            $strTemplate = $this->realEstateContactPersonTemplate;
        }

        $objTemplate = new \FrontendTemplate($strTemplate);
        $objTemplate->setData($contactPerson);

        $addImage = false;

        if ($contactPerson['singleSRC'] != '')
        {

            $objModel = \FilesModel::findByUuid($contactPerson['singleSRC']);

            if ($objModel !== null && is_file(TL_ROOT . '/' . $objModel->path))
            {
                $addImage = true;
                $image = array
                (
                    'id'         => $objModel->id,
                    'uuid'       => $objModel->uuid,
                    'name'       => $objModel->basename,
                    'singleSRC'  => $objModel->path,
                    'filesModel' => $objModel->current(),
                    'size'       => $this->contactPersonImgSize,
                );

                $this->addImageToTemplate($objTemplate, $image, null, null, $objModel);
            }
        }

        $objTemplate->addImage = $addImage;

        return $objTemplate->parse();
    }

    /**
     * Parse properties gallery
     *
     * @return string
     */
    protected function parseGallery($realEstate)
    {
        $images = array();
        $body = array();
        $objFiles = \FilesModel::findMultipleByUuids($realEstate->getImageBundle());

        if($objFiles === null)
        {
            // Set default image
            $defaultImage = \Config::get('defaultImage');

            if($defaultImage)
            {
                $objFiles = \FilesModel::findMultipleByUuids([$defaultImage]);
            }

            if($objFiles === null){
                return '';
            }
        }

        // Get all images
        while ($objFiles->next())
        {
            // Continue if the files has been processed or does not exist
            if (isset($images[$objFiles->path]) || !file_exists(TL_ROOT . '/' . $objFiles->path))
            {
                continue;
            }

            $objFile = new \File($objFiles->path);

            if (!$objFile->isImage)
            {
                continue;
            }

            // Add the image
            $images[$objFiles->path] = array
            (
                'id'         => $objFiles->id,
                'uuid'       => $objFiles->uuid,
                'name'       => $objFile->basename,
                'singleSRC'  => $objFiles->path,
                'filesModel' => $objFiles->current(),
                'size'       => $this->realEstateGalleryImgSize,
            );

            $objCell = new \stdClass();

            $this->addImageToTemplate($objCell, $images[$objFiles->path], null, null, $images[$objFiles->path]['filesModel']);

            $body[] = $objCell;
        }

        $strTemplate = 'real_estate_gallery_default';

        // Use a custom template
        if ($this->realEstateGalleryTemplate != '')
        {
            $strTemplate = $this->realEstateGalleryTemplate;
        }

        $objTemplate = new \FrontendTemplate($strTemplate);
        $objTemplate->body = $body;

        return $objTemplate->parse();
    }

    /**
     * Parse properties floor plan
     *
     * @return string
     */
    protected function parseFloorPlanGallery($realEstate)
    {
        $images = array();
        $body = array();
        $objFiles = \FilesModel::findMultipleByUuids($realEstate->getFloorPlanImages());

        if($objFiles === null)
        {
            return '';
        }

        // Get all images
        while ($objFiles->next())
        {
            // Continue if the files has been processed or does not exist
            if (isset($images[$objFiles->path]) || !file_exists(TL_ROOT . '/' . $objFiles->path))
            {
                continue;
            }

            $objFile = new \File($objFiles->path);

            if (!$objFile->isImage)
            {
                continue;
            }

            // Add the image
            $images[$objFiles->path] = array
            (
                'id'         => $objFiles->id,
                'uuid'       => $objFiles->uuid,
                'name'       => $objFile->basename,
                'singleSRC'  => $objFiles->path,
                'filesModel' => $objFiles->current(),
                'size'       => $this->floorPlanImgSize,
            );

            $objCell = new \stdClass();

            $this->addImageToTemplate($objCell, $images[$objFiles->path], null, null, $images[$objFiles->path]['filesModel']);

            $body[] = $objCell;
        }

        $strTemplate = 'real_estate_gallery_default';

        // Use a custom template
        if ($this->realEstateFloorPlanGalleryTemplate != '')
        {
            $strTemplate = $this->realEstateFloorPlanGalleryTemplate;
        }

        $objTemplate = new \FrontendTemplate($strTemplate);
        $objTemplate->body = $body;

        return $objTemplate->parse();
    }

    /**
     * Parse the contact person form
     *
     * @return string
     */
    protected function parseForm()
    {
        $objForm = \FormModel::findByPk($this->form);

        if ($objForm === null)
        {
            return '';
        }

        $form = new ExposeForm($objForm);

        $form->setStrKey('form');

        return $form->generate();
    }

    /**
     * Count the total matching items
     *
     * @return integer
     */
    protected function countItems()
    {
        list($arrColumns, $arrValues, $arrOptions) = $this->getFilterOptions();

        return RealEstateModel::countBy($arrColumns, $arrValues, $arrOptions);
    }

    /**
     * Fetch the matching items
     *
     * @param integer $limit
     * @param integer $offset
     *
     * @return \Model\Collection|RealEstateModel|null
     */
    protected function fetchItems($limit, $offset)
    {
        list($arrColumns, $arrValues, $arrOptions) = $this->getFilterOptions();

        $arrOptions['limit']  = $limit;
        $arrOptions['offset'] = $offset;

        return RealEstateModel::findBy($arrColumns, $arrValues, $arrOptions);
    }

    /**
     * Collect necessary filter parameter for similar real estates and return it as array
     *
     * @return array
     */
    protected function getFilterOptions()
    {
        $t = $this->strTable;

        $arrColumns = array("$t.published='1'");
        $arrValues = array();
        $arrOptions = array();

        $arrColumns[] = "$t.id!=?";
        $arrValues[] = $this->realEstate->getId();

        if (!empty($this->objRealEstateType->nutzungsart))
        {
            $arrColumns[] = "$t.nutzungsart=?";
            $arrValues[] = $this->objRealEstateType->nutzungsart;
        }
        if ($this->objRealEstateType->vermarktungsart === 'kauf_erbpacht')
        {
            $arrColumns[] = "($t.vermarktungsartKauf='1' OR $t.vermarktungsartErbpacht='1')";
        }
        if ($this->objRealEstateType->vermarktungsart === 'miete_leasing')
        {
            $arrColumns[] = "($t.vermarktungsartMietePacht='1' OR $t.vermarktungsartLeasing='1')";
        }
        if (!empty($this->objRealEstateType->objektart))
        {
            $arrColumns[] = "$t.objektart=?";
            $arrValues[] = $this->objRealEstateType->objektart;
        }

        if ($_SESSION['FILTER_DATA']['price_from'])
        {
            $arrColumns[] = "$t.".$this->objRealEstateType->price.">=?";
            $arrValues[] = $_SESSION['FILTER_DATA']['price_from'];
        }
        if ($_SESSION['FILTER_DATA']['price_to'])
        {
            $arrColumns[] = "$t.".$this->objRealEstateType->price."<=?";
            $arrValues[] = $_SESSION['FILTER_DATA']['price_to'];
        }
        if ($_SESSION['FILTER_DATA']['room_from'])
        {
            $arrColumns[] = "$t.anzahlZimmer>=?";
            $arrValues[] = $_SESSION['FILTER_DATA']['room_from'];
        }
        if ($_SESSION['FILTER_DATA']['room_to'])
        {
            $arrColumns[] = "$t.anzahlZimmer<=?";
            $arrValues[] = $_SESSION['FILTER_DATA']['room_to'];
        }
        if ($_SESSION['FILTER_DATA']['area_from'])
        {
            $arrColumns[] = "$t.".$this->objRealEstateType->area.">=?";
            $arrValues[] = $_SESSION['FILTER_DATA']['area_from'];
        }
        if ($_SESSION['FILTER_DATA']['area_to'])
        {
            $arrColumns[] = "$t.".$this->objRealEstateType->area."<=?";
            $arrValues[] = $_SESSION['FILTER_DATA']['area_to'];
        }

        return array($arrColumns, $arrValues, $arrOptions);
    }
}