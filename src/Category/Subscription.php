<?php

namespace Aztech\Events\Category;

use Aztech\Events\Util\TrieMatcher\Trie;
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
     * @var \Aztech\Events\Util\TrieMatcher\TrieMatcher
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
        $this->matcher = new Trie($this->categoryFilter);
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
     * @return \Aztech\Events\Event
     */
    public function matches($category)
    {
        return $this->matcher->matches($category);
    }
}
