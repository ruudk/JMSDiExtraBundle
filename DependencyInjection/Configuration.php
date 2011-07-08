<?php

/*
 * Copyright 2011 Johannes M. Schmitt <schmittjoh@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace JMS\DiExtraBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $tb = new TreeBuilder();

        $tb
            ->root('jms_di_extra', 'array')
                ->children()
                    ->arrayNode('locations')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->booleanNode('all_bundles')->defaultFalse()->end()
                            ->arrayNode('bundles')
                                ->beforeNormalization()
                                    ->ifString()
                                    ->then(function($v) {
                                        return preg_split('/\s*,\s*/', $v);
                                    })
                                ->end()
                                ->prototype('scalar')->end()
                            ->end()
                            ->arrayNode('directories')
                                ->beforeNormalization()
                                    ->ifString()
                                    ->then(function($v) {
                                        return preg_split('/\s*,\s*/', $v);
                                    })
                                ->end()
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                    ->end()
                    ->arrayNode('metadata')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('cache')->defaultValue('file')->cannotBeEmpty()->end()
                            ->arrayNode('file_cache')
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->scalarNode('dir')->defaultValue('%kernel.cache_dir%/diextra/metadata')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $tb;
    }
}