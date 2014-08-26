<?php

namespace Aztech\Events;

use Aztech\Events\Subscriber;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Aztech\Events\Category\Subscription;

class EventDispatcher implements Dispatcher, LoggerAwareInterface
{

    const FMT_DBG_REG_SUBSCRIBER = 'Registered new subscriber of class "%s" with filter pattern "%s".';

    const FMT_DBG_DISPATCHING = '[ "%s" ] Dispatching to subscriber "%s".';

    const FMT_DBG_DISPATCHED = '[ "%s" ] Dispatched to subscriber "%s".';

    const FMT_DBG_NO_MATCH = '[ "%s" ] No match for filter value "%s".';

    const FMT_DBG_REJECTED = '[ "%s" ] Validated topic match, but event was rejected by subscriber "%s".';

    const FMT_INF_DISPATCHING = '[ "%s" ] Starting event dispatch to %d potential subscribers.';

    const FMT_INF_DISPATCHED = '[ "%s" ] Event dispatched to %d subscribers.';

    const FMT_ERR_DISPATCH = '[ "%s" ] Event dispatch error (%s).';

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

        $message = sprintf(self::FMT_DBG_REG_SUBSCRIBER, get_class($subscriber), $category);
        $this->logger->debug($message);
    }

    /**
     * Dispatches an event based on its category.
     * @param Event $event
     */
    public function dispatch(Event $event)
    {
        $message = sprintf(self::FMT_INF_DISPATCHING, $event->getId(), count($this->subscriptions));
        $this->logger->info($message);

        $dispatchCount = 0;

        foreach ($this->subscriptions as $subscription) {
            $result = $this->tryDispatch($subscription, $event);
            $dispatchCount += (int)$result;
        }

        $message = sprintf(self::FMT_INF_DISPATCHED, $event->getId(), $dispatchCount);
        $this->logger->info($message);
    }

    /**
     * Attempts to dispatch an event
     * @param Subscription $subscription
     * @param \Aztech\Events\Event $event
     * @return boolean True if dispatch was successful, false otherwise
     */
    private function tryDispatch(Subscription $subscription, Event $event)
    {
        $dispatched = false;

        try {
            $dispatched = $this->doDispatch($subscription, $event);
        } catch (\Exception $ex) {
            $message = sprintf(self::FMT_ERR_DISPATCH, $event->getId(), $ex->getMessage());

            $this->logger->error($message, array(
                'event-category' => $event->getCategory(),
                'subscription-filter' => $subscription->getCategoryFilter(),
                'subscriber_class' => get_class($subscription->getSubscriber()),
                'message' => $ex->getMessage(),
                'trace' => $ex->getTraceAsString()
            ));
        }

        return $dispatched;
    }


    private function doDispatch(Subscription $subscription, Event $event)
    {
        $hasMatch = $subscription->matches($event->getCategory());
        $subscriber = $subscription->getSubscriber();

        if (! $hasMatch) {
            return $this->logFailedDispatch($subscription, $event, false);
        }

        return $this->doLoggedDispatch($subscriber, $event);
    }

    private function doLoggedDispatch(Subscriber $subscriber, Event $event)
    {
        if (! $subscriber->supports($event)) {
            return $this->logFailedDispatch($subscription, $event, true);
        }

        $message = sprintf(self::FMT_DBG_DISPATCHING, $event->getId(), get_class($subscriber));
        $this->logger->debug($message);

        $subscriber->handle($event);

        $message = sprintf(self::FMT_DBG_DISPATCHED, $event->getId(), get_class($subscriber));
        $this->logger->debug($message);

        return true;
    }

    private function logFailedDispatch(Subscription $subscription, Event $event, $hasMatch)
    {
        if (! $hasMatch) {
            $message = sprintf(self::FMT_DBG_NO_MATCH, $event->getId(), $subscription->getCategoryFilter());
        } else {
            $message = sprintf(self::FMT_DBG_REJECTED, $event->getId(), get_class($subscription->getSubscriber()));
        }

        $this->logger->debug($message);

        return false;
    }
}
