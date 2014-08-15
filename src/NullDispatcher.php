<?php

namespace Aztech\Events;

class NullDispatcher implements Dispatcher
{

    public function addListener($category, Subscriber $subscriber)
    {
        // Do nothing
    }

    public function dispatch(\Aztech\Events\Event $event)
    {
        // Do nothing
    }
}
