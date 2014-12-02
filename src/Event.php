<?php

namespace Aztech\Events;

/**
 * The methods here are actually more related to the event's enveloppe and should be moved out.
 */
interface Event
{

    /**
     * Returns the event ID.
     * @return string
     */
    public function getId();

    /**
     * Returns the category of the event.
     * @return string
     */
    public function getCategory();
}
