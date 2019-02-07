<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerBundle;


use Contao\Widget;

class FilterSubmit extends Widget
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

            if ($objModel !== null && is_file(TL_ROOT . '/' . $objModel->path))
            {
                $this->src = $objModel->path;
            }
        }

        return parent::parse($arrAttributes);
    }

    /**
     * Generate the widget and return it as string
     *
     * @return string The widget markup
     */
    public function generate() {}
}
