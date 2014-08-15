<?php

namespace Aztech\Events;

use Aztech\Events\Subscriber;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Aztech\Events\Category\Subscription;

class EventDispatcher implements Dispatcher, LoggerAwareInterface
{

    /**
     *
     * @var CategorySubscription[]
     */
    private $subscriptions = array();

    private $logger = null;

    public function __construct()
    {
        $this->logger = new NullLogger();
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \Aztech\Events\Dispatcher::addListener()
     */
    public function addListener($category, Subscriber $subscriber)
    {
        $this->subscriptions[] = new Subscription($category, $subscriber);
        $this->logger->debug('Registered new subcriber of class "' . get_class($subscriber) . '" using filter "' . $category . '".');
    }

    public function dispatch(Event $event)
    {
        $this->logger->info('[ "' . $event->getId() . '" ] Starting event dispatch to ' . count($this->subscriptions) . ' potential subscribers.');
        
        $category = $event->getCategory();
        $dispatchCount = 0;
        
        foreach ($this->subscriptions as $subscription) {
            $result = $this->tryDispatch($subscription, $event);
            $dispatchCount += (int)$result;
        }
        
        $this->logger->info('[ "' . $event->getId() . '" ] Dispatch to ' . $dispatchCount . ' subscribers done.');
    }

    /**
     *
     * @param Subscription $subscription
     * @param \Aztech\Events\Event $event
     * @return boolean True if dispatch was successful, false otherwise
     */
    private function tryDispatch(Subscription $subscription, Event $event)
    {
        $dispatched = false;
        
        try {
            $hasMatch = $subscription->matches($event->getCategory());
            
            if ($hasMatch && $subscription->getSubscriber()->supports($event)) {
                $this->logger->debug('[ "' . $event->getId() . '" ] Dispatched to ' . get_class($subscription->getSubscriber()));
                $subscription->getSubscriber()->handle($event);
                $dispatched = true;
            } elseif (! $hasMatch) {
                $this->logger->debug('[ "' . $event->getId() . '" ] No match for filter value "' . $subscription->getCategoryFilter() . '"');
            } else {
                $this->logger->debug('[ "' . $event->getId() . '" ] Validated match, but event was rejected by subscriber ' . get_class($subscription->getSubscriber()) . '.');
            }
        } catch (\Exception $ex) {
            $this->logger->error('[ "' . $event->getId() . '" ] Event dispatch error', array('subscription-filter' => $subscription->getCategoryFilter(),'subscriber_class' => get_class($subscription->getSubscriber()),'message' => $ex->getMessage(),'trace' => $ex->getTraceAsString()));
        }
        
        return $dispatched;
    }
}
