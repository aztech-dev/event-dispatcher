<?php

namespace Aztech\Events\Tests\Issues;

use Aztech\Events\Category\Subscription;
use Aztech\Events\EventDispatcher;
use Prophecy\Argument;

class Issue006Test extends \PHPUnit_Framework_TestCase
{

    public function testWildcardMatcher()
    {
        $pattern = '#';
        $subscriber = $this->prophesize('Aztech\Events\Subscriber');

        $event = $this->prophesize('Aztech\Events\Event');
        $event->getId()->willReturn('id');
        $event->getCategory()->willReturn('auth.login');

        $event = $event->reveal();

        $subscriber->supports(Argument::exact($event))->willReturn(true)->shouldBeCalled();
        $subscriber->handle(Argument::exact($event))->shouldBeCalled();

        $dispatcher = new EventDispatcher();
        $dispatcher->addListener($pattern, $subscriber->reveal());

        $dispatcher->dispatch($event);
    }
}