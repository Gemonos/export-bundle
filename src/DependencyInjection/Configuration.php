<?php

namespace Gemonos\ExportBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('gemonos_export');

        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->scalarNode('export_path')
            ->defaultValue('%kernel.project_dir%/var/export')
            ->end()
            ->end();

        return $treeBuilder;
    }
}
