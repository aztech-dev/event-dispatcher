<?php

namespace Aztech\Events\Tests\Util;

use Psr\Log\LogLevel;
use Aztech\Events\Util\EventLogger;

class EventLoggerTest extends \PHPUnit_Framework_TestCase
{

    public function testLoggerForwardsToSubLogggerWithExtraInfo()
    {
        $logger = $this->getMock('\Psr\Log\LoggerInterface');
        
        $level = \Psr\Log\LogLevel::WARNING;
        $message = 'This is a test';
        
        $logger->expects($this->once())
            ->method('log')
            ->willReturnCallback(function ($passedLevel, $passedMessage, array $context) use($level, $message)
        {
            $this->assertEquals($level, $passedLevel);
            $this->assertGreaterThan(strlen($message), strlen($passedMessage));
            $this->assertContains($message, $passedMessage);
        });
            
        $testLogger = new EventLogger($logger, $this->getMock('\Aztech\Events\Event'));

        $testLogger->log($level, $message);
    }
}