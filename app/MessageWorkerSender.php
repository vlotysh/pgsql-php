<?php

namespace RabbitMQApp;

use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class WorkerSender
 */
class MessageWorkerSender extends BaseWorker implements ProducerInterface
{
    public function send(string $data): void
    {
        $this->channel->queue_declare(
            'messages',    #queue - Queue names may be up to 255 bytes of UTF-8 characters
            false,              #passive - can use this to check whether an exchange exists without modifying the server state
            true,               #durable, make sure that RabbitMQ will never lose our queue if a crash occurs - the queue will survive a broker restart
            false,              #exclusive - used by only one connection and the queue will be deleted when that connection closes
            false               #auto delete - queue is deleted when last consumer unsubscribes
        );

        $msg = new AMQPMessage(
            $data,
            array('delivery_mode' => 2)
        );

        $this->channel->basic_publish(
            $msg,               #message
            '',                 #exchange
            'messages'     #routing key (queue)
        );

        echo 'Sent!', "\n";
    }
}