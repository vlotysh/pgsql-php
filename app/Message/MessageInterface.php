<?php

namespace RabbitMQApp\Message;

/**
 * Interface MessageInterface
 * @package RabbitMQApp\Message
 */
interface MessageInterface
{
    public function getBody(): string;
}