<?php

namespace ContaoEstateManager\EstateManager\EventListener\DataContainer;

use Contao\Backend;
use Contao\Config;
use Contao\CoreBundle\Framework\Adapter;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\Security\ContaoCorePermissions;
use Contao\CoreBundle\ServiceAnnotation\Callback;
use Contao\CoreBundle\Slug\Slug;
use Contao\DataContainer;
use Contao\FilesModel;
use Contao\Image;
use Contao\StringUtil;
use Contao\System;
use ContaoEstateManager\Translator;
use Doctrine\DBAL\Connection;
use Symfony\Component\Security\Core\Security;

/**
 * Callback handler for the table tl_real_estate.
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class RealEstateDcaListener
{
    use DcaListenerTrait;

    private Security $security;
    private Slug $slug;

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
     * @var string
     */
    private $projectDir;

    /**
     * Constructor
     */
    public function __construct(ContaoFramework $framework, Connection $connection, Security $security, Slug $slug)
    {
        $this->framework = $framework;
        $this->connection = $connection;

        $this->security = $security;
        $this->slug = $slug;

        $this->image = $this->framework->getAdapter(Image::class);
        $this->backend = $this->framework->getAdapter(Backend::class);
        $this->system = $this->framework->getAdapter(System::class);

        $this->projectDir = $this->system->getContainer()->getParameter('kernel.project_dir');
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
            if($this->aliasExists($varValue, $dc->table, $dc->id))
            {
                throw new \RuntimeException('Alias already exists.');
            }

            return $varValue;
        }

        // Generate an alias if there is none
        return $this->slug->generate(
            ($dc->activeRecord !== null ? $dc->activeRecord->objekttitel : $title),
            [],
            fn ($alias) => $this->aliasExists($alias, $dc->table, $dc->id)
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
        if(!$this->security->isGranted(ContaoCorePermissions::USER_CAN_EDIT_FIELDS_OF_TABLE, 'tl_real_estate'))
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
     * @Callback(table="tl_real_estate", target="list.label.label")
     */
    public function addPreviewImageAndInformation(array $row, string $label, DataContainer $dc, array $args): array
    {
        $objFile = null;
        $strImage = '';

        // Check if a title image exists, otherwise use the fallback image
        if ($row['titleImageSRC'] != '')
        {
            $objFile = FilesModel::findByUuid($row['titleImageSRC']);
        }

        if (($objFile === null || !is_file($objFile->getAbsolutePath())) && Config::get('defaultImage'))
        {
            $objFile = FilesModel::findByUuid(Config::get('defaultImage'));
        }

        $strRoot = System::getContainer()->getParameter('kernel.project_dir');

        // If a picture could be used, add it to the arguments
        if ($objFile !== null && is_file($strRoot . '/' . $objFile->path))
        {
            $imageUrl = $this->system->getContainer()
                                     ->get('contao.image.image_factory')
                                     ->create($objFile->getAbsolutePath(), array(85, 55, 'center_center'))
                                     ->getUrl($this->projectDir);

            $strImage = vsprintf('<div class="image">%s</div>', [
                $this->image->getHtml($imageUrl, '', 'class="estate_preview"')
            ]);
        }

        // Create info block
        $strInfo = vsprintf('<div class="info"><div><span>ID:</span> <span>%s</span></div><div><span>Intern:</span> <span>%s</span></div><div><span>Extern:</span> <span>%s</span></div></div>', [
            $row['id'],
            $row['objektnrIntern'],
            $row['objektnrExtern']
        ]);

        // Inserting the information tile
        $args[0] = vsprintf('<div class="object-information">%s%s</div>', [
            $strImage,
            $strInfo
        ]);

        // Add address information
        $args[1] .= vsprintf('<div style="color:#999;display:block;margin-top:5px">%s %s%s%s %s</div>', [
            $row['plz'],
            $row['ort'],
            ($row['strasse'] || $row['hausnummer'] ? ' · ' : ''),
            $row['strasse'],
            $row['hausnummer']
        ]);

        // Extend object type information
        $args[2] .= vsprintf('<div style="color:#999;display:block;margin-top:5px">%s</div>', [
            $this->getTranslatedType($row)
        ]);

        // Extend marketing type information
        $strTypeOfUse = $args[3];

        $args[3] = $this->getTranslatedMarketingtype($row);
        $args[3] .= vsprintf('<div style="color:#999;display:block;margin-top:5px">%s</div>', [
            $strTypeOfUse
        ]);

        // Translate date
        $args[5] = date(Config::get('datimFormat'), $args[5]);

        // Hook to integrate further information
        if (is_array($GLOBALS['TL_DCA']['tl_real_estate']['list']['label']['post_label_callbacks'] ?? null))
        {
            foreach ($GLOBALS['TL_DCA']['tl_real_estate']['list']['label']['post_label_callbacks'] as $callback)
            {
                $args = $this->system->importStatic($callback[0])->{$callback[1]}($row, $label, $dc, $args);
            }
        }

        return $args;
    }

    /**
     * Return all provider as array
     *
     * @Callback(table="tl_real_estate", target="fields.provider.options")
     */
    public function providerOptionsCallback(): array
    {
        return $this->getAllProvider();
    }

    /**
     * Return all provider as array
     *
     * @Callback(table="tl_real_estate", target="fields.contactPerson.options")
     */
    public function contactPersonOptionsCallback(DataContainer $dc): array
    {
        return $this->getContactPersons($dc);
    }

    /**
     * Return translated object type by real estate row
     *
     * @param array $row
     *
     * @return string
     */
    private function getTranslatedType(array $row): string
    {
        $subpalette = $GLOBALS['TL_DCA']['tl_real_estate']['subpalettes']['objektart_'.$row['objektart']] ?? null;

        if(!$subpalette)
        {
            return '';
        }

        $type = $row[$subpalette];

        if (empty($type))
        {
            return '';
        }

        return Translator::translateValue($subpalette . '_' . $type);
    }

    /**
     * Return translated marketing types by real estate row
     *
     * @param array $row
     *
     * @return string
     */
    private function getTranslatedMarketingtype(array $row): string
    {
        $arrMarketingTypes = [];
        $availableMarketingTypes = ['vermarktungsartKauf', 'vermarktungsartMietePacht', 'vermarktungsartErbpacht', 'vermarktungsartLeasing'];

        foreach ($availableMarketingTypes as $marketingType)
        {
            if ($row[$marketingType] === '1')
            {
                $arrMarketingTypes[] = $marketingType;
            }
        }

        foreach ($arrMarketingTypes as $index => $marktingType)
        {
            $arrMarketingTypes[$index] = Translator::translateLabel($marktingType);
        }

        return implode(' / ', $arrMarketingTypes);
    }
}
