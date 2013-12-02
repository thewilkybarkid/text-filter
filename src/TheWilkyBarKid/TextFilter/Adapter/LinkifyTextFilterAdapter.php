<?php

/*
 * This file is part of the TextFilter library.
 *
 * (c) Chris Wilkinson
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace TheWilkyBarKid\TextFilter\Adapter;

use Misd\Linkify\Linkify;
use TheWilkyBarKid\TextFilter\AbstractTextFilter;

/**
 * Linkify text filter adapter.
 */
class LinkifyTextFilterAdapter extends AbstractTextFilter
{
    /**
     * @var Linkify
     */
    protected $linkify;

    /**
     * Constructor.
     *
     * @param Linkify $linkify
     */
    public function __construct(Linkify $linkify)
    {
        $this->linkify = $linkify;
    }

    protected function doFilter($text)
    {
        return $this->linkify->process($text);
    }
}
