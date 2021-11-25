<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

Contao\System::loadLanguageFile('tl_real_estate_misc');
Contao\System::loadLanguageFile('tl_contact_person');
Contao\System::loadLanguageFile('tl_real_estate');

$GLOBALS['TL_DCA']['tl_expose_module'] = array
(

    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'enableVersioning'            => true,
        'markAsCopy'                  => 'name',
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary'
            )
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 2,
            'fields'                  => array('name'),
            'flag'                    => 1,
            'panelLayout'             => 'filter;sort,search,limit'
        ),
        'label' => array
        (
            'fields'                  => array('name', 'type'),
            'format'                  => '<div class="tl_content_left">%s <span style="color:#999;padding-left:3px">[%s]</span></div>'
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_expose_module']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.svg'
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_expose_module']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.svg'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_expose_module']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.svg',
                'attributes'          => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\'))return false;Backend.getScrollOffset()"'
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_expose_module']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.svg'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        '__selector__'                => array('type', 'attachFeedbackXml', 'protected', 'addHeadings', 'attachmentType'),
        'default'                     => '{title_legend},name,headline,type',
        'title'                       => '{title_legend},name,headline,type;{settings_legend},fontSize;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID',
        'address'                     => '{title_legend},name,headline,type;{settings_legend},forceFullAddress;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID',
        'gallery'                     => '{title_legend},name,headline,type;{settings_legend},galleryModules,numberOfItems,fullsize,gallerySkipOnEmpty;{image_legend:hide},imgSize;{template_legend:hide},customTpl,galleryItemTemplate;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID',
        'details'                     => '{title_legend},name,headline,type;{settings_legend},detailBlocks,summariseDetailBlocks,includeAddress,addHeadings;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID',
        'mainDetails'                 => '{title_legend},name,headline,type;{settings_legend},numberOfItems;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID',
        'mainAttributes'              => '{title_legend},name,headline,type;{settings_legend},numberOfItems;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID',
        'mainPrice'                   => '{title_legend},name,headline,type;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID',
        'mainArea'                    => '{title_legend},name,headline,type;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID',
        'statusToken'                 => '{title_legend},name,headline,type;{settings_legend},statusTokens;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID',
        'marketingToken'              => '{title_legend},name,headline,type;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID',
        'texts'                       => '{title_legend},name,headline,type;{settings_legend},textBlocks,maxTextLength,addHeadings,hideOnEmpty;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID',
        'fieldList'                   => '{title_legend},name,headline,type;{settings_legend},fields;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID',
        'contactPerson'               => '{title_legend},name,headline,type;{settings_legend},contactFields,forceFullAddress,useProviderForwarding;{image_legend:hide},imgSize;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID',
        'enquiryForm'                 => '{title_legend},name,headline,type;{settings_legend},form,hideOnReferences,attachFeedbackXml;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID',
        'share'                       => '{title_legend},name,headline,type;{settings_legend},share;{template_legend:hide},customTpl,shareEmailTemplate;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID',
        'print'                       => '{title_legend},name,headline,type;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID',
        'html'                        => '{title_legend},name,headline,type;{settings_legend},html;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests',
        'attachments'                 => '{title_legend},name,headline,type;{settings_legend},attachmentType;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID'
    ),

    // Subpalettes
    'subpalettes' => array
    (
        'attachFeedbackXml'           => 'feedbackXmlTemplate',
        'protected'                   => 'groups',
        'addHeadings'                 => 'fontSize',
        'attachmentType_documents'    => 'allowedFileExtensions,forceDownload'
    ),

    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'name' => array
        (
            'exclude'                 => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'headline' => array
        (
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'inputUnit',
            'options'                 => array('h1', 'h2', 'h3', 'h4', 'h5', 'h6'),
            'eval'                    => array('maxlength'=>200, 'tl_class'=>'w50 clr'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'type' => array
        (
            'default'                 => 'title',
            'exclude'                 => true,
            'sorting'                 => true,
            'flag'                    => 11,
            'filter'                  => true,
            'inputType'               => 'select',
            'options_callback'        => array('tl_expose_module', 'getExposeModules'),
            'reference'               => &$GLOBALS['TL_LANG']['FMD'],
            'eval'                    => array('helpwizard'=>true, 'chosen'=>true, 'submitOnChange'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'customTpl' => array
        (
            'exclude'                 => true,
            'inputType'               => 'select',
            'options_callback'        => array('tl_expose_module', 'getExposeModuleTemplates'),
            'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'protected' => array
        (
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('submitOnChange'=>true),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'groups' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'foreignKey'              => 'tl_member_group.name',
            'eval'                    => array('mandatory'=>true, 'multiple'=>true),
            'sql'                     => "blob NULL",
            'relation'                => array('type'=>'hasMany', 'load'=>'lazy')
        ),
        'guests' => array
        (
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'checkbox',
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'cssID' => array
        (
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('multiple'=>true, 'size'=>2, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'fontSize' => array
        (
            'exclude'                 => true,
            'inputType'               => 'select',
            'options'                 => array('h1', 'h2', 'h3', 'h4', 'h5', 'h6'),
            'eval'                    => array('tl_class'=>'w50', 'mandatory'=>true),
            'sql'                     => "varchar(2) NOT NULL default ''"
        ),
        'forceFullAddress' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50 m12'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'galleryModules' => array
        (
            'default'                 => array('titleImageSRC', 'imageSRC'),
            'exclude'                 => true,
            'inputType'               => 'checkboxWizard',
            'options'                 => array('titleImageSRC', 'imageSRC', 'planImageSRC', 'interiorViewImageSRC', 'exteriorViewImageSRC', 'mapViewImageSRC', 'panoramaImageSRC', 'epassSkalaImageSRC', 'logoImageSRC', 'qrImageSRC'),
            'eval'                    => array('mandatory'=>true, 'multiple'=>true),
            'reference'               => &$GLOBALS['TL_LANG']['FMD'],
            'sql'                     => "blob NULL"
        ),
        'galleryItemTemplate' => array
        (
            'exclude'                 => true,
            'inputType'               => 'select',
            'options_callback'        => array('tl_expose_module', 'getGalleryItemTemplates'),
            'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'gallerySkipOnEmpty' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50 m12'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'imgSize' => array
        (
            'exclude'                 => true,
            'inputType'               => 'imageSize',
            'reference'               => &$GLOBALS['TL_LANG']['MSC'],
            'eval'                    => array('rgxp'=>'natural', 'includeBlankOption'=>true, 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
            'options_callback' => function ()
            {
                return Contao\System::getContainer()->get('contao.image.image_sizes')->getOptionsForUser(Contao\BackendUser::getInstance());
            },
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'numberOfItems' => array
        (
            'default'                 => 0,
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'rgxp'=>'natural', 'tl_class'=>'w50'),
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'"
        ),
        'perPage' => array
        (
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('rgxp'=>'natural', 'tl_class'=>'w50'),
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'"
        ),
        'jumpTo' => array
        (
            'exclude'                 => true,
            'inputType'               => 'pageTree',
            'foreignKey'              => 'tl_page.title',
            'eval'                    => array('mandatory'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'hasOne', 'load'=>'eager')
        ),
        'detailBlocks' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkboxWizard',
            'options'                 => array('area', 'price', 'attribute', 'detail', 'energie'),
            'eval'                    => array('mandatory'=>true, 'multiple'=>true),
            'reference'               => &$GLOBALS['TL_LANG']['FMD'],
            'sql'                     => "blob NULL"
        ),
        'summariseDetailBlocks' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50 m12'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'addHeadings' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50 m12', 'submitOnChange'=>true),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'includeAddress' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50 m12'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'textBlocks' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkboxWizard',
            'options'                 => array('objektbeschreibung', 'ausstattBeschr', 'lage', 'sonstigeAngaben', 'objektText', 'dreizeiler'),
            'eval'                    => array('mandatory'=>true, 'multiple'=>true),
            'reference'               => &$GLOBALS['TL_LANG']['FMD'],
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'maxTextLength' => array
        (
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('rgxp'=>'natural', 'tl_class'=>'w50'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'statusTokens' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkboxWizard',
            'options'                 => array('new', 'reserved', 'rented', 'sold'),
            'reference'               => &$GLOBALS['TL_LANG']['tl_real_estate_misc'],
            'eval'                    => array('multiple'=>true),
            'sql'                     => "blob NULL"
        ),
        'fields'  => array
        (
	        'exclude'                 => true,
	        'inputType' 	          => 'cemSelectWizard',
	        'options_callback'        => array('tl_expose_module', 'getRealEstateFields'),
	        'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'clr', 'dragAndDrop'=>true, 'fieldNames'=>array('field'), 'fieldLabels'=>array(&$GLOBALS['TL_LANG']['tl_expose_module']['show_fields'][0])),
            'sql'                     => "blob NULL"
        ),
        'contactFields' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'options'                 => array('personennummer', 'anrede', 'firma', 'vorname', 'name', 'titel', 'position', 'email_zentrale', 'email_direkt', 'email_privat', 'email_sonstige', 'email_feedback', 'tel_zentrale', 'tel_durchw', 'tel_fax', 'tel_handy', 'tel_privat', 'tel_sonstige', 'strasse', 'hausnummer', 'plz', 'ort', 'land', 'freitextfeld', 'singleSRC'),
            'eval'                    => array('mandatory'=>true, 'multiple'=>true),
            'reference'               => &$GLOBALS['TL_LANG']['tl_contact_person'],
            'sql'                     => "blob NULL"
        ),
        'useProviderForwarding' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50 m12'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'form' => array
        (
            'exclude'                 => true,
            'inputType'               => 'select',
            'foreignKey'              => 'tl_form.title',
            'options_callback'        => array('tl_expose_module', 'getForms'),
            'eval'                    => array('chosen'=>true, 'tl_class'=>'w50 wizard'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
        ),
        'share' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkboxWizard',
            'options'                 => array('email'),
            'eval'                    => array('multiple'=>true),
            'reference'               => &$GLOBALS['TL_LANG']['FMD'],
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'shareEmailTemplate' => array
        (
            'exclude'                 => true,
            'inputType'               => 'select',
            'options_callback'        => array('tl_expose_module', 'getShareTemplates'),
            'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'html' => array
        (
            'exclude'                 => true,
            'inputType'               => 'textarea',
            'eval'                    => array('allowHtml'=>true, 'class'=>'monospace', 'rte'=>'ace|html', 'helpwizard'=>true),
            'explanation'             => 'insertTags',
            'sql'                     => "text NULL"
        ),
        'text' => array
        (
            'exclude'                 => true,
            'inputType'               => 'textarea',
            'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true),
            'explanation'             => 'insertTags',
            'sql'                     => "mediumtext NULL"
        ),
        'hideOnEmpty' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50 m12'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'fullsize' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50 m12'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'hideOnReferences' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50 m12'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'attachFeedbackXml' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'feedbackXmlTemplate' => array
        (
            'exclude'                 => true,
            'inputType'               => 'select',
            'options_callback' => function () {
                return Contao\Controller::getTemplateGroup('form_feedback_');
            },
            'eval'                    => array('chosen'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'realEstateTemplate' => array
        (
            'default'                 => 'real_estate_item_default',
            'exclude'                 => true,
            'inputType'               => 'select',
            'options_callback'        => array('tl_expose_module', 'getRealEstateTemplates'),
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'attachmentType' => array
        (
            'exclude'                 => true,
            'inputType'               => 'select',
            'options'                 => array('documents', 'links'),
            'eval'                    => array('tl_class'=>'w50', 'mandatory'=>true, 'includeBlankOption'=>true, 'submitOnChange'=>true),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'allowedFileExtensions' => array
        (
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default 'pdf'"
        ),
        'forceDownload' => array
        (
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50 m12'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
    )
);

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 * @author Fabian Ekert <https://github.com/eki89>
 */
class tl_expose_module extends Contao\Backend
{

    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('Contao\BackendUser', 'User');
    }

    /**
     * Return all real estate list templates as array
     *
     * @return array
     */
    public function getRealEstateTemplates(): array
    {
        return $this->getTemplateGroup('real_estate_item_');
    }

    /**
     * Return all front end modules as array
     *
     * @return array
     */
    public function getExposeModules(): array
    {
        $groups = array();

        foreach ($GLOBALS['CEM_FE_EXPOSE_MOD'] as $k=>$v)
        {
            foreach (array_keys($v) as $kk)
            {
                $groups[$k][] = $kk;
            }
        }

        return $groups;
    }

    /**
     * Return all module templates as array
     *
     * @param Contao\DataContainer $dc
     *
     * @return array
     */
    public function getExposeModuleTemplates(Contao\DataContainer $dc): array
    {
        return $this->getTemplateGroup('expose_mod_' . $dc->activeRecord->type);
    }

    /**
     * Return all gallery item templates as array
     *
     * @return array
     */
    public function getGalleryItemTemplates(): array
    {
        return $this->getTemplateGroup('real_estate_gallery_item_');
    }

    /**
     * Return all gallery item templates as array
     *
     * @return array
     */
    public function getShareTemplates(): array
    {
        return $this->getTemplateGroup('expose_mod_share_');
    }

    /**
     * Return all details from real estate dca as array
     *
     * @return array
     */
    public function getRealEstateFields(): array
    {
        $filterFields = array();

        $this->loadDataContainer('tl_real_estate');

        if (is_array($GLOBALS['TL_DCA']['tl_real_estate']['fields'] ?? null))
        {
            foreach (array_keys($GLOBALS['TL_DCA']['tl_real_estate']['fields']) as $field)
            {
                $filterFields[$field] = ($GLOBALS['TL_LANG']['tl_real_estate'][$field][0] ?? '') . ' [' . $field . ']';
            }
        }

        return $filterFields;
    }

    /**
     * Get all forms and return them as array
     *
     * @return array
     */
    public function getForms(): array
    {
        if (!$this->User->isAdmin && !is_array($this->User->forms))
        {
            return array();
        }

        $arrForms = array();
        $objForms = $this->Database->execute("SELECT id, title FROM tl_form ORDER BY title");

        while ($objForms->next())
        {
            if ($this->User->hasAccess($objForms->id, 'forms'))
            {
                $arrForms[$objForms->id] = $objForms->title;
            }
        }

        return $arrForms;
    }

    /**
     * List an expose module
     *
     * @param array $row
     *
     * @return string
     */
    public function listModule(array $row): string
    {
        return '<div class="tl_content_left">' . $row['name'] . ' <span style="color:#999;padding-left:3px">[' . ($GLOBALS['TL_LANG']['CEM_FE_EXPOSE_MOD'][$row['type']][0] ?? $row['type']) . ']</span></div>';
    }
}
