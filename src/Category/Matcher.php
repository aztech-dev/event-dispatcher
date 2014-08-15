<?php

namespace Aztech\Events\Category;

use Aztech\Events\Util\TrieMatcher\Trie;

class Matcher
{

    public function checkMatch($pattern, $category)
    {
        $trie = new Trie($pattern);

        return $trie->matches($category);
    }
}
