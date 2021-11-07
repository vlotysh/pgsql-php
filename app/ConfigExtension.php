<?php

namespace RabbitMQApp;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * Class ConfigExtension
 * @package RabbitMQApp
 */
class ConfigExtension implements ExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {

        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.xml');
    }

    public function getAlias()
    {
        return 'rabbitAMPQ';
    }


    public function getNamespace()
    {
        // TODO: Implement getNamespace() method.
    }

    public function getXsdValidationBasePath()
    {
        // TODO: Implement getXsdValidationBasePath() method.
    }
}