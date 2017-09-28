<?php

namespace NET\SF\AppStatusBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('netsf_app_status');
        $rootNode
            ->children()
                ->arrayNode('web_services')
                        ->prototype('array')
                            ->children()
                                    ->scalarNode('name')->isRequired(true)->end()
                                        ->scalarNode('url')->isRequired()->cannotBeEmpty()
                                            ->validate()
                                            ->ifTrue(function ($v) { return !filter_var($v, FILTER_VALIDATE_URL); })
                                            ->thenInvalid('Url non Valide.')
                                            ->end()
                                        ->end()
                                    ->scalarNode('expectedCode')->defaultValue(200)->end()
                                    ->scalarNode('group')->defaultValue("AUTRE")->end()
                                    ->scalarNode('description')->defaultValue("")->end()
                                        ->scalarNode('body')->defaultValue("{}")
                                            ->validate()
                                            ->ifTrue(function ($checkJson) { return !json_decode($checkJson);})
                                            ->thenInvalid('Json non Valide.')
                                            ->end()
                                        ->end()
                                    ->scalarNode('options')->defaultValue('{}')
                                        ->validate()
                                        ->ifTrue(function ($checkJson) { return !json_decode($checkJson);})
                                        ->thenInvalid('Json non Valide.')
                                        ->end()
                                        ->end()
                                    ->scalarNode('method')->defaultValue("GET")->end()
                            ->end()
                        ->end()
                ->end() // twitter
            ->end();
        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        return $treeBuilder;
    }
}
