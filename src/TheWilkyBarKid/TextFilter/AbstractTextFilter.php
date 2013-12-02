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

use Exception;
use InvalidArgumentException;
use RuntimeException;
use TheWilkyBarKid\TextFilter\Exception\TextFilterFailedException;

/**
 * Handles the input/output type/exception checking required for text filters.
 * Implement your logic in the `doFilter()` method.
 */
abstract class AbstractTextFilter implements TextFilter
{
    final public function filter($text)
    {
        if (true === is_object($text) && false === method_exists($text, '__toString')) {
            throw new InvalidArgumentException('Unable to cast object to a string');
        } elseif (false === is_string($text)) {
            throw new InvalidArgumentException('Expected string, got ' . gettype($text));
        }

        try {
            $result = $this->doFilter((string) $text);

            if (false === is_string($result)) {
                throw new RuntimeException('Expected string result, got ' . gettype($result));
            }
        } catch (Exception $e) {
            if ($e instanceof TextFilterFailedException) {
                throw $e;
            }

            throw new TextFilterFailedException('Failed to filter text', null, $e);
        }

        return $result;
    }

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
    abstract protected function doFilter($text);
}
