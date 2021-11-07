<?php

namespace RabbitMQApp;

use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class LogWorkerReceiver
 * @package RabbitMQApp
 */
class LogWorkerConsumer extends BaseWorker implements ConsumerInterface
{
    /**
     * @throws \ErrorException
     */
    public function listen(): void
    {
        $this->channel->exchange_declare(
            'logs',
            'fanout',
            false,
            false,
            false
        );

        //create tmp queue
        list($queue_name, ,) = $this->channel->queue_declare(
            "",
            false,
            false,
            true,
            false
        );
        //bind exchange to queue
        $this->channel->queue_bind($queue_name, 'logs');

        $this->channel->basic_consume(
            $queue_name,        #queue
            '',                     #consumer tag - Identifier for the consumer, valid within the current channel. just string
            false,                  #no local - TRUE: the server will not send messages to the connection that published them
            true,                  #no ack, false - acks turned on, true - off.  send a proper acknowledgment from the worker, once we're done with a task
            false,                  #exclusive - queues may only be accessed by the current connection
            false,                  #no wait - TRUE: the server will not respond to the method. The client should not wait for a reply method
            array($this, 'process') #callback
        );

        while (count($this->channel->callbacks)) {
            echo '[-] Waiting for incoming messages', "\n";
            $this->channel->wait();
        }
    }

    /**
     * process received request
     *
     * @param AMQPMessage $msg
     */
    public function process(AMQPMessage $msg)
    {
        echo ' [x] ', $msg->body, "\n";
    }
}