<?php

namespace Aztech\Events;

use Aztech\Events\Event;
use Aztech\Events\Subscriber;

/**
 * Subscriber that acts as an adapter to invoke callbacks.
 * @author thibaud
 *
 */
class Callback implements Subscriber
{

    private $callback;

    public function __construct($callable)
    {
        if (! is_callable($callable)) {
            throw new \InvalidArgumentException('Not a callback.');
        }

        $this->callback = $callable;
    }
    
    public function __invoke(Event $event)
    {
        return $this->handle($event);
    }

    public function supports(Event $event)
    {
        return true;
    }

    public function handle(Event $event)
    {
        $callback = $this->callback;

        $callback($event);
    }
}
