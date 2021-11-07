<?php

namespace RabbitMQApp;

use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class LogWorkerSender
 */
class LogWorkerSender extends BaseWorker implements ProducerInterface
{
    public function send(string $data): void
    {
        $this->channel->exchange_declare(
            'logs',    #queue - Queue names may be up to 255 bytes of UTF-8 characters
            'fanout',  # exchange type
            false,
            false,
            false
        );

        $msg = new AMQPMessage($data);

        $this->channel->basic_publish(
            $msg,
            'logs'
        );

        echo 'Sent!', "\n";
    }
}