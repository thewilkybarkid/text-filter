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

use HTMLPurifier;
use TheWilkyBarKid\TextFilter\AbstractTextFilter;

/**
 * HTMLPurifier text filter adapter.
 */
class HTMLPurifierTextFilterAdapter extends AbstractTextFilter
{
    /**
     * @var HTMLPurifier
     */
    protected $htmlPurifier;

    /**
     * Constructor.
     *
     * @param HTMLPurifier $htmlPurifier
     */
    public function __construct(HTMLPurifier $htmlPurifier)
    {
        $this->htmlPurifier = $htmlPurifier;
    }

    protected function doFilter($text)
    {
        return $this->htmlPurifier->purify($text);
    }
}
