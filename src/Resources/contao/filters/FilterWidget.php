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

use Contao\Date;
use Contao\Input;
use Contao\System;
use Contao\Validator;
use Contao\Widget;

/**
 * Generates and validates filter items
 *
 * @author Fabian Ekert <https://github.com/eki89>
 */
abstract class FilterWidget extends Widget
{
    /**
     * Filter object
     *
     * @var Filter
     */
    protected $objFilter;

    /**
     * Filter session object
     *
     * @var FilterSession
     */
    protected $objFilterSession;

    /**
     * Multiple
     * @var boolean
     */
    protected $blnMultiple = false;

    /**
     * Initialize the object
     *
     * @param array $arrAttributes An optional attributes array
     * @param FilterModel $objFilter     Parent filter model
     */
    public function __construct($arrAttributes, $objFilter=null)
    {
        $this->objFilter = $objFilter;

        $this->objFilterSession = FilterSession::getInstance();
        $this->sessionManager = SessionManager::getInstance();

        parent::__construct($arrAttributes);
    }

    /**
     * Return an object property
     *
     * @param string $strKey The property name
     *
     * @return string The property value
     */
    public function __get($strKey)
    {

        switch ($strKey)
        {
            case 'multiple':
                return $this->blnMultiple;
        }

        return parent::__get($strKey);
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
		if ($this->strTemplate == '')
		{
			return '';
		}

		$this->addAttributes($arrAttributes);

		$this->mandatoryField = $GLOBALS['TL_LANG']['MSC']['mandatory'];

		if ($this->customTpl != '' && TL_MODE == 'FE')
		{
			$this->strTemplate = $this->customTpl;
		}

        System::loadLanguageFile('tl_real_estate_filter');

		$strBuffer = $this->inherit();

		if (isset($GLOBALS['CEM_HOOKS']['parseFilterWidget']) && \is_array($GLOBALS['CEM_HOOKS']['parseFilterWidget']))
		{
			foreach ($GLOBALS['CEM_HOOKS']['parseFilterWidget'] as $callback)
			{
				$this->import($callback[0]);
				$strBuffer = $this->{$callback[0]}->{$callback[1]}($strBuffer, $this);
			}
		}

		return $strBuffer;
	}

    /**
     * Validate the user input and set the value
     */
    public function validate()
    {
        $varValue = $this->validator(Input::post($this->name, true));

        if ($this->hasErrors())
        {
            $this->class = 'error';
        }

        $this->varValue = $varValue;
    }

    /**
     * Find and return a $_POST variable
     *
     * @param string $strKey The variable name
     *
     * @return mixed The variable value
     */
    protected function getPost($strKey)
    {
        if (\is_callable($this->inputCallback))
        {
            return \call_user_func($this->inputCallback);
        }

        $arrParts = explode('[', str_replace(']', '', $strKey));
        $varValue = Input::post(array_shift($arrParts), true);

        foreach ($arrParts as $part)
        {
            if (!\is_array($varValue))
            {
                break;
            }

            $varValue = $varValue[$part];
        }

        return $varValue;
    }

    /**
     * Recursively validate an input variable
     *
     * @param mixed $varInput The user input
     * @param string $rgxp An optional validation method
     *
     * @return mixed The original or modified user input
     * @throws \Exception
     */
	protected function validator($varInput, $rgxp='')
	{
		if (\is_array($varInput))
		{
			foreach ($varInput as $k=>$v)
			{
				$varInput[$k] = $this->validator($v, $rgxp);
			}

			return $varInput;
		}

		if ($varInput == '')
		{
			if (!$this->mandatory)
			{
				return '';
			}
			else
			{
				if ($this->strLabel == '')
				{
					$this->addError($GLOBALS['TL_LANG']['ERR']['mdtryNoLabel']);
				}
				else
				{
					$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['mandatory'], $this->strLabel));
				}
			}
		}

		if ($rgxp != '')
		{
			switch ($rgxp)
			{
				// Numeric characters (including full stop [.] and minus [-])
				case 'digit':
					// Support decimal commas and convert them automatically (see #3488)
					if (substr_count($varInput, ',') == 1 && strpos($varInput, '.') === false)
					{
						$varInput = str_replace(',', '.', $varInput);
					}
					if (!Validator::isNumeric($varInput))
					{
						$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['digit'], $this->strLabel));
					}
					break;

				// Natural numbers (positive integers)
				case 'natural':
					if (!Validator::isNatural($varInput))
					{
						$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['natural'], $this->strLabel));
					}
					break;

				// Alphabetic characters (including full stop [.] minus [-] and space [ ])
				case 'alpha':
					if (!Validator::isAlphabetic($varInput))
					{
						$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['alpha'], $this->strLabel));
					}
					break;

				// Alphanumeric characters (including full stop [.] minus [-], underscore [_] and space [ ])
				case 'alnum':
					if (!Validator::isAlphanumeric($varInput))
					{
						$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['alnum'], $this->strLabel));
					}
					break;

				// Do not allow any characters that are usually encoded by class Input ([#<>()\=])
				case 'extnd':
					if (!Validator::isExtendedAlphanumeric(html_entity_decode($varInput)))
					{
						$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['extnd'], $this->strLabel));
					}
					break;

				// Check whether the current value is a valid date format
				case 'date':
					if (!Validator::isDate($varInput))
					{
						$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['date'], Date::getInputFormat(Date::getNumericDateFormat())));
					}
					else
					{
						// Validate the date (see #5086)
						try
						{
							new Date($varInput, Date::getNumericDateFormat());
						}
						catch (\OutOfBoundsException $e)
						{
							$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['invalidDate'], $varInput));
						}
					}
					break;

				// Check whether the current value is a valid time format
				case 'time':
					if (!Validator::isTime($varInput))
					{
						$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['time'], Date::getInputFormat(Date::getNumericTimeFormat())));
					}
					break;

				// Check whether the current value is a valid date and time format
				case 'datim':
					if (!Validator::isDatim($varInput))
					{
						$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['dateTime'], Date::getInputFormat(Date::getNumericDatimFormat())));
					}
					else
					{
						// Validate the date (see #5086)
						try
						{
							new \Date($varInput, Date::getNumericDatimFormat());
						}
						catch (\OutOfBoundsException $e)
						{
							$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['invalidDate'], $varInput));
						}
					}
					break;

				// Check whether the current value is a percent value
				case 'prcnt':
					if (!Validator::isPercent($varInput))
					{
						$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['prcnt'], $this->strLabel));
					}
					break;

				// Check whether the current value is a locale
				case 'locale':
					if (!Validator::isLocale($varInput))
					{
						$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['locale'], $this->strLabel));
					}
					break;

				// Check whether the current value is a language code
				case 'language':
					if (!Validator::isLanguage($varInput))
					{
						$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['language'], $this->strLabel));
					}
					break;

				// HOOK: pass unknown tags to callback functions
				default:
					if (isset($GLOBALS['CEM_HOOKS']['addCustomRegexp']) && \is_array($GLOBALS['CEM_HOOKS']['addCustomRegexp']))
					{
						foreach ($GLOBALS['CEM_HOOKS']['addCustomRegexp'] as $callback)
						{
							$this->import($callback[0]);
							$break = $this->{$callback[0]}->{$callback[1]}($rgxp, $varInput, $this);

							// Stop the loop if a callback returned true
							if ($break === true)
							{
								break;
							}
						}
					}
					break;
			}
		}

		return $varInput;
	}

    /**
     * Check whether a marketing option is selected
     *
     * @param string $marketingType
     *
     * @return boolean
     */
    protected function isMarketingOptionSelected($marketingType)
    {
        return $this->sessionManager->getSelectedMarketingType() === $marketingType;
    }
}
