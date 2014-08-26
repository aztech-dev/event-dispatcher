<?php

namespace Aztech\Events\Category;

use Aztech\Events\Util\Pattern\PatternMatcher;

class Matcher
{

    public function checkMatch($pattern, $category)
    {
        $trie = new PatternMatcher($pattern);

        return $trie->matches($category);
    }
}
