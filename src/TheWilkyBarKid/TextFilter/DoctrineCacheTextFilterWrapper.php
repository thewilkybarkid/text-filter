<?php

/*
 * This file is part of the TextFilter library.
 *
 * (c) Chris Wilkinson
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace TheWilkyBarKid\TextFilter;

use Doctrine\Common\Cache\Cache;

/**
 * Doctrine Cache text filter wrapper.
 *
 * Caches the output of a text filter, which it will serve if the same input is
 * requested again.
 */
class DoctrineCacheTextFilterWrapper extends AbstractTextFilter
{
    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var TextFilter
     */
    protected $filter;

    /**
     * Constructor.
     *
     * @param Cache      $cache
     * @param TextFilter $filter
     */
    public function __construct(Cache $cache, TextFilter $filter)
    {
        $this->cache = $cache;
        $this->filter = $filter;
    }

    protected function doFilter($text)
    {
        $key = md5($text);

        if (true === $this->cache->contains($key)) {
            $result = $this->cache->fetch($key);

            if (false !== $result) {
                return $result;
            }
        }

        $text = $this->filter->filter($text);

        $this->cache->save($key, $text);

        return $text;
    }
}
