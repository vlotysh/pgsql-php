<?php

namespace RabbitMQApp;

use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class LogRoutingWorkerSender
 */
class LogRoutingWorkerSender extends BaseWorker implements ProducerInterface
{
    private string $severity;

    /**
     * LogRoutingWorkerSender constructor.
     * @param string $severity
     */
    public function __construct(string $severity)
    {
        $this->severity = $severity;

        parent::__construct();
    }

    public function send(string $data): void
    {
        $this->channel->exchange_declare(
            'direct_logs',    #queue - Queue names may be up to 255 bytes of UTF-8 characters
            'direct',  # exchange type
            false,
            false,
            false
        );

        $severity = empty($data) ?  'info' : $data;


        $msg = new AMQPMessage($data);

        $this->channel->basic_publish(
            $msg,
            'direct_logs',
            $this->severity
        );

        echo 'Sent!', "\n";
    }
}