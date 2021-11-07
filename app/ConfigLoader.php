<?php

namespace RabbitMQApp;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class ConfigLoader
 * @package RabbitMQApp
 */
class ConfigLoader
{
    /**
     * @param $path
     * @return array
     * @throws \Exception
     */
    public function loadConfig($path): array
    {
        if (!file_exists($path)) {
            throw new \InvalidArgumentException(sprintf('`%s` config not found ', $path));
        }

        $containerBuilder = new ContainerBuilder();
        $loader = new YamlFileLoader($containerBuilder, new FileLocator(__DIR__));
        $loader->load($path);

        $containerBuilder->compile(true);

        return $containerBuilder->getParameterBag()->all();
    }
}
