<?php

declare(strict_types=1);

namespace ContaoEstateManager\EstateManager\EventListener\DataContainer;

use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\DataContainer;
use Doctrine\DBAL\Connection;

/**
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
trait DcaListenerTrait
{
    private ContaoFramework $framework;
    private Connection $connection;

    /**
     * Check if an alias exists
     */
    public function aliasExists(string $alias, string $table, int $id, string $field = 'alias'): bool
    {
        $count = $this->connection->fetchOne(
            'SELECT COUNT(*) FROM '.$this->connection->quoteIdentifier($table).' WHERE id != :id AND '.$this->connection->quoteIdentifier($field).' = :alias',
            [
                'id' => $id,
                'alias' => $alias,
            ]
        );

        return (int) $count > 0;
    }

    /**
     * Return all provider
     */
    public function getAllProvider(): array
    {
        $objProviders = $this->connection->fetchAllAssociative("SELECT id, anbieternr, firma FROM tl_provider");
        $arrProviders = [];

        foreach ($objProviders as $objProvider)
        {
            $arrProviders[$objProvider['id']] = $objProvider['firma'] . ' (' . $objProvider['anbieternr'] . ')';
        }

        return $arrProviders;
    }

    /**
     * Return all contact persons
     */
    public function getContactPersons(DataContainer $dc): array
    {
        $arrContactPersons = [];

        if ($dc->activeRecord === null)
        {
            $objContactPersons = $this->connection->fetchAllAssociative("SELECT id, name, vorname FROM tl_contact_person");

            foreach ($objContactPersons as $objContactPerson)
            {
                $arrContactPersons[$objContactPerson['id']] = $objContactPerson['vorname'] . ' ' . $objContactPerson['name'];
            }

            return $arrContactPersons;
        }

        $objContactPersons = $this->connection->fetchAllAssociative("SELECT id, name, vorname FROM tl_contact_person WHERE pid=" . $dc->activeRecord->provider);

        foreach ($objContactPersons as $objContactPerson)
        {
            $arrContactPersons[$objContactPerson['id']] = $objContactPerson['vorname'] . ' ' . $objContactPerson['name'];
        }

        return $arrContactPersons;
    }
}
