<?php

namespace Aztech\Events;

class NullDispatcher implements Dispatcher
{

    public function addListener($category, Subscriber $subscriber)
    {
        // Do nothing
    }

    public function dispatch(Event $event)
    {
        // Do nothing
    }
}
