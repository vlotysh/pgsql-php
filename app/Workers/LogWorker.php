<?php

namespace RabbitMQApp\Workers;

use RabbitMQApp\Logger;
use RabbitMQApp\Message\MessageInterface;

/**
 * Class LogWorker
 * @package RabbitMQApp\Workers
 */
class LogWorker implements WorkerInterface
{
    public function work(MessageInterface $message): void
    {
        $logger = new Logger();
        $logger->log($message->getBody(), 'Log');
    }
}