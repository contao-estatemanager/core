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
 * Class FilterSubmit
 *
 * @property string  $name
 * @property string  $label
 * @property string  $singleSRC
 * @property boolean $imageSubmit
 * @property boolean $required
 * @property boolean $mandatory
 * @property string  $src
 *
 * @author Fabian Ekert <fabian@oveleon.de>
 */
class FilterSubmit extends FilterWidget
{

    /**
     * Template
     *
     * @var string
     */
    protected $strTemplate = 'filter_submit';

    /**
     * The CSS class prefix
     *
     * @var string
     */
    protected $strPrefix = 'widget widget-submit';

    /**
     * Initialize the object
     *
     * @param array       $arrAttributes Attributes array
     * @param FilterModel $objFilter     Parent filter model
     */
    public function __construct($arrAttributes, $objFilter=null)
    {
        parent::__construct($arrAttributes, $objFilter);
    }

    /**
     * Add specific attributes
     *
     * @param string $strKey   The attribute name
     * @param mixed  $varValue The attribute value
     */
    public function __set($strKey, $varValue)
    {
        switch ($strKey)
        {
            case 'singleSRC':
                $this->arrConfiguration['singleSRC'] = $varValue;
                break;

            case 'imageSubmit':
                $this->arrConfiguration['imageSubmit'] = $varValue ? true : false;
                break;

            case 'label':
                $this->slabel = $varValue;
                break;

            case 'required':
            case 'mandatory':
                // Ignore
                break;

            default:
                parent::__set($strKey, $varValue);
                break;
        }
    }

    /**
     * Do not validate
     */
    public function validate()
    {
        return;
    }

    /**
     * Parse the template file and return it as string
     *
     * @param array $arrAttributes An optional attributes array
     *
     * @return string The template markup
     */
    public function parse($arrAttributes=null)
    {
        if ($this->imageSubmit && $this->singleSRC != '')
        {
            $objModel = \FilesModel::findByUuid($this->singleSRC);

            if ($objModel !== null && is_file(TL_ROOT . '/' . $objModel->path)) // ToDo: Replace TL_ROOT with \System::getContainer()->getParameter('kernel.project_dir'): Check compatibility
            {
                $this->src = $objModel->path;
            }
        }

        return parent::parse($arrAttributes);
    }

    /**
     * Rudimentary generate method
     */
    public function generate() {}
}
