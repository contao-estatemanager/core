<?php

declare(strict_types=1);

/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

namespace ContaoEstateManager\EstateManager\EventListener;

use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\Input;
use ContaoEstateManager\RealEstate;
use ContaoEstateManager\RealEstateModel;

/**
 * @internal
 */
class InsertTagsListener
{
    private const SUPPORTED_TAGS = [
        'realestate'
    ];

    /**
     * @var ContaoFramework
     */
    private $framework;

    public function __construct(ContaoFramework $framework)
    {
        $this->framework = $framework;
    }

    /**
     * @return string|false
     */
    public function onReplaceInsertTags(string $tag, bool $useCache, $cacheValue, array $flags)
    {
        $elements = explode('::', $tag);
        $key = strtolower($elements[0]);

        if (\in_array($key, self::SUPPORTED_TAGS, true)) {
            return $this->replaceRealEstateInsertTags($key, $elements, $flags);
        }

        return false;
    }

    private function replaceRealEstateInsertTags(string $insertTag, array $elements, array $flags): string
    {
        $this->framework->initialize();

        /** @var RealEstateModel $adapter */
        $adapter = $this->framework->getAdapter(RealEstateModel::class);

        if (is_numeric($elements[1]))
        {
            if (null !== ($model = $adapter->findPublishedByIdOrAlias($elements[1])))
            {
                $elements[1] = $elements[2];
            }
        }
        elseif (Input::get('items'))
        {
            $model = $adapter->findPublishedByIdOrAlias(Input::get('items'));
        }

        if ($model === null)
        {
            return '';
        }

        $realEstate = new RealEstate($model);

        switch ($insertTag) {
            case 'realestate':
                return (string) $realEstate->{$elements[1]} ?: '';
        }

        return '';
    }
}
