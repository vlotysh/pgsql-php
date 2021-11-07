<?php

namespace RabbitMQApp\Workers;

use RabbitMQApp\Message\MessageInterface;

/**
 * Class WorkerInterface
 * @package RabbitMQApp\Workers
 */
interface WorkerInterface
{
    public function work(MessageInterface $message): void;
}