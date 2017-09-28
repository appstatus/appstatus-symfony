<?php

namespace NET\SF\AppStatusBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class NETSFAppStatusExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container) {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('name', $config['web_services'][key($config['web_services'])]['name']);
        $container->setParameter('url', $config['web_services'][key($config['web_services'])]['url']);
        $container->setParameter('group', $config['web_services'][key($config['web_services'])]['group']);
        $container->setParameter('description', $config['web_services'][key($config['web_services'])]['description']);
        $container->setParameter('expectedCode', $config['web_services'][key($config['web_services'])]['expectedCode']);
        $container->setParameter('method', $config['web_services'][key($config['web_services'])]['method']);
        $container->setParameter('options', $config['web_services'][key($config['web_services'])]['options']);
        $container->setParameter('web_services', $config['web_services']);
        
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }
}
