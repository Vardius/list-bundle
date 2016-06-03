<?php
/**
 * This file is part of the vardius/list-bundle package.
 *
 * (c) Rafał Lorenz <vardius@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vardius\Bundle\ListBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration
 *
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 *
 * @author Rafał Lorenz <vardius@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('vardius_list');

        $rootNode
            ->children()
                ->booleanNode('paginator')
                    ->defaultTrue()
                ->end()
                ->integerNode('limit')
                    ->min(1)
                    ->defaultValue(10)
                ->end()
                ->enumNode('db_driver')
                    ->defaultValue('orm')
                    ->values(['orm', 'propel', 'elasticsearch'])
                ->end()
            ->end();

        return $treeBuilder;
    }
}
