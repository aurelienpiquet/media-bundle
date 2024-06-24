<?php

declare(strict_types=1);

namespace Apb\MediaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('media_bundle');

        $treeBuilder
            ->getRootNode()
                ->children()
                    ->arrayNode('configuration')
                    ->addDefaultsIfNotSet()
                        ->children()
                        ->scalarNode('default_path')->defaultValue('%kernel.project_dir%/private/files')->end()
                        ->append($this->getAllowedMineTypes())
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }

    private function getAllowedMineTypes(): ArrayNodeDefinition
    {
        $node = new ArrayNodeDefinition('allowed_mime_types');

        $node
            ->beforeNormalization()
            ->always(function ($v) {
                if ($v === '*') {
                    return ['*'];
                }

                return $v;
            })
            ->end()
            ->prototype('scalar')->end()
        ;

        return $node;
    }
}