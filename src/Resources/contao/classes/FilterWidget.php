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
 * Generates and validates filter items
 *
 * @author Fabian Ekert <fabian@oveleon.de>
 */
abstract class FilterWidget extends \Widget
{
	/**
	 * Set an object property
	 *
	 * @param string $strKey   The property name
	 * @param mixed  $varValue The property value
	 */
	public function __set($strKey, $varValue)
	{
		switch ($strKey)
		{
			case 'foo':
				$this->strId = $varValue;
				break;

            default:
                parent::__set($strKey, $varValue);
                break;
		}
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
			case 'foo':
				return $this->strId;
				break;

            default:
                return parent::__get($strKey);
                break;
		}
	}

	/**
	 * Check whether an object property exists
	 *
	 * @param string $strKey The property name
	 *
	 * @return boolean True if the property exists
	 */
	public function __isset($strKey)
	{
		switch ($strKey)
		{
			case 'foo':
				return isset($this->strId);
				break;

            default:
                return parent::__isset($strKey);
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

		$strBuffer = $this->inherit();

		if (isset($GLOBALS['TL_HOOKS']['parseFilterWidget']) && \is_array($GLOBALS['TL_HOOKS']['parseFilterWidget']))
		{
			foreach ($GLOBALS['TL_HOOKS']['parseFilterWidget'] as $callback)
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
		$varValue = $this->validator($this->getPost($this->strName));

		if ($this->hasErrors())
		{
			$this->class = 'error';
		}

		$this->varValue = $varValue;
	}

	/**
	 * Recursively validate an input variable
	 *
	 * @param mixed $varInput The user input
	 *
	 * @return mixed The original or modified user input
	 */
	protected function validator($varInput)
	{
		if (\is_array($varInput))
		{
			foreach ($varInput as $k=>$v)
			{
				$varInput[$k] = $this->validator($v);
			}

			return $varInput;
		}

		if (!$this->doNotTrim)
		{
			$varInput = trim($varInput);
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

		if ($this->minlength && $varInput != '' && Utf8::strlen($varInput) < $this->minlength)
		{
			$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['minlength'], $this->strLabel, $this->minlength));
		}

		if ($this->maxlength && $varInput != '' && Utf8::strlen($varInput) > $this->maxlength)
		{
			$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['maxlength'], $this->strLabel, $this->maxlength));
		}

		if ($this->minval && is_numeric($varInput) && $varInput < $this->minval)
		{
			$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['minval'], $this->strLabel, $this->minval));
		}

		if ($this->maxval && is_numeric($varInput) && $varInput > $this->maxval)
		{
			$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['maxval'], $this->strLabel, $this->maxval));
		}

		if ($this->rgxp != '')
		{
			switch ($this->rgxp)
			{
				// Special validation rule for style sheets
				case strncmp($this->rgxp, 'digit_', 6) === 0:
					$textual = explode('_', $this->rgxp);
					array_shift($textual);

					if (\in_array($varInput, $textual) || strncmp($varInput, '$', 1) === 0)
					{
						break;
					}
					// DO NOT ADD A break; STATEMENT HERE

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
							new Date($varInput, Date::getNumericDatimFormat());
						}
						catch (\OutOfBoundsException $e)
						{
							$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['invalidDate'], $varInput));
						}
					}
					break;

				// Check whether the current value is a valid friendly name e-mail address
				case 'friendly':
					list ($strName, $varInput) = StringUtil::splitFriendlyEmail($varInput);
					// no break;

				// Check whether the current value is a valid e-mail address
				case 'email':
					if (!Validator::isEmail($varInput))
					{
						$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['email'], $this->strLabel));
					}
					if ($this->rgxp == 'friendly' && !empty($strName))
					{
						$varInput = $strName . ' [' . $varInput . ']';
					}
					break;

				// Check whether the current value is list of valid e-mail addresses
				case 'emails':
					$arrEmails = StringUtil::trimsplit(',', $varInput);

					foreach ($arrEmails as $strEmail)
					{
						$strEmail = Idna::encodeEmail($strEmail);

						if (!Validator::isEmail($strEmail))
						{
							$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['emails'], $this->strLabel));
							break;
						}
					}
					break;

				// Check whether the current value is a valid URL
				case 'url':
					if (!Validator::isUrl($varInput))
					{
						$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['url'], $this->strLabel));
					}
					break;

				// Check whether the current value is a valid alias
				case 'alias':
					if (!Validator::isAlias($varInput))
					{
						$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['alias'], $this->strLabel));
					}
					break;

				// Check whether the current value is a valid folder URL alias
				case 'folderalias':
					if (!Validator::isFolderAlias($varInput))
					{
						$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['folderalias'], $this->strLabel));
					}
					break;

				// Phone numbers (numeric characters, space [ ], plus [+], minus [-], parentheses [()] and slash [/])
				case 'phone':
					if (!Validator::isPhone(html_entity_decode($varInput)))
					{
						$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['phone'], $this->strLabel));
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

				// Check whether the current value is a Google+ ID or vanity name
				case 'google+':
					if (!Validator::isGooglePlusId($varInput))
					{
						$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['invalidGoogleId'], $this->strLabel));
					}
					break;

				// Check whether the current value is a field name
				case 'fieldname':
					if (!Validator::isFieldName($varInput))
					{
						$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['invalidFieldName'], $this->strLabel));
					}
					break;

				// HOOK: pass unknown tags to callback functions
				default:
					if (isset($GLOBALS['TL_HOOKS']['addCustomRegexp']) && \is_array($GLOBALS['TL_HOOKS']['addCustomRegexp']))
					{
						foreach ($GLOBALS['TL_HOOKS']['addCustomRegexp'] as $callback)
						{
							$this->import($callback[0]);
							$break = $this->{$callback[0]}->{$callback[1]}($this->rgxp, $varInput, $this);

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

		if ($this->isHexColor && $varInput != '' && strncmp($varInput, '$', 1) !== 0)
		{
			$varInput = preg_replace('/[^a-f0-9]+/i', '', $varInput);
		}

		if ($this->nospace && preg_match('/[\t ]+/', $varInput))
		{
			$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['noSpace'], $this->strLabel));
		}

		if ($this->spaceToUnderscore)
		{
			$varInput = preg_replace('/\s+/', '_', trim($varInput));
		}

		if (\is_bool($this->trailingSlash) && $varInput != '')
		{
			$varInput = preg_replace('/\/+$/', '', $varInput) . ($this->trailingSlash ? '/' : '');
		}

		return $varInput;
	}
}
