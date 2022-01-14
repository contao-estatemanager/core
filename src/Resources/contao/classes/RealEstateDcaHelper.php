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

use Contao\Backend;
use Contao\DataContainer;

/**
 * Collection class for recurring DCA functions around real estate fields
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class RealEstateDcaHelper extends Backend
{
    /**
     * Make the constructor public
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Check if an alias exists
     */
    public function aliasExists(string $alias, string $table, int $id, string $field = 'alias'): bool
    {
        return $this->Database->prepare('SELECT id FROM '.$table.' WHERE '.$field.'=?  AND id!=?')->execute($alias, $id)->numRows > 0;
    }

    /**
     * Return all contact persons
     */
    public function getContactPersons(DataContainer $dc): array
    {
        $arrContactPersons = array();

        if ($dc->activeRecord === null)
        {
            $objContactPersons = $this->Database->execute("SELECT id, name, vorname FROM tl_contact_person");

            if ($objContactPersons->numRows < 1)
            {
                return array();
            }

            while ($objContactPersons->next())
            {
                $arrContactPersons[$objContactPersons->id] = $objContactPersons->vorname . ' ' . $objContactPersons->name;
            }

            return $arrContactPersons;
        }

        $objContactPersons = $this->Database->prepare("SELECT id, name, vorname FROM tl_contact_person WHERE pid=?")->execute($dc->activeRecord->provider);

        if ($objContactPersons->numRows < 1)
        {
            return array();
        }

        while ($objContactPersons->next())
        {
            $arrContactPersons[$objContactPersons->id] = $objContactPersons->vorname . ' ' . $objContactPersons->name;
        }

        return $arrContactPersons;
    }

    /**
     * Return all provider
     */
    public function getAllProvider(): array
    {
        $objProviders = $this->Database->execute("SELECT id, anbieternr, firma FROM tl_provider");

        if ($objProviders->numRows < 1)
        {
            return array();
        }

        $arrProviders = array();

        while ($objProviders->next())
        {
            $arrProviders[$objProviders->id] = $objProviders->firma . ' (' . $objProviders->anbieternr . ')';
        }

        return $arrProviders;
    }
}
