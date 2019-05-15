<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerBundle;


use Contao\PageModel;

/**
 * Provide methods to handle filter.
 *
 * @author Fabian Ekert <fabian@oveleon.de>
 */
class RealEstateFilter
{
    /**
     * @var RealEstateFilter
     */
    protected static $instance;

    /**
     * @var null|RealEstateTypeModel
     */
    protected $objCurrentType;

    /**
     * @var null|RealEstateGroupModel
     */
    protected $objCurrentGroup;

    /**
     * Template
     * @var string
     */
    protected $strTable = 'tl_real_estate';

    /**
     * @return RealEstateFilter
     */
    public static function getInstance($pageId = null)
    {
        if (is_null(static::$instance))
        {
            static::$instance = new static($pageId);
        }
        return static::$instance;
    }

    /**
     * RealEstateFilter constructor.
     */
    protected function __construct($pageId)
    {
        /** @var PageModel $objPage */
        global $objPage;

        if ($objPage === null && $pageId !== null)
        {
            $objPage = PageModel::findByPk($pageId);
        }

        if (($objType = RealEstateTypeModel::findByReferencePage($objPage->id)) !== null)
        {
            if ($objType->count() > 1)
            {
                while ($objType->next())
                {
                    if (isset($_SESSION['FILTER_DATA']['group']))
                    {
                        if ($objType->vermarktungsart === $_SESSION['FILTER_DATA']['group'])
                        {
                            $this->objCurrentType = $objType->current();

                            $_SESSION['FILTER_DATA']['type'] = $objType->id;
                            $_SESSION['FILTER_DATA']['groupId'] = $objType->pid;

                            break;
                        }
                    }
                    else
                    {
                        if ($objType->vermarktungsart === 'miete_leasing')
                        {
                            $this->objCurrentType = $objType->current();

                            $_SESSION['FILTER_DATA']['type'] = $objType->id;
                            $_SESSION['FILTER_DATA']['group'] = $objType->vemarktungsart;
                            $_SESSION['FILTER_DATA']['groupId'] = $objType->pid;

                            break;
                        }
                    }
                }
            }
            else
            {
                $this->objCurrentType = $objType->current();

                $_SESSION['FILTER_DATA']['type'] = $objType->id;
                $_SESSION['FILTER_DATA']['group'] = $objType->vermarktungsart;
                $_SESSION['FILTER_DATA']['groupId'] = $objType->pid;
            }
        }
        elseif (($objGroup = RealEstateGroupModel::findByReferencePage($objPage->id)) !== null)
        {
            if ($objGroup->count() > 1)
            {
                while ($objGroup->next())
                {
                    if (isset($_SESSION['FILTER_DATA']['group']))
                    {
                        if ($objGroup->vermarktungsart === $_SESSION['FILTER_DATA']['group'])
                        {
                            $this->objCurrentGroup = $objGroup->current();

                            $_SESSION['FILTER_DATA']['type'] = '';
                            $_SESSION['FILTER_DATA']['groupId'] = $objGroup->id;

                            break;
                        }
                    }
                    else
                    {
                        if ($objGroup->vermarktungsart === 'miete_leasing')
                        {
                            $this->objCurrentGroup = $objGroup->current();

                            $_SESSION['FILTER_DATA']['type'] = '';
                            $_SESSION['FILTER_DATA']['group'] = $objGroup->vemarktungsart;
                            $_SESSION['FILTER_DATA']['groupId'] = $objGroup->id;

                            break;
                        }
                    }
                }
            }
            else
            {
                if (isset($_POST['REAL_ESTATE_GROUP_FIELD']) && $_POST[$_POST['REAL_ESTATE_GROUP_FIELD']] && $objGroup->vermarktungsart !== $_POST[$_POST['REAL_ESTATE_GROUP_FIELD']])
                {
                    $objGroup = $objGroup->getRelated('similarGroup');
                }

                $this->objCurrentGroup = $objGroup->current();

                $_SESSION['FILTER_DATA']['type'] = '';
                $_SESSION['FILTER_DATA']['group'] = $objGroup->vermarktungsart;
                $_SESSION['FILTER_DATA']['groupId'] = $objGroup->id;
            }
        }
    }

    /**
     * Return an object property
     *
     * @param string $strKey
     *
     * @return mixed
     */
    public function __get($strKey)
    {
        switch ($strKey)
        {
            case 'type':
                return $this->objCurrentType;
                break;
            case 'group':
                return $this->objCurrentGroup;
                break;
        }
    }

    /**
     * Set current group
     *
     * @param $group
     */
    public function setCurrentGroup($group)
    {
        $this->objCurrentGroup = $group;
    }

    /**
     * Checks whether the filter can be used.
     *
     * @return bool
     */
    public function isUsable()
    {
        if (!is_null($this->objCurrentType) || !is_null($this->objCurrentGroup))
        {
            return true;
        }

        return false;
    }

    /**
     * Collect all filter parameter by group and return it as array
     *
     * @param string $mode  filter mode
     *
     * @return array
     */
    public function getParameter($mode)
    {
        if ($this->objCurrentType)
        {
            return $this->getTypeParameter($mode);
        }
        elseif ($this->objCurrentGroup)
        {
            return $this->getGroupParameter($mode);
        }
    }

    /**
     * Collect type filter parameter and return them as array
     *
     * @param $mode
     *
     * @return array
     */
    private function getTypeParameter($mode)
    {
        $t = $this->strTable;

        $arrColumns = array("$t.published='1'");
        $arrValues = array();
        $arrOptions = array();

        switch ($mode)
        {
            case 'referenz':
                $arrColumns[] = "$t.referenz='1'";
                break;
            case 'neubau':
                $arrColumns[] = "$t.master='' AND $t.gruppenKennung!=''";
                break;
            default:
                $arrColumns[] = "$t.referenz!='1' AND ($t.gruppenKennung='' OR ($t.master!='' AND $t.gruppenKennung!=''))";
                break;
        }

        if (!empty($this->objCurrentType->nutzungsart))
        {
            $arrColumns[] = "$t.nutzungsart=?";
            $arrValues[] = $this->objCurrentType->nutzungsart;
        }
        if ($this->objCurrentType->vermarktungsart === 'kauf_erbpacht')
        {
            $arrColumns[] = "($t.vermarktungsartKauf='1' OR $t.vermarktungsartErbpacht='1')";
        }
        if ($this->objCurrentType->vermarktungsart === 'miete_leasing')
        {
            $arrColumns[] = "($t.vermarktungsartMietePacht='1' OR $t.vermarktungsartLeasing='1')";
        }
        if (!empty($this->objCurrentType->objektart))
        {
            $arrColumns[] = "$t.objektart=?";
            $arrValues[] = $this->objCurrentType->objektart;
        }

        $arrListFilter = \StringUtil::deserialize($this->objCurrentType->listFilter);

        foreach ($arrListFilter as $index => $filter)
        {
            $arrListFilter[$index] = $filter['group'];
        }

        // Price filter
        if (in_array('price', $arrListFilter) && !in_array('per', $arrListFilter))
        {
            if ($_SESSION['FILTER_DATA']['price_from'])
            {
                $arrColumns[] = "$t.".$this->objCurrentType->price.">=?";
                $arrValues[] = $_SESSION['FILTER_DATA']['price_from'];
            }
            if ($_SESSION['FILTER_DATA']['price_to'])
            {
                $arrColumns[] = "$t.".$this->objCurrentType->price."<=?";
                $arrValues[] = $_SESSION['FILTER_DATA']['price_to'];
            }
        }

        // Price per filter
        if (in_array('price', $arrListFilter) && in_array('per', $arrListFilter))
        {
            if ($_SESSION['FILTER_DATA']['price_per'])
            {
                if ($_SESSION['FILTER_DATA']['price_per'] === 'square_meter')
                {
                    if ($_SESSION['FILTER_DATA']['price_from'])
                    {
                        if ($this->objCurrentType->vermarktungsart === 'miete_leasing') {
                            $arrColumns[] = "$t.mietpreisProQm>=?";
                            $arrValues[] = $_SESSION['FILTER_DATA']['price_from'];
                        }
                        else
                        {
                            $arrColumns[] = "$t.kaufpreisProQm>=?";
                            $arrValues[] = $_SESSION['FILTER_DATA']['price_from'];
                        }
                    }
                    if ($_SESSION['FILTER_DATA']['price_to'])
                    {
                        if ($this->objCurrentType->vermarktungsart === 'miete_leasing') {
                            $arrColumns[] = "$t.mietpreisProQm<=?";
                            $arrValues[] = $_SESSION['FILTER_DATA']['price_to'];
                        }
                        else
                        {
                            $arrColumns[] = "$t.kaufpreisProQm<=?";
                            $arrValues[] = $_SESSION['FILTER_DATA']['price_to'];
                        }
                    }
                }
            }
            else
            {
                if ($_SESSION['FILTER_DATA']['price_from'])
                {
                    $arrColumns[] = "$t.".$this->objCurrentType->price.">=?";
                    $arrValues[] = $_SESSION['FILTER_DATA']['price_from'];
                }
                if ($_SESSION['FILTER_DATA']['price_to'])
                {
                    $arrColumns[] = "$t.".$this->objCurrentType->price."<=?";
                    $arrValues[] = $_SESSION['FILTER_DATA']['price_to'];
                }
            }
        }

        // Room filter
        if (in_array('room', $arrListFilter))
        {
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
        }

        // Area filter
        if (in_array('area', $arrListFilter))
        {
            if ($_SESSION['FILTER_DATA']['area_from'])
            {
                $arrColumns[] = "$t.".$this->objCurrentType->area.">=?";
                $arrValues[] = $_SESSION['FILTER_DATA']['area_from'];
            }
            if ($_SESSION['FILTER_DATA']['area_to'])
            {
                $arrColumns[] = "$t.".$this->objCurrentType->area."<=?";
                $arrValues[] = $_SESSION['FILTER_DATA']['area_to'];
            }
        }

        // Period filter
        if (in_array('period', $arrListFilter))
        {
            if ($_SESSION['FILTER_DATA']['period_from'])
            {
                if (\Validator::isDate($_SESSION['FILTER_DATA']['period_from']))
                {
                    $arrColumns[] = "($t.abdatum<=? || abdatum='')";

                    $date = new \Date($_SESSION['FILTER_DATA']['period_from']);
                    $arrValues[] = $date->tstamp;
                }
            }
            if ($_SESSION['FILTER_DATA']['period_to'])
            {
                if (\Validator::isDate($_SESSION['FILTER_DATA']['period_to']))
                {
                    $arrColumns[] = "($t.bisdatum>=? || $t.bisdatum='')";

                    $date = new \Date($_SESSION['FILTER_DATA']['period_to']);
                    $arrValues[] = $date->tstamp;
                }
            }
        }

        // Location filter
        if ($_SESSION['FILTER_DATA']['location'] !== '')
        {
            $arrColumns[] = "$t.ort LIKE ?";
            $arrValues[] = '%'.$_SESSION['FILTER_DATA']['location'].'%';
        }

        return array($arrColumns, $arrValues, $arrOptions);
    }

    /**
     * Collect group filter parameter and return them as array
     *
     * @param $mode
     *
     * @return array
     */
    private function getGroupParameter($mode)
    {
        $t = $this->strTable;

        $arrColumns = array("$t.published='1'");
        $arrValues = array();
        $arrOptions = array();

        switch ($mode)
        {
            case 'referenz':
                $arrColumns[] = "$t.referenz='1'";
                break;
            case 'neubau':
                $arrColumns[] = "$t.master='' AND $t.gruppenKennung!=''";
                break;
            default:
                $arrColumns[] = "$t.referenz!='1' AND ($t.gruppenKennung='' OR ($t.master!='' AND $t.gruppenKennung!=''))";
                break;
        }

        if ($this->objCurrentGroup->vermarktungsart === 'kauf_erbpacht')
        {
            $arrColumns[] = "($t.vermarktungsartKauf='1' OR $t.vermarktungsartErbpacht='1')";
        }
        if ($this->objCurrentGroup->vermarktungsart === 'miete_leasing')
        {
            $arrColumns[] = "($t.vermarktungsartMietePacht='1' OR $t.vermarktungsartLeasing='1')";
        }

        $objTypes = RealEstateTypeModel::findByPid($this->objCurrentGroup->id);

        if ($objTypes === null)
        {
            return array($arrColumns, $arrValues, $arrOptions); // ToDo: Exception werfen. Darf eigentlich nicht passieren.
        }

        $arrColumn = array();
        $arrPriceFields = array();
        $arrAreaFields = array();

        while ($objTypes->next())
        {
            $wrap = !empty($objTypes->nutzungsart) && !empty($objTypes->objektart) ? true : false;
            $strColumn = $wrap ? '(' : '';

            if (!empty($objTypes->nutzungsart))
            {
                $strColumn .= "$t.nutzungsart=?";
                $arrValues[] = $objTypes->nutzungsart;
            }
            $strColumn .= $wrap ? ' AND ' : '';
            if (!empty($objTypes->objektart))
            {
                $strColumn .= "$t.objektart=?";
                $arrValues[] = $objTypes->objektart;
            }
            $strColumn .= $wrap ? ')' : '';

            $arrColumn[] = $strColumn;

            if (!in_array($objTypes->price, $arrPriceFields))
            {
                $arrPriceFields[] = $objTypes->price;
            }
            if (!in_array($objTypes->area, $arrAreaFields))
            {
                $arrAreaFields[] = $objTypes->area;
            }
        }

        $arrColumns[] = '(' . implode(' || ', $arrColumn) . ')';

        $arrListFilter = array('price', 'area'); // ToDo: Hole listen felder aus dem Gruppen Datensatz.

        // Price filter
        if (in_array('price', $arrListFilter) && !in_array('per', $arrListFilter))
        {
            if ($_SESSION['FILTER_DATA']['price_from'])
            {
                $arrColumn = array();

                foreach ($arrPriceFields as $field)
                {
                    $arrColumn[] = "$t.$field>=?";
                    $arrValues[] = $_SESSION['FILTER_DATA']['price_from'];
                }

                $arrColumns[] = '(' . implode(' || ', $arrColumn) . ')';
            }
            if ($_SESSION['FILTER_DATA']['price_to'])
            {
                $arrColumn = array();

                foreach ($arrPriceFields as $field)
                {
                    $arrColumn[] = "$t.$field<=?";
                    $arrValues[] = $_SESSION['FILTER_DATA']['price_to'];
                }

                $arrColumns[] = '(' . implode(' || ', $arrColumn) . ')';
            }
        }

        // Room filter
        if (in_array('room', $arrListFilter))
        {
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
        }

        // Area filter
        if (in_array('area', $arrListFilter))
        {
            if ($_SESSION['FILTER_DATA']['area_from'])
            {
                $arrColumn = array();

                foreach ($arrAreaFields as $field)
                {
                    $arrColumn[] = "$t.$field>=?";
                    $arrValues[] = $_SESSION['FILTER_DATA']['area_from'];
                }

                $arrColumns[] = '(' . implode(' || ', $arrColumn) . ')';
            }
            if ($_SESSION['FILTER_DATA']['area_to'])
            {
                $arrColumn = array();

                foreach ($arrAreaFields as $field)
                {
                    $arrColumn[] = "$t.$field<=?";
                    $arrValues[] = $_SESSION['FILTER_DATA']['area_to'];
                }

                $arrColumns[] = '(' . implode(' || ', $arrColumn) . ')';
            }
        }

        // Period filter
        if (in_array('period', $arrListFilter))
        {
            if ($_SESSION['FILTER_DATA']['period_from'])
            {
                if (\Validator::isDate($_SESSION['FILTER_DATA']['period_from']))
                {
                    $arrColumns[] = "($t.abdatum<=? || abdatum='')";

                    $date = new \Date($_SESSION['FILTER_DATA']['period_from']);
                    $arrValues[] = $date->tstamp;
                }
            }
            if ($_SESSION['FILTER_DATA']['period_to'])
            {
                if (\Validator::isDate($_SESSION['FILTER_DATA']['period_to']))
                {
                    $arrColumns[] = "($t.bisdatum>=? || $t.bisdatum='')";

                    $date = new \Date($_SESSION['FILTER_DATA']['period_to']);
                    $arrValues[] = $date->tstamp;
                }
            }
        }

        return array($arrColumns, $arrValues, $arrOptions);
    }


    public function isGroupSelected($vermarktungsart)
    {
        if ($this->objCurrentType && $vermarktungsart === $this->objCurrentType->vermarktungsart)
        {
            return true;
        }
        if (isset($_SESSION['FILTER_DATA']) && $vermarktungsart === $_SESSION['FILTER_DATA']['group'])
        {
            return true;
        }
        if (!isset($_SESSION['FILTER_DATA']) && $vermarktungsart === 'miete_leasing')
        {
            return true;
        }
        return false;
    }
}
