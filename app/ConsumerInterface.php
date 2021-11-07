<?php


namespace RabbitMQApp;

interface ConsumerInterface
{
    public function listen(): void;
}