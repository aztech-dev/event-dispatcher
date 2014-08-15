<?php

namespace Aztech\Events;

interface Subscriber
{

    /**
     * @return void
     */
    public function handle(Event $event);

    /**
     * @return boolean
     */
    public function supports(Event $event);
}
