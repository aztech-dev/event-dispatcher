<?php

namespace Aztech\Events\Tests\Util\PatternMatcher;

use Aztech\Events\Util\Pattern\AnyOrZeroWords;
class AnyOrZeroWordsTest extends \PHPUnit_Framework_TestCase
{
    
    function testEmptyWordsAreConsideredMatches()
    {
        $node = new AnyOrZeroWords($this->getMock('\Aztech\Events\Util\Pattern\Pattern'));
        
        $this->assertTrue($node->matches(''));
    }
    
    function testOneWordComponentsAreConsideredMatches()
    {
        $node = new AnyOrZeroWords($this->getMock('\Aztech\Events\Util\Pattern\Pattern'));
        
        $this->assertTrue($node->matches('bla'));
    }
    
    function testMultiWordComponentsAreDispatchedToLoopbackNode()
    {
        $mock = $this->getMock('\Aztech\Events\Util\Pattern\Pattern');
        $node = new AnyOrZeroWords($mock);
        
        $mock->expects($this->atLeastOnce())
            ->method('matches')
            ->willReturn(true);
        
        $this->assertTrue($node->matches('bla.bla'));
    }
    
}