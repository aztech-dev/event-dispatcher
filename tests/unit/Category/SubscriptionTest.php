<?php

namespace Aztech\Events\Tests\Category;

use Aztech\Events\Category\Subscription;

class CategorySubscriptionTest extends \PHPUnit_Framework_TestCase
{

    public function testParametersAreCorrectlyAssignedWithDefaultValues()
    {
        $categoryFilter = '*';
        $subscription = new Subscription($categoryFilter);

        $this->assertEquals($categoryFilter, $subscription->getCategoryFilter());
        $this->assertNull($subscription->getSubscriber());
    }

    public function testParametersAreCorrectlyAssigned()
    {
        $categoryFilter = '*';
        $subscriber = $this->getMock('\Aztech\Events\Subscriber');
        $subscription = new Subscription($categoryFilter, $subscriber);

        $this->assertEquals($categoryFilter, $subscription->getCategoryFilter());
        $this->assertSame($subscriber, $subscription->getSubscriber());
    }

    public function getTruthTable()
    {
        return MatchTruthTable::get();
    }

    /**
     *
     * @dataProvider getTruthTable
     */
    public function testCategoryAreCorrectlyMatched($category, $filter, $expected)
    {
        $subscriber = $this->getMock('\Aztech\Events\Subscriber');
        $subscription = new Subscription($filter, $subscriber);

        $this->assertEquals($expected, $subscription->matches($category));
    }
}
