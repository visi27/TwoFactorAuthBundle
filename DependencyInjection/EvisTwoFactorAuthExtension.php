<?php

namespace Evis\TwoFactorAuthBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class EvisTwoFactorAuthExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if (isset($config['homepage_route'])) {
            $container->setParameter('homepage_route', $config['homepage_route']);
        }else{
            $container->setParameter('homepage_route', 'homepage');
        }

        if (isset($config['user_dashboard_route'])) {
            $container->setParameter('user_dashboard_route', $config['user_dashboard_route']);
        }else{
            $container->setParameter('user_dashboard_route', 'user_dashboard');
        }

        if (isset($config['encryption_service'])) {
            $container->setParameter('encryption_service', $config['encryption_service']);
        }else{
            $container->setParameter('encryption_service', 'app.security.encryption_service');
        }
    }
}
