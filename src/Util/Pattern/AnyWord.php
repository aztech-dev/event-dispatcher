<?php

namespace Aztech\Events\Util\Pattern;

/**
 * This pattern matches any non-empty, single word expression.
 * @author thibaud
 *
 */
class AnyWord implements Pattern
{
    /**
     * (non-PHPdoc)
     * @see \Aztech\Events\Util\Pattern\Pattern::matches()
     */
    function matches($expression)
    {
        return $expression != '';
    }
}
