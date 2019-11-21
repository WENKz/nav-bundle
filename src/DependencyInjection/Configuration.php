<?php

/*
 * This file is part of the NavBundle.
 *
 * (c) Vincent Chalamon <vincentchalamon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace NavBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        if (method_exists(TreeBuilder::class, 'getRootNode')) {
            $treeBuilder = new TreeBuilder('nav');
            $rootNode = $treeBuilder->getRootNode();
        } else {
            $treeBuilder = new TreeBuilder();
            $rootNode = $treeBuilder->root('nav');
        }

        $rootNode
            ->beforeNormalization()
                ->ifTrue(static function ($v) { return \is_string($v['wsdl'] ?? null); })
                ->then(static function ($v) { return ['default' => $v]; })
            ->end()
            ->useAttributeAsKey('name')
            ->arrayPrototype()
                ->children()
                    ->scalarNode('wsdl')
                        ->info('Microsoft Dynamics NAV WSDL uri.')
                        ->isRequired()
                    ->end()
                    ->scalarNode('path')
                        ->info('Path to the entities.')
                        ->isRequired()
                    ->end()
                    ->enumNode('driver')
                        ->values(['annotation'])
                        ->info('ClassMetadata driver.')
                        ->defaultValue('annotation')
                        ->cannotBeEmpty()
                        ->isRequired()
                    ->end()
                    ->arrayNode('options')
                        ->children()
                            ->integerNode('soap_version')->defaultValue(SOAP_1_1)->end()
                            ->integerNode('connection_timeout')->defaultValue(120)->end()
                            ->scalarNode('login')->isRequired()->end()
                            ->scalarNode('password')->isRequired()->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
