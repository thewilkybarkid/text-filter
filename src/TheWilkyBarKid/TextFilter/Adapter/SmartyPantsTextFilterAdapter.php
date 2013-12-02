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

use Michelf\SmartyPants;
use TheWilkyBarKid\TextFilter\AbstractTextFilter;

/**
 * SmartyPants text filter adapter.
 */
class SmartyPantsTextFilterAdapter extends AbstractTextFilter
{
    /**
     * @var SmartyPants
     */
    protected $smartyPants;

    /**
     * Constructor.
     *
     * @param SmartyPants $smartyPants
     */
    public function __construct(SmartyPants $smartyPants)
    {
        $this->smartyPants = $smartyPants;
    }

    protected function doFilter($text)
    {
        return $this->smartyPants->transform($text);
    }
}
