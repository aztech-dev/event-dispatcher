<?php

namespace Aztech\Events\Util\Pattern;

/**
 * Static helper class to build the appropriate pattern for a given word.
 * @author thibaud
 *
 */
class PatternFactory
{

    /**
     * Builds a pattern node based on a given word and its parent.
     *
     * @param Pattern $parent The parent pattern object, in case a loop node will be built.
     * @param string $word A single word from a composite pattern.
     * @return \Aztech\Events\Util\Pattern\Pattern A pattern object.
     */
    public static function getPatternFor(Pattern $parent, $word)
    {
        if (self::isWildcard($word)) {
            return self::getWildcardPattern($parent, $word);
        }

        return new Word($word);
    }

    private static function isWildcard($word)
    {
        return ($word == '*' || $word == '#');
    }

    private static function getWildcardPattern(Pattern $parent, $word)
    {
        if ($word == '#') {
            return new AnyOrZeroWords($parent);
        }

        return new AnyWord();
    }
}
