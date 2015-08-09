<?php

/*
 * This file is a part of Calendarian Bundle.
 *
 * Copyright (c) 2015 sharkpp
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sharkpp\Sculpin\Bundle\CalendarianBundle;

use Sculpin\Core\DataProvider\DataProviderManager;
use Sculpin\Core\Generator\GeneratorInterface;
use Sculpin\Core\Source\SourceInterface;

/**
 * Calendarian Generator.
 *
 * @author sharkpp <webmaster@sharkpp.net>
 */
class CalendarianGenerator implements GeneratorInterface
{
    /**
     * Data Provider Manager
     *
     * @var DataProviderManager
     */
    protected $dataProviderManager;

    /**
     * Max per page (default)
     *
     * @var int
     */
    protected $maxPerPage;

    /**
     * Constructor
     *
     * @param DataProviderManager $dataProviderManager Data Provider Manager
     */
    public function __construct(DataProviderManager $dataProviderManager)
    {
        $this->dataProviderManager = $dataProviderManager;
    }

    /**
     * {@inheritdoc}
     */
    public function generate(SourceInterface $source)
    {
        // select data source
        $data = null;
        $config = $source->data()->get('sculpin_calendarian') ?: array();
        if (!isset($config['provider'])) {
            $config['provider'] = 'data.posts';
        }
        if (preg_match('/^(data|page)\.(.+)$/', $config['provider'], $matches)) {
            switch ($matches[1]) {
                case 'data':
                    $data = $this->dataProviderManager->dataProvider($matches[2])->provideData();
                    break;
                case 'page':
                    $data = $source->data()->get($matches[2]);
                    break;
            }
        }

        if (null === $data) {
            return;
        }

        // distribute the post by date
        $page_list = array();
        foreach ($data as $id => $d)
        {
            $year = date('Y****', $d->date());
            $month= date('Ym**', $d->date());
            $day  = date('Ymd', $d->date());

            // add to 'year'
            if (!array_key_exists($year, $page_list)) {
                $page_list[$year] = array();
            }
            $page_list[$year][] = $d;
            // add to 'month'
            if (!array_key_exists($month, $page_list)) {
                $page_list[$month] = array();
            }
            $page_list[$month][] = $d;
            // add to 'day'
            if (!array_key_exists($day, $page_list)) {
                $page_list[$day] = array();
            }
            $page_list[$day][] = $d;
        }

        $pages = array();
        foreach ($page_list as $k => $sources)
        {
            // generate permalink 
            $key = str_replace('/**', '', preg_replace('/(....)(..)(..)/', '$1/$2/$3', $k));
            $permalink = $source->data()->get('permalink') ?: $source->relativePathname();
            $basename = basename($permalink);
            if (preg_match('/^(.+?)\.(.+)$/', $basename, $m)) {
                $permalink = dirname($permalink) . '/' . $key . '/index.' . $m[2];
            } else {
                $permalink = null;
            }

            $page = $source->duplicate(
                                $source->sourceId().':calendarian='.$key
                            );

            $keys = explode('/', $key);
            if (0 < count($keys)) {
                $page->data()->set('calendarian.year', (int)$keys[0]);
            }
            if (1 < count($keys)) {
                $page->data()->set('calendarian.month', (int)$keys[1]);
            }
            if (2 < count($keys)) {
                $page->data()->set('calendarian.day', (int)$keys[2]);
            }

            if (null != $permalink) {
                $page->data()->set('permalink', $permalink);
            }
            $page->data()->set('calendarian.items', $sources);
            $pages[] = $page;
        }

        return $pages;
    }
}
