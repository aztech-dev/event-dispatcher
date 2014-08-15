<?php

namespace Aztech\Events\Tests\Util\Trie;

use Aztech\Events\Util\TrieMatcher\AnyOrZeroWords;
class AnyOrZeroWordsTest extends \PHPUnit_Framework_TestCase
{
    
    function testEmptyWordsAreConsideredMatches()
    {
        $node = new AnyOrZeroWords($this->getMock('\Aztech\Events\Util\TrieMatcher\TrieMatcher'));
        
        $this->assertTrue($node->matches(''));
    }
    
    function testOneWordComponentsAreConsideredMatches()
    {
        $node = new AnyOrZeroWords($this->getMock('\Aztech\Events\Util\TrieMatcher\TrieMatcher'));
        
        $this->assertTrue($node->matches('bla'));
    }
    
    function testMultiWordComponentsAreDispatchedToLoopbackNode()
    {
        $mock = $this->getMock('\Aztech\Events\Util\TrieMatcher\TrieMatcher');
        $node = new AnyOrZeroWords($mock);
        
        $mock->expects($this->atLeastOnce())
            ->method('matches')
            ->willReturn(true);
        
        $this->assertTrue($node->matches('bla.bla'));
    }
    
}