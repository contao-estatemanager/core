<?php

declare(strict_types=1);

namespace ContaoEstateManager\EstateManager\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        /*$treeBuilder = new TreeBuilder('estate_manager_core');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('estate_manager_core');
        }

        $rootNode
            ->children()
            ->scalarNode('host')->defaultValue('')->end()
            ->scalarNode('salt')->defaultValue('estate_manager_core')->end()
            ->booleanNode('log_ip')->defaultFalse()->end()
            ->end()
        ;

        return $treeBuilder;*/
    }
}
