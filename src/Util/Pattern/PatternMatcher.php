<?php

namespace Aztech\Events\Util\Pattern;

/**
 * Pseudo Trie tree implementation. It differs from a Trie tree in that it only holds one possible pattern (thus one branch), and uses RabbitMQ's loop node concept.
 * Matching a category to a pattern is performed by walking the category components (separated by dots) and evaluating each component against its counterpart in the pattern component chain.
 * If a pattern component is <strong>*</strong>, the category counterpart evaluates to true.
 * If a pattern component is <strong>#</strong>, it acts as though zero or more '<strong>*</strong>' components are present in the pattern at that point.
 * @link http://www.rabbitmq.com/blog/2010/09/14/very-fast-and-scalable-topic-routing-part-1/
 * @link http://www.rabbitmq.com/blog/2011/03/28/very-fast-and-scalable-topic-routing-part-2/
 * @see \Aztech\Events\Tests\Category\MatchTruthTable
 * @author thibaud
 */
class PatternMatcher implements Pattern
{

    private $pattern = null;

    private $next = null;

    /**
     *
     * @param string $pattern The filter pattern to evaluate.
     * @see \Aztech\Events\Tests\Category\MatchTruthTable
     */
    public function __construct($pattern)
    {
        $parsed = $this->parse($pattern);

        $this->pattern = $parsed[0];
        $this->next = $parsed[1];
    }

    /**
     * @param string $pattern
     */
    private function parse($pattern)
    {
        $parts = explode('.', $pattern, 2);

        $first = PatternFactory::getPatternFor($this, $parts[0]);
        $next = isset($parts[1]) ? new self($parts[1]) : new IsNullOrEmpty();

        return array($first, $next);
    }

    /**
     * (non-PHPdoc)
     * @see \Aztech\Events\Util\Pattern\Pattern::matches()
     */
    public function matches($component)
    {
        $parts = explode('.', $component, 2);

        $key = $parts[0];
        $value = isset($parts[1]) ? $parts[1] : null;

        return $this->doesKeyOrValueMatch($key, $value);
    }

    private function doesKeyOrValueMatch($key, $value)
    {
        if (! $this->pattern->matches($key)) {
            return false;
        }

        return $this->doesValueMatch($value);
    }

    private function doesValueMatch($value)
    {
        if ($this->next->matches($value)) {
            return true;
        }

        return $this->evaluateLookback($value);
    }

    private function evaluateLookback($value)
    {
        if ($this->pattern instanceof AnyOrZeroWords && $value) {
            return $this->matches($value);
        }

        return false;
    }
}
