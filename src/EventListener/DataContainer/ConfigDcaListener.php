<?php

namespace ContaoEstateManager\EstateManager\EventListener\DataContainer;

use Contao\CoreBundle\ServiceAnnotation\Callback;
use Contao\DataContainer;

/**
 * Callback handler for the table tl_real_estate_config.
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class ConfigDcaListener
{
    /**
     * Generate Api key if no own one has been set.
     *
     * @Callback(table="tl_real_estate_config", target="fields.apiKey.save")
     */
    public function onSaveApiKey($value, DataContainer $dc)
    {
        if(!trim($value))
        {
            $value = bin2hex(random_bytes(12));
        }

        return $value;
    }
}
