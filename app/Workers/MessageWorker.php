<?php

namespace RabbitMQApp\Workers;

use RabbitMQApp\Logger;
use RabbitMQApp\Message\MessageInterface;

class MessageWorker implements WorkerInterface
{
    public function work(MessageInterface $message): void
    {
        $logger = new Logger();
        $logger->log($message->getBody(), 'Message');
    }
}