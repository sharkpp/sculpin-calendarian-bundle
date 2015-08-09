<?php

/*
 * This file is a part of Calendarian Bundle.
 *
 * Copyright (c) 2015 sharkpp
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sharkpp\Sculpin\Bundle\CalendarianBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration.
 *
 * @author sharkpp <webmaster@sharkpp.net>
 */
class Configuration implements ConfigurationInterface
{
    /**
    * {@inheritdoc}
    */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder;

        $rootNode = $treeBuilder->root('sculpin_calendarian');

        return $treeBuilder;
    }
}
