<?php

namespace Aztech\Events\Tests\Category;

use Aztech\Events\Category\Matcher;

class MatcherTest extends \PHPUnit_Framework_TestCase
{

    public function getTruthTable()
    {
        return MatchTruthTable::get();
    }

    /**
     * @dataProvider getTruthTable
     */
    public function testMatcherResultsAreConformToTruthTable($category, $filter, $expected)
    {        
        $matcher = new Matcher();
        
        $this->assertEquals($expected, $matcher->checkMatch($filter, $category));
    }
}
