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

use ArrayObject;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SplPriorityQueue;
use stdClass;
use TheWilkyBarKid\TextFilter\TextFilter;

class TextFilterChainSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('TheWilkyBarKid\TextFilter\TextFilterChain');
        $this->shouldBeAnInstanceOf('TheWilkyBarKid\TextFilter\TextFilter');
        $this->shouldBeAnInstanceOf('Countable');
    }

    public function it_should_take_an_array(TextFilter $filter1, TextFilter $filter2, TextFilter $filter3)
    {
        $this->beConstructedWith(array($filter1, $filter2, $filter3));

        $filter1->filter('foo')->willReturn('bar');
        $filter2->filter('bar')->willReturn('baz');
        $filter3->filter('baz')->willReturn('qux');

        $this->filter('foo')->shouldReturn('qux');
    }

    public function it_should_take_a_traversable_object(TextFilter $filter1, TextFilter $filter2, TextFilter $filter3)
    {
        $filter1->filter('foo')->willReturn('bar');
        $filter2->filter('bar')->willReturn('baz');
        $filter3->filter('baz')->willReturn('qux');

        $this->beConstructedWith(
            new ArrayObject(array(
                $filter1->getWrappedObject(),
                $filter2->getWrappedObject(),
                $filter3->getWrappedObject()
            ))
        );

        $this->filter('foo')->shouldReturn('qux');
    }

    public function it_should_reject_something_that_is_not_an_array_nor_a_traversable()
    {
        foreach (array('foo', null, false, new stdClass()) as $test) {
            $this->shouldThrow('InvalidArgumentException')->during('__construct', array($test));
        }
    }

    public function it_should_call_filters_in_priority_order(TextFilter $filter1, TextFilter $filter2, TextFilter $filter3)
    {
        $this->insert($filter1, 1);
        $this->insert($filter2, 10);
        $this->insert($filter3, 5);

        $filter2->filter('foo')->willReturn('bar');
        $filter3->filter('bar')->willReturn('baz');
        $filter1->filter('baz')->willReturn('qux');

        $this->filter('foo')->shouldReturn('qux');
    }

    public function it_should_call_filters_in_an_existing_order(TextFilter $filter1, TextFilter $filter2, TextFilter $filter3)
    {
        $filter2->filter('foo')->willReturn('bar');
        $filter3->filter('bar')->willReturn('baz');
        $filter1->filter('baz')->willReturn('qux');

        $filters = new SplPriorityQueue();

        $filters->insert($filter1->getWrappedObject(), 1);
        $filters->insert($filter2->getWrappedObject(), 10);
        $filters->insert($filter3->getWrappedObject(), 5);

        $this->beConstructedWith($filters);

        $this->filter('foo')->shouldReturn('qux');
    }

    public function it_should_do_nothing_if_it_has_no_filters()
    {
        $this->filter('foo')->shouldReturn('foo');
    }

    public function it_should_throw_an_exception_on_a_failure(TextFilter $filter1, TextFilter $filter2, TextFilter $filter3)
    {
        $this->beConstructedWith(array($filter1, $filter2, $filter3));

        $filter1->filter('foo')->willReturn('bar');
        $filter2->filter('bar')->willReturn(false);
        $filter3->filter(Argument::type('string'))->shouldNotBeCalled();

        $this->shouldThrow('TheWilkyBarKid\TextFilter\Exception\TextFilterFailedException')
          ->during('filter', array('foo'));
    }

    public function it_should_throw_an_exception_on_an_exception(TextFilter $filter1, TextFilter $filter2, TextFilter $filter3)
    {
        $this->beConstructedWith(array($filter1, $filter2, $filter3));

        $filter1->filter('foo')->willReturn('bar');
        $filter2->filter('bar')->willThrow('Exception');
        $filter3->filter(Argument::type('string'))->shouldNotBeCalled();

        $this->shouldThrow('TheWilkyBarKid\TextFilter\Exception\TextFilterFailedException')
          ->during('filter', array('foo'));
    }

    public function it_should_reject_non_strings()
    {
        foreach (array(1, false, new stdClass()) as $test) {
            $this->shouldThrow('InvalidArgumentException')->during('filter', array($test));
        }
    }

    public function it_should_be_countable(TextFilter $filter1, TextFilter $filter2, TextFilter $filter3)
    {
        $this->beConstructedWith(array($filter1, $filter2, $filter3));

        $this->count()->shouldReturn(3);
    }
}
