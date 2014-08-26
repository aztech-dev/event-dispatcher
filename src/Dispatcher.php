<?php

namespace Aztech\Events;

interface Dispatcher
{

    /**
     * Binds a subscriber to a given category filter. Any event that is dispatched will be passed
     * to the subscriber's handle method provided that the subscriber indicates that it supports the
     * event and that the category filter matches the event's category.
     * @param string $category
     * @param Subscriber $subscriber
     * @return void
     */
    public function addListener($category, Subscriber $subscriber);

    /**
     * @param Event $event
     * @return void
     */
    public function dispatch(Event $event);
}
