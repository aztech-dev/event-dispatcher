<?php

namespace Aztech\Events\Category;

use Aztech\Events\Subscriber;
use Aztech\Events\Util\Pattern\Pattern;
use Aztech\Events\Util\Pattern\PatternMatcher;

class Subscription
{

    /**
     *
     * @var string
     */
    private $categoryFilter;

    /**
     *
     * @var Subscriber
     */
    private $subscriber;

    /**
     *
     * @var Pattern
     */
    private $matcher;

    /**
     *
     * @param string $categoryFilter
     * @param Subscriber $subscriber
     */
    public function __construct($categoryFilter, Subscriber $subscriber = null)
    {
        $this->categoryFilter = $categoryFilter;
        $this->subscriber = $subscriber;
        $this->matcher = new PatternMatcher($this->categoryFilter);
    }

    /**
     *
     * @return Subscriber
     */
    public function getSubscriber()
    {
        return $this->subscriber;
    }

    /**
     *
     * @return string
     */
    public function getCategoryFilter()
    {
        return $this->categoryFilter;
    }

    /**
     * @param string $category
     * @return bool
     */
    public function matches($category)
    {
        return $this->matcher->matches($category);
    }
}
