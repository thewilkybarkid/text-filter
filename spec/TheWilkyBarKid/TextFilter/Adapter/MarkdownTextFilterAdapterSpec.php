<?php

/*
 * This file is part of the TextFilter library.
 *
 * (c) Chris Wilkinson
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace spec\TheWilkyBarKid\TextFilter\Adapter;

use Michelf\Markdown;
use PhpSpec\ObjectBehavior;

class MarkdownTextFilterAdapterSpec extends ObjectBehavior
{
    public function let(Markdown $markdown)
    {
        $this->beConstructedWith($markdown);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('TheWilkyBarKid\TextFilter\Adapter\MarkdownTextFilterAdapter');
        $this->shouldBeAnInstanceOf('TheWilkyBarKid\TextFilter\TextFilter');
    }

    public function it_filters_text(Markdown $markdown)
    {
        $markdown->transform('foo')->willReturn('bar');

        $this->filter('foo')->shouldReturn('bar');
    }

    public function it_should_throw_an_exception_on_a_failure(Markdown $markdown)
    {
        $markdown->transform('foo')->willReturn(false);

        $this->shouldThrow('TheWilkyBarKid\TextFilter\Exception\TextFilterFailedException')
          ->during('filter', array('foo'));
    }

    public function it_should_throw_an_exception_on_an_exception(Markdown $markdown)
    {
        $markdown->transform('bar')->willThrow('Exception');

        $this->shouldThrow('TheWilkyBarKid\TextFilter\Exception\TextFilterFailedException')
          ->during('filter', array('foo'));
    }

    public function it_should_reject_non_strings()
    {
        foreach (array(1, false, $this) as $test) {
            $this->shouldThrow('InvalidArgumentException')->during('filter', array($test));
        }
    }
}
