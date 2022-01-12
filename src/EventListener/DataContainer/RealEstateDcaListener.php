<?php

namespace ContaoEstateManager\EstateManager\EventListener\DataContainer;

use Contao\Backend;
use Contao\BackendUser;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\Security\ContaoCorePermissions;
use Contao\CoreBundle\ServiceAnnotation\Callback;
use Contao\DataContainer;
use Contao\Image;
use Contao\StringUtil;
use Contao\System;
use ContaoEstateManager\RealEstateDcaHelper;
use Symfony\Component\Security\Core\Security;

/**
 * Callback handler for the table tl_real_estate.
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class RealEstateDcaListener
{
    /**
     * Table
     * @var string
     */
    protected $table = 'tl_real_estate';

    /**
     * @var ContaoFramework
     */
    private $framework;

    /**
     * @var Security
     */
    private $security;

    /**
     * @var RealEstateDcaHelper
     */
    private $dcaHelper;

    /**
     * @var Image
     */
    private $image;

    /**
     * @var Backend
     */
    private $backend;

    /**
     * @var System
     */
    private $system;

    /**
     * @var BackendUser
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct(ContaoFramework $framework, Security $security, RealEstateDcaHelper $dcaHelper)
    {
        $this->framework = $framework;
        $this->dcaHelper = $dcaHelper;
        $this->security = $security;

        /** @var Image $image */
        $image = $this->framework->getAdapter(Image::class);
        $this->image = $image;

        /** @var Backend $backend */
        $backend = $this->framework->getAdapter(Backend::class);
        $this->backend = $backend;

        /** @var System $system */
        $system = $this->framework->getAdapter(System::class);
        $this->system = $system;

        /** @var BackendUser $user */
        $user = $this->framework->getAdapter(BackendUser::class);
        $this->user = $user->getInstance();
    }

    /**
     * Return the edit header button
     *
     * @Callback(table="tl_real_estate", target="list.operations.edit.button")
     */
    public function editHeaderButton(array $row, string $href, string $label, string $title, string $icon, string $attributes): string
    {
        if(!$this->security->isGranted(ContaoCorePermissions::USER_CAN_EDIT_FIELDS_OF_TABLE, $this->table))
        {
            return $this->image->getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
        }

        $packages = $this->system->getContainer()->getParameter('kernel.packages');

        if(array_key_exists('contao-estatemanager/backend-real-estate-management', $packages))
        {
            return vsprintf('<a href="%s" title="%s"%s>%s</a> ', [
                '/contao/realestate/edit/'.$row['id'],
                StringUtil::specialchars($title),
                $attributes,
                $this->image->getHtml($icon, $label)
            ]);
        }

        return vsprintf('<a href="%s" title="%s"%s>%s</a> ', [
            $this->backend->addToUrl($href.'&amp;id='.$row['id']),
            StringUtil::specialchars($title),
            $attributes,
            $this->image->getHtml($icon, $label)
        ]);
    }

    /**
     * Return the copy real estate button
     *
     * @Callback(table="tl_real_estate", target="list.operations.copy.button")
     */
    public function copyRealEstateButton(array $row, string $href, string $label, string $title, string $icon, string $attributes): string
    {
        // ToDo: Remove user adapter and check rights via Security isGranted method (see editHeaderButton)
        if(!$this->user->hasAccess('create', 'realestatep'))
        {
            return $this->image->getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
        }

        return vsprintf('<a href="%s" title="%s"%s>%s</a> ', [
            $this->backend->addToUrl($href.'&amp;id='.$row['id']),
            StringUtil::specialchars($title),
            $attributes,
            $this->image->getHtml($icon, $label)
        ]);
    }

    /**
     * Return the delete real estate button
     *
     * @Callback(table="tl_real_estate", target="list.operations.delete.button")
     */
    public function deleteRealEstateButton(array $row, string $href, string $label, string $title, string $icon, string $attributes): string
    {
        // ToDo: Remove user adapter and check rights via Security isGranted method (see editHeaderButton)
        if(!$this->user->hasAccess('delete', 'realestatep'))
        {
            return $this->image->getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
        }

        return vsprintf('<a href="%s" title="%s"%s>%s</a> ', [
            $this->backend->addToUrl($href.'&amp;id='.$row['id']),
            StringUtil::specialchars($title),
            $attributes,
            $this->image->getHtml($icon, $label)
        ]);
    }

    /**
     * Return all provider as array
     *
     * @Callback(table="tl_real_estate", target="fields.provider.options")
     */
    public function providerOptionsCallback(): array
    {
        return $this->dcaHelper->getAllProvider();
    }

    /**
     * Return all provider as array
     *
     * @Callback(table="tl_real_estate", target="fields.contactPerson.options")
     */
    public function contactPersonOptionsCallback(DataContainer $dc): array
    {
        return $this->dcaHelper->getContactPersons($dc);
    }
}
