<?php

namespace Ant\SocialRestBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ant_social_rest')
	        ->children()
	        	->scalarNode('db_driver')->cannotBeOverwritten()->isRequired()->end()
                    ->arrayNode('class')
                        ->addDefaultsIfNotSet()
                        ->children()
                        ->scalarNode('profile')->defaultValue('ant.social_rest.model.profile.class.default')->cannotBeEmpty()->end()
                    ->end()
                ->end()
                ->arrayNode('visitors_order')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('default_field')
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->defaultValue('visitDate')
                        ->end()
                        ->scalarNode('default_direction')
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->defaultValue('desc')
                        ->end()
                    ->end()
                ->end()
            ->end()

        ;
        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.


        return $treeBuilder;
    }
}
