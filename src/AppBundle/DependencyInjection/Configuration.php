<?php
/**
 * Configuration.php
 * restfully
 * Date: 08.04.17
 */

namespace AppBundle\DependencyInjection;


use AppBundle\Controller\ResourceController;
use AppBundle\Manager\ResourceManager;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('app');

        $rootNode
            ->children()
                ->arrayNode('resources')
                ->useAttributeAsKey('name')
                ->prototype('array')
                    ->children()
                        ->scalarNode('model')->end()
                        ->scalarNode('manager')
                            ->defaultValue(ResourceManager::class)
                        ->end()
                        ->scalarNode('controller')
                            ->defaultValue(ResourceController::class)
                        ->end()
                    ->end()
            ->end()
            ;

        return $treeBuilder;
    }
}