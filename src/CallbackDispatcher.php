<?php

namespace Aztech\Events;

interface CallbackDispatcher extends Dispatcher
{

    /**
     * Binds a callback to a given category filter. Any event that is dispatched will be passed
     * to the subscriber's handle method provided that the subscriber indicates that it supports the
     * event and that the category filter matches the event's category.
     * @param string $category
     * @param callback $subscriber
     * @return void
     */
    public function addCallbackListener($category, callable $subscriber);
}
