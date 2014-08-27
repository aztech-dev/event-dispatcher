event-dispatcher
================

### Build status

[![Build Status](https://travis-ci.org/aztech-dev/event-dispatcher.svg?branch=master)](https://travis-ci.org/aztech-dev/event-dispatcher)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/aztech-dev/event-dispatcher/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/aztech-dev/event-dispatcher/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/aztech-dev/event-dispatcher/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/aztech-dev/event-dispatcher/?branch=master)
[![HHVM Status](http://hhvm.h4cc.de/badge/aztech/event-dispatcher.png)](http://hhvm.h4cc.de/package/aztech/event-dispatcher)

### Stability

[![Latest Stable Version](https://poser.pugx.org/aztech/event-dispatcher/v/stable.png)](https://packagist.org/packages/aztech/event-dispatcher)
[![Latest Unstable Version](https://poser.pugx.org/aztech/event-dispatcher/v/unstable.png)](https://packagist.org/packages/aztech/event-dispatcher)

## Installation

### Via Composer

Composer is the only supported way of installing *aztech/event-dispatcher* . Don't know Composer yet ? [Read more about it](https://getcomposer.org/doc/00-intro.md).

`$ composer require "aztech/event-dispatcher":"~1"`

## Autoloading

Add the following code to your bootstrap file :

```
require_once 'vendor/autoload.php';
```

## Usage

As the name implies, *event-dispatcher* is a simple event dispatching library. Rather than a long speech, a simple example :

```php
class MyEvent implements \Aztech\Events\Event
{
    function getCategory() {
        return 'my.event';
    }
    
    function getId() {
        return 1;
    }
}

$dispatcher = new \Aztech\Events\EventDispatcher();
$subscriber = new \Aztech\Events\Callback(function (\Aztech\Events\Event $event) {
    echo 'I just received an event : ' . $event->getCategory() . PHP_EOL;
});

$dispatcher->addListener('my.#', $subscriber);
$dispatcher->dispatch(new MyEvent());
```