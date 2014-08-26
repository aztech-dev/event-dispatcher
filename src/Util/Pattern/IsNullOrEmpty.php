<?php

namespace Aztech\Events\Util\Pattern;

/**
 * This pattern matches any null or empty expression.
 * @author thibaud
 *
 */
class IsNullOrEmpty implements Pattern
{
    public function matches($string)
    {
        return ! $string;
    }
}
