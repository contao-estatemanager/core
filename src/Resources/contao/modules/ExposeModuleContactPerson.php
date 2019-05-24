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
 * Expose module "contact person".
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class ExposeModuleContactPerson extends ExposeModule
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'expose_mod_contactPerson';

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
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['contactPerson'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=expose_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
    }

    /**
     * Generate the module
     */
    protected function compile()
    {
        $arrFields = \StringUtil::deserialize($this->contactFields);

        $contactPerson = $this->realEstate->getContactPerson(!!$this->forceFullAddress);

        $addImage = false;

        foreach ($arrFields as $field)
        {
            if($field === 'foto')
            {
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
                            'size'       => $this->imgSize,
                        );

                        $this->addImageToTemplate($this->Template, $image, null, null, $objModel);
                    }

                    $this->Template->addImage = $addImage;
                }
            }
            else
            {
                if($contactPerson[ $field ])
                {
                    $this->Template->{$field} = $contactPerson[ $field ];
                }
            }
        }
    }
}