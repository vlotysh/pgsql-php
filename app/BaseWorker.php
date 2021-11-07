<?php


namespace RabbitMQApp;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use RabbitMQApp\config\AMPQConnectionConfig;

/**
 * Class BaseAMQP
 * @package App
 */
abstract class BaseWorker
{
    /**
     * @var AMQPStreamConnection
     */
    protected AMQPStreamConnection $connection;

    /**
     * @var AMQPChannel
     */
    protected AMQPChannel $channel;

    /**
     * WorkerSender constructor.
     */
    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            AMPQConnectionConfig::HOST,
            AMPQConnectionConfig::POST,
            AMPQConnectionConfig::USERNAME,
            AMPQConnectionConfig::PASSWORD,
        );
        $this->channel = $this->connection->channel();
    }

    /**
     * @throws \Exception
     */
    public function __destruct()
    {
        $this->connection->close();
        $this->channel->close();
    }
}