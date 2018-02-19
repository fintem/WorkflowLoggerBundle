<?php

namespace WorkflowLoggerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('workflow_logger');

        $rootNode
            ->children()
                ->booleanNode('logging')
                    ->defaultTrue()
                    ->info('Set it to false to stop logging workflows.')
                ->end()
                ->arrayNode('workflows')
                    ->scalarPrototype()
                ->end()

            ->end()
        ;

        return $treeBuilder;
    }
}
