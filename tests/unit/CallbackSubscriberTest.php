<?php

namespace Aztech\Events\Tests;

use Aztech\Events\Callback;

class CallbackTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    function testCallConstructorWithNonCallableThrowsException()
    {
        $callable = new \stdClass();

        $callback = new Callback($callable);
    }
    
    function testCallbackIsCallable()
    {
        $callback = new Callback(function() {});
        
        $this->assertTrue(is_callable($callback));
    }
    
    function testCallbackInvocation()
    {
        $count = 0;
        
        $callable = function () use (& $count)
        {
            $count++;
        };
        
        $callback = new Callback($callable);
        $callback($this->getMock('\Aztech\Events\Event'));
        
        $this->assertEquals(1, $count);
    }
    
    function testSupportReturnsTrue() 
    {
        $callback = new Callback(function() {});
        
        $this->assertTrue($callback->supports($this->getMock('\Aztech\Events\Event')));
    }
    
}