<?php

namespace Aztech\Events\Util\Pattern;

/**
 *
 * This pattern matches any expression, whether it is empty, or composed of multiple expressions.
 * When evaluating an expression, if it is a single word expression, then the match always evaluates to true.
 * If it is composed of multiple words, then the expression will be stripped of its word and passed back to parent node for evaluation.
 * @author thibaud
 *
 */
class AnyOrZeroWords implements Pattern
{

    private $loopNode;

    /**
     *
     * @param Pattern $loopNode Node to which evaluation will be deferred when necessary.
     */
    public function __construct(Pattern $loopNode)
    {
        $this->loopNode = $loopNode;
    }

    /**
     * (non-PHPdoc)
     * @see \Aztech\Events\Util\Pattern\Pattern::matches()
     */
    function matches($expression)
    {
        $parts = explode('.', $expression);

        // Defer evaluation of next expression to loop node.
        if (isset($parts[1])) {
            return ($this->loopNode->matches($parts[1]));
        }

        // Next expression is empty, hence it matches.
        return true;
    }
}
