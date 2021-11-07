<?php

namespace RabbitMQApp\Message;

class MQMessage implements MessageInterface
{
    private string $body;

    /**
     * MQMessage constructor.
     * @param string $body
     */
    public function __construct(string $body)
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }
}
