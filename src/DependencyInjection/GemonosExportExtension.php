<?php

namespace Gemonos\ExportBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;

class GemonosExportExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // Définit le chemin d'exportation comme paramètre de service
        $container->setParameter('gemonos_export.export_path', $config['export_path']);
    }
}
