<?php

namespace Aztech\Events\Category;

use Aztech\Events\Util\Pattern\PatternMatcher;
use Aztech\Events\Subscriber;

class Subscription
{

    /**
     *
     * @var string
     */
    private $categoryFilter;

    /**
     *
     * @var \Aztech\Events\Subscriber
     */
    private $subscriber;

    /**
     *
     * @var \Aztech\Events\Util\Pattern\Pattern
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
     * @return \Aztech\Events\Subscriber
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
     * @return boolean
     */
    public function matches($category)
    {
        return $this->matcher->matches($category);
    }
}
