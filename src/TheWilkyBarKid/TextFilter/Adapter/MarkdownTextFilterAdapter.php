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

use Michelf\Markdown;
use TheWilkyBarKid\TextFilter\AbstractTextFilter;

/**
 * Markdown text filter adapter.
 */
class MarkdownTextFilterAdapter extends AbstractTextFilter
{
    /**
     * @var Markdown
     */
    protected $markdown;

    /**
     * Constructor.
     *
     * @param Markdown $markdown
     */
    public function __construct(Markdown $markdown)
    {
        $this->markdown = $markdown;
    }

    protected function doFilter($text)
    {
        return $this->markdown->transform($text);
    }
}
