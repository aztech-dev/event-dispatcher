<?php

namespace Aztech\Events\Util\Pattern;

/**
 * This pattern matches exactly one word in a case sensitive comparison.
 * @author thibaud
 *
 */
class Word implements Pattern
{
    /**
     *
     * @var string
     */
    private $word;

    /**
     *
     * @param string $word The exact word to match.
     */
    public function __construct($word)
    {
        $this->word = $word;
    }

    /**
     * (non-PHPdoc)
     * @see \Aztech\Events\Util\Pattern\Pattern::matches()
     */
    function matches($expression)
    {
        return ($this->word == $expression);
    }
}
