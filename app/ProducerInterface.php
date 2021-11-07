<?php


namespace RabbitMQApp;

interface ProducerInterface
{
    /**
     * @param string $data
     */
    public function send(string $data): void;
}