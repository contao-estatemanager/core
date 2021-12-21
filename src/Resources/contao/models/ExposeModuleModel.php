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

use Contao\Model;
use Contao\Model\Collection;

/**
 * Reads and writes expose front end modules
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string  $name
 * @property string  $headline
 * @property string  $type
 * @property string  $customTpl
 * @property boolean $protected
 * @property string  $groups
 * @property boolean $guests
 * @property string  $cssID
 * @property string  $fontSize
 * @property boolean $forceFullAddress
 * @property string  $galleryModules
 * @property string  $galleryItemTemplate
 * @property boolean $gallerySkipOnEmpty
 * @property string  $imgSize
 * @property string  $numberOfItems
 * @property string  $perPage
 * @property integer $jumpTo
 * @property string  $detailBlocks
 * @property boolean $summariseDetailBlocks
 * @property boolean $addHeadings
 * @property boolean $includeAddress
 * @property string  $textBlocks
 * @property integer $maxTextLength
 * @property string  $statusTokens
 * @property string  $fields
 * @property string  $contactFields
 * @property boolean $useProviderForwarding
 * @property integer $form
 * @property string  $share
 * @property string  $shareEmailTemplate
 * @property string  $html
 * @property string  $text
 * @property boolean $hideOnEmpty
 * @property boolean $fullsize
 * @property boolean $hideOnReferences
 * @property string  $realEstateTemplate
 * @property string  $attachmentType
 * @property string  $allowedFileExtensions
 * @property boolean $forceDownload
 * @property boolean $overwriteFieldSorting
 * @property string  $fieldSorting
 *
 * @method static ExposeModuleModel|null findById($id, array $opt=array())
 * @method static ExposeModuleModel|null findByPk($id, array $opt=array())
 * @method static ExposeModuleModel|null findOneBy($col, $val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByTstamp($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByName($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByHeadline($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByType($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByCustomTpl($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByProtected($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByGroups($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByGuests($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByCssID($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneBySpace($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByFontSize($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByForceFullAddress($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByGalleryModules($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByGalleryItemTemplate($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByGallerySkipOnEmpty($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByImgSize($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByNumberOfItems($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByPerPage($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByJumpTo($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByDetailBlocks($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneBySummariseDetailBlocks($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByAddHeadings($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByIncludeAddress($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByTextBlocks($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByMaxTextLength($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByStatusTokens($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByFields($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByContactFields($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByUseProviderForwarding($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByForm($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByShare($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByShareEmailTemplate($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByHtml($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByText($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByHideOnEmpty($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByFullsize($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByHideOnReferences($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByRealEstateTemplate($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByAttachmentType($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByAllowedFileExtensions($val, array $opt=array())
 * @method static ExposeModuleModel|null findOneByForceDownload($val, array $opt=array())
 *
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByTstamp($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByName($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByHeadline($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByType($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByCustomTpl($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByProtected($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByGroups($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByGuests($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByCssID($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findBySpace($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByFontSize($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByForceFullAddress($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByGalleryModules($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByGalleryItemTemplate($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByGallerySkipOnEmpty($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByImgSize($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByNumberOfItems($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByPerPage($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByJumpTo($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByDetailBlocks($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findBySummariseDetailBlocks($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByAddHeadings($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByIncludeAddress($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByTextBlocks($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByMaxTextLength($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByStatusTokens($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByFields($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByContactFields($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByUseProviderForwarding($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByForm($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByShare($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByShareEmailTemplate($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByHtml($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByText($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByHideOnEmpty($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByFullsize($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByHideOnReferences($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByRealEstateTemplate($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByAttachmentType($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByAllowedFileExtensions($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findByForceDownload($val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findMultipleByIds($var, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findBy($col, $val, array $opt=array())
 * @method static Collection|ExposeModuleModel[]|ExposeModuleModel|null findAll(array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByTstamp($val, array $opt=array())
 * @method static integer countByName($val, array $opt=array())
 * @method static integer countByHeadline($val, array $opt=array())
 * @method static integer countByType($val, array $opt=array())
 * @method static integer countByCustomTpl($val, array $opt=array())
 * @method static integer countByProtected($val, array $opt=array())
 * @method static integer countByGroups($val, array $opt=array())
 * @method static integer countByGuests($val, array $opt=array())
 * @method static integer countByCssID($val, array $opt=array())
 * @method static integer countBySpace($val, array $opt=array())
 * @method static integer countByFontSize($val, array $opt=array())
 * @method static integer countByForceFullAddress($val, array $opt=array())
 * @method static integer countByGalleryModules($val, array $opt=array())
 * @method static integer countByGalleryItemTemplate($val, array $opt=array())
 * @method static integer countByGallerySkipOnEmpty($val, array $opt=array())
 * @method static integer countByImgSize($val, array $opt=array())
 * @method static integer countByNumberOfItems($val, array $opt=array())
 * @method static integer countByPerPage($val, array $opt=array())
 * @method static integer countByJumpTo($val, array $opt=array())
 * @method static integer countByDetailBlocks($val, array $opt=array())
 * @method static integer countBySummariseDetailBlocks($val, array $opt=array())
 * @method static integer countByAddHeadings($val, array $opt=array())
 * @method static integer countByIncludeAddress($val, array $opt=array())
 * @method static integer countByTextBlocks($val, array $opt=array())
 * @method static integer countByMaxTextLength($val, array $opt=array())
 * @method static integer countByStatusTokens($val, array $opt=array())
 * @method static integer countByFields($val, array $opt=array())
 * @method static integer countByContactFields($val, array $opt=array())
 * @method static integer countByUseProviderForwarding($val, array $opt=array())
 * @method static integer countByForm($val, array $opt=array())
 * @method static integer countByShare($val, array $opt=array())
 * @method static integer countByShareEmailTemplate($val, array $opt=array())
 * @method static integer countByHtml($val, array $opt=array())
 * @method static integer countByText($val, array $opt=array())
 * @method static integer countByHideOnEmpty($val, array $opt=array())
 * @method static integer countByFullsize($val, array $opt=array())
 * @method static integer countByHideOnReferences($val, array $opt=array())
 * @method static integer countByRealEstateTemplate($val, array $opt=array())
 * @method static integer countByAttachmentType($val, array $opt=array())
 * @method static integer countByAllowedFileExtensions($val, array $opt=array())
 * @method static integer countByForceDownload($val, array $opt=array())
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */

class ExposeModuleModel extends Model
{

	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_expose_module';

}
