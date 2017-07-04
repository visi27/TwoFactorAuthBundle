<?php

namespace Evis\TwoFactorAuthBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('evis_two_factor_auth');

        $rootNode
            ->children()
                ->scalarNode('homepage_route')
                    ->defaultValue('homepage')
                    ->info('Name of homepage route')
                    ->example('my_homepage_route_name')
                ->end()
                ->scalarNode('user_dashboard_route')
                    ->defaultValue('user_dashboard')
                    ->info('Name of user dashboard route')
                    ->example('my_dashboard_route')
                ->end()
                ->scalarNode('encryption_service')
                    ->defaultValue('app.security.encryption_service')
                    ->info('Configuration key of encryptions service')
                    ->example('my.security.encryption.service')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
