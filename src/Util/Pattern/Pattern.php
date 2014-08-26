<?php

namespace Aztech\Events\Util\Pattern;

interface Pattern
{
    /**
     *
     * @param string $word Word or composite word to evaluate against pattern.
     * @return bool True if the component matches the predefined pattern.
     */
    function matches($word);
}
