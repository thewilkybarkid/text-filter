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

use InvalidArgumentException;
use TheWilkyBarKid\TextFilter\Exception\TextFilterFailedException;

/**
 * Text filter interface.
 */
interface TextFilter
{
    /**
     * Filter text.
     *
     * @param string $text Text to filter.
     *
     * @return string Filtered text.
     *
     * @throws InvalidArgumentException
     * @throws TextFilterFailedException
     */
    public function filter($text);
}
