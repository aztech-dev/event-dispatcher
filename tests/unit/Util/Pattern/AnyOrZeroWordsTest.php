<?php

namespace Aztech\Events\Tests\Util\PatternMatcher;

use Aztech\Events\Util\Pattern\AnyOrZeroWords;

class AnyOrZeroWordsTest extends \PHPUnit_Framework_TestCase
{

    function testEmptyWordsAreConsideredMatches()
    {
        $mock = $this->prophesize('\Aztech\Events\Util\Pattern\Pattern');

        $mock->matches('')->willReturn(true)->shouldNotBeCalled();

        $node = new AnyOrZeroWords($mock->reveal());

        $this->assertTrue($node->matches(''));
    }

    function testOneWordComponentsAreConsideredMatches()
    {
        $mock = $this->prophesize('\Aztech\Events\Util\Pattern\Pattern');

        $mock->matches('bla')->willReturn(true)->shouldNotBeCalled();

        $node = new AnyOrZeroWords($mock->reveal());

        $this->assertTrue($node->matches('bla'));
    }

    function testMultiWordComponentsAreDispatchedToLoopbackNode()
    {
        $mock = $this->prophesize('\Aztech\Events\Util\Pattern\Pattern');

        $mock->matches('blo')->willReturn(true)->shouldBeCalled();
        $mock->matches('bla')->willReturn(true)->shouldNotBeCalled();

        $node = new AnyOrZeroWords($mock->reveal());

        $this->assertTrue($node->matches('bla.blo'));
    }
}
