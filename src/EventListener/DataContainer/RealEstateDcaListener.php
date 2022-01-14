<?php

namespace ContaoEstateManager\EstateManager\EventListener\DataContainer;

use Contao\Backend;
use Contao\CoreBundle\Framework\Adapter;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\Security\ContaoCorePermissions;
use Contao\CoreBundle\ServiceAnnotation\Callback;
use Contao\CoreBundle\Slug\Slug;
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
    protected string $table = 'tl_real_estate';

    private ContaoFramework $framework;
    private Security $security;
    private Slug $slug;
    private RealEstateDcaHelper $dcaHelper;

    /**
     * @var Adapter<Image>
     */
    private Adapter $image;

    /**
     * @var Adapter<Backend>
     */
    private Adapter $backend;

    /**
     * @var Adapter<System>
     */
    private Adapter $system;

    /**
     * Constructor
     */
    public function __construct(ContaoFramework $framework, Security $security, Slug $slug, RealEstateDcaHelper $dcaHelper)
    {
        $this->framework = $framework;
        $this->dcaHelper = $dcaHelper;
        $this->security = $security;
        $this->slug = $slug;

        $this->image = $this->framework->getAdapter(Image::class);
        $this->backend = $this->framework->getAdapter(Backend::class);
        $this->system = $this->framework->getAdapter(System::class);
    }

    /**
     * Auto-generate a real estate alias if it has not been set yet
     *
     * @Callback(table="tl_real_estate", target="fields.alias.save")
     */
    public function generateAlias($varValue, $dc, string $title=''): string
    {
        if($varValue)
        {
            if($this->dcaHelper->aliasExists($varValue, $this->table, $dc->id))
            {
                throw new \RuntimeException('Alias already exists.');
            }

            return $varValue;
        }

        // Generate an alias if there is none
        return $this->slug->generate(
            ($dc->activeRecord !== null ? $dc->activeRecord->objekttitel : $title),
            [],
            fn ($alias) => $this->dcaHelper->aliasExists($alias, $this->table, $dc->id)
        );
    }

    /**
     * Return the edit header button
     *
     * @Callback(table="tl_real_estate", target="list.operations.edit.button")
     */
    public function editHeaderButton(array $row, string $href, string $label, string $title, string $icon, string $attributes): string
    {
        // Check if a user has access
        if(!$this->security->isGranted(ContaoCorePermissions::USER_CAN_EDIT_FIELDS_OF_TABLE, $this->table))
        {
            return $this->image->getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).' ';
        }

        // Get default route
        $strHref = $this->backend->addToUrl($href.'&amp;id='.$row['id']);

        // If the backend-real-estate-management package exists, set the route to the new backend management
        if(array_key_exists('contao-estatemanager/backend-real-estate-management', $this->system->getContainer()->getParameter('kernel.packages')))
        {
            $strHref = '/contao/realestate/edit/'.$row['id'];
        }

        // Return edit button
        return vsprintf('<a href="%s" title="%s"%s>%s</a> ', [
            $strHref,
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
        // Return all provider
        return $this->dcaHelper->getAllProvider();
    }

    /**
     * Return all provider as array
     *
     * @Callback(table="tl_real_estate", target="fields.contactPerson.options")
     */
    public function contactPersonOptionsCallback(DataContainer $dc): array
    {
        // Return all contact persons
        return $this->dcaHelper->getContactPersons($dc);
    }
}
