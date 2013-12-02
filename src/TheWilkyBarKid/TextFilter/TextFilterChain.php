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

use Countable;
use InvalidArgumentException;
use SplPriorityQueue;
use Traversable;

/**
 * Text filter chain.
 *
 * Runs text filters one after another.
 */
class TextFilterChain extends AbstractTextFilter implements Countable
{
    /**
     * @var TextFilter[]|SplPriorityQueue
     */
    protected $filters;

    /**
     * Constructor.
     *
     * @param TextFilter[] $filters
     *
     * @throws InvalidArgumentException
     */
    public function __construct($filters = array())
    {
        if (false === is_array($filters) && false === $filters instanceof Traversable) {
            throw new InvalidArgumentException(
                sprintf('An array or traversable object must be provided, got ' . gettype($filters))
            );
        }

        $this->filters = new SplPriorityQueue();
        $i = count($filters);
        foreach ($filters as $filter) {
            $this->insert($filter, $i);
            $i--;
        }
    }

    /**
     * Insert a text filter.
     *
     * @param TextFilter $filter
     * @param int|null   $priority
     */
    public function insert(TextFilter $filter, $priority = null)
    {
        $this->filters->insert($filter, $priority ? : 0);
    }

    protected function doFilter($text)
    {
        foreach (clone $this->filters as $filter) {
            $text = $filter->filter($text);
        }

        return $text;
    }

    public function count()
    {
        return $this->filters->count();
    }
}
