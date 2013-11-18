<?php

/*
 * This file is part of the TextFilter library.
 *
 * (c) Chris Wilkinson
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace spec\TheWilkyBarKid\TextFilter\Exception;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TextFilterFailedExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('TheWilkyBarKid\TextFilter\Exception\TextFilterFailedException');
        $this->shouldBeAnInstanceOf('RuntimeException');
    }
}
