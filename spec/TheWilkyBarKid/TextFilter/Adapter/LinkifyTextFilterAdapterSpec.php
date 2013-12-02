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

use Misd\Linkify\Linkify;
use PhpSpec\ObjectBehavior;

class LinkifyTextFilterAdapterSpec extends ObjectBehavior
{
    public function let(Linkify $linkify)
    {
        $this->beConstructedWith($linkify);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('TheWilkyBarKid\TextFilter\Adapter\LinkifyTextFilterAdapter');
        $this->shouldBeAnInstanceOf('TheWilkyBarKid\TextFilter\TextFilter');
    }

    public function it_filters_text(Linkify $linkify)
    {
        $linkify->process('foo')->willReturn('bar');

        $this->filter('foo')->shouldReturn('bar');
    }

    public function it_should_throw_an_exception_on_a_failure(Linkify $linkify)
    {
        $linkify->process('foo')->willReturn(false);

        $this->shouldThrow('TheWilkyBarKid\TextFilter\Exception\TextFilterFailedException')
          ->during('filter', array('foo'));
    }

    public function it_should_throw_an_exception_on_an_exception(Linkify $linkify)
    {
        $linkify->process('bar')->willThrow('Exception');

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
