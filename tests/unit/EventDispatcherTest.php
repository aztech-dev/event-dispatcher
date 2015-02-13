<?php

namespace Aztech\Events\Tests;

use Aztech\Events\EventDispatcher;
use Aztech\Events\Callback;

class EventDispatcherTest extends \PHPUnit_Framework_TestCase
{

    public function testDispatchInvokesRegisteredListeners()
    {
        $event = $this->getMock('\Aztech\Events\Event');
        $subscriber = $this->getMock('\Aztech\Events\Subscriber');
        $dispatcher = new EventDispatcher();
        $dispatcher->setLogger($this->getMock('\Psr\Log\LoggerInterface'));

        $subscriber->expects($this->any())
            ->method('supports')
            ->withAnyParameters()
            ->willReturn(true);
        $subscriber->expects($this->once())
            ->method('handle')
            ->with($event);

        $dispatcher->addListener('#', $subscriber);
        $dispatchCount = $dispatcher->dispatch($event);

        $this->assertEquals(1, $dispatchCount);
    }

    public function testDispatchExceptionsDoNotStopPropagation()
    {
        $event = $this->getMock('\Aztech\Events\Event');
        $subscriber = $this->getMock('\Aztech\Events\Subscriber');
        $exSubscriber = $this->getMock('\Aztech\Events\Subscriber');
        $dispatcher = new EventDispatcher();

        $exSubscriber->expects($this->any())
            ->method('supports')
            ->willReturn(true);
        $exSubscriber->expects($this->atLeastOnce())
            ->method('handle')
            ->willThrowException(new \RuntimeException());

        $subscriber->expects($this->any())
            ->method('supports')
            ->withAnyParameters()
            ->willReturn(true);
        $subscriber->expects($this->once())
            ->method('handle')
            ->with($event);

        $dispatcher->addListener('#', $exSubscriber);
        $dispatcher->addListener('#', $subscriber);

        $dispatchCount = $dispatcher->dispatch($event);

        $this->assertEquals(1, $dispatchCount);
    }

    public function testEventIsNotDispatchedToSubscribersRejectingIt()
    {
        $event = $this->getMock('\Aztech\Events\Event');
        $subscriber = $this->getMock('\Aztech\Events\Subscriber');
        $dispatcher = new EventDispatcher();

        $event->expects($this->any())
            ->method('getCategory')
            ->willReturn('different');

        $subscriber->expects($this->any())
            ->method('supports')
            ->withAnyParameters()
            ->willReturn(false);
        $subscriber->expects($this->never())
            ->method('handle')
            ->with($event);

        $dispatcher->addListener('different', $subscriber);
        $dispatchCount = $dispatcher->dispatch($event);

        $this->assertEquals(0, $dispatchCount);
    }


    public function testEventIsNotDispatchedIfCategoryDoesNotMatch()
    {
        $event = $this->getMock('\Aztech\Events\Event');
        $subscriber = $this->getMock('\Aztech\Events\Subscriber');
        $dispatcher = new EventDispatcher();

        $event->expects($this->any())
            ->method('getCategory')
            ->willReturn('different');

        $subscriber->expects($this->any())
            ->method('supports')
            ->withAnyParameters()
            ->willReturn(true);
        $subscriber->expects($this->never())
            ->method('handle')
            ->with($event);

        $dispatcher->addListener('category.#', $subscriber);
        $dispatchCount = $dispatcher->dispatch($event);

        $this->assertEquals(0, $dispatchCount);
    }

}
