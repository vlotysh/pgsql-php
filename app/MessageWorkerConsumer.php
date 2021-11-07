<?php

namespace RabbitMQApp;

use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class WorkerReceiver
 * @package App
 */
class MessageWorkerConsumer extends BaseWorker implements ConsumerInterface
{
    /**
     * @throws \ErrorException
     */
    public function listen(): void
    {
        $this->channel->queue_declare(
            'messages',    #queue - Queue names may be up to 255 bytes of UTF-8 characters
            false,              #passive - can use this to check whether an exchange exists without modifying the server state
            true,               #durable, make sure that RabbitMQ will never lose our queue if a crash occurs - the queue will survive a broker restart
            false,              #exclusive - used by only one connection and the queue will be deleted when that connection closes
            false               #auto delete - queue is deleted when last consumer unsubscribes
        );

        $this->channel->basic_qos(
            null,   #prefetch size - prefetch window size in octets, null meaning "no specific limit"
            1,      #prefetch count - prefetch window in terms of whole messages
            null    #global - global=null to mean that the QoS settings should apply per-consumer, global=true to mean that the QoS settings should apply per-channel
        );

        $this->channel->basic_consume(
            'messages',        #queue
            '',                     #consumer tag - Identifier for the consumer, valid within the current channel. just string
            false,                  #no local - TRUE: the server will not send messages to the connection that published them
            false,                  #no ack, false - acks turned on, true - off.  send a proper acknowledgment from the worker, once we're done with a task
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
        echo ' [x] Received ', $msg->body, "\n";
        sleep(substr_count($msg->body, '.'));
        echo " [x] Done\n";

        /**
         * If a consumer dies without sending an acknowledgement the AMQP broker
         * will redeliver it to another consumer or, if none are available at the
         * time, the broker will wait until at least one consumer is registered
         * for the same queue before attempting redelivery
         */
        $msg->ack();
    }
}