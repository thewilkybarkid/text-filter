<?php

/*
 * This file is part of the TextFilter library.
 *
 * (c) Chris Wilkinson
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace spec\TheWilkyBarKid\TextFilter;

use Doctrine\Common\Cache\Cache;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TheWilkyBarKid\TextFilter\TextFilter;

class DoctrineCacheTextFilterWrapperSpec extends ObjectBehavior
{
    public function let(Cache $cache, TextFilter $filter)
    {
        $this->beConstructedWith($cache, $filter);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('TheWilkyBarKid\TextFilter\DoctrineCacheTextFilterWrapper');
        $this->shouldBeAnInstanceOf('TheWilkyBarKid\TextFilter\TextFilter');
    }

    public function it_should_use_a_cached_value(Cache $cache, TextFilter $filter)
    {
        $text = 'foo';

        $cache->contains(Argument::type('string'))->willReturn(true);
        $cache->fetch(Argument::type('string'))->willReturn('bar');
        $filter->filter($text)->shouldNotBeCalled();

        $this->filter($text)->shouldReturn('bar');
    }

    public function it_should_cache_a_new_value(Cache $cache, TextFilter $filter)
    {
        $text = 'foo';

        $cache->contains(Argument::type('string'))->willReturn(false);
        $cache->fetch(Argument::type('string'))->shouldNotBeCalled();
        $filter->filter($text)->willReturn('bar');
        $cache->save(Argument::type('string'), 'bar')->shouldBeCalled();

        $this->filter($text)->shouldReturn('bar');
    }

    public function it_should_throw_an_exception_on_a_failure(Cache $cache)
    {
        $cache->contains(Argument::type('string'))->willReturn(true);
        $cache->fetch(Argument::type('string'))->willReturn(false);

        $this->shouldThrow('TheWilkyBarKid\TextFilter\Exception\TextFilterFailedException')
          ->during('filter', array('foo'));
    }

    public function it_should_throw_an_exception_on_an_exception(Cache $cache)
    {
        $cache->contains(Argument::type('string'))->willReturn(true);
        $cache->fetch(Argument::type('string'))->willThrow('Exception');

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
