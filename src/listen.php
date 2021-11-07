<?php

require_once 'cli.php';

$path = __DIR__ . '/../config/connection.yaml';
$loader = new \RabbitMQApp\ConfigLoader();
$connection = $loader->loadConfig($path);

list($cliName,$queueName,$class) = $argv;

$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection(
    $connection['RABBITMQ_HOST'],
    $connection['RABBITMQ_PORT'],
    $connection['RABBITMQ_USER'],
    $connection['RABBITMQ_PASSWORD'],
);
$channel = $connection->channel();

$channel->queue_declare(
    $queueName,    #queue - Queue names may be up to 255 bytes of UTF-8 characters
    false,              #passive - can use this to check whether an exchange exists without modifying the server state
    true,               #durable, make sure that RabbitMQ will never lose our queue if a crash occurs - the queue will survive a broker restart
    false,              #exclusive - used by only one connection and the queue will be deleted when that connection closes
    false               #auto delete - queue is deleted when last consumer unsubscribes
);

$channel->basic_qos(
    null,   #prefetch size - prefetch window size in octets, null meaning "no specific limit"
    1,      #prefetch count - prefetch window in terms of whole messages
    null    #global - global=null to mean that the QoS settings should apply per-consumer, global=true to mean that the QoS settings should apply per-channel
);

$channel->basic_consume(
    $queueName,        #queue
    '',                     #consumer tag - Identifier for the consumer, valid within the current channel. just string
    false,                  #no local - TRUE: the server will not send messages to the connection that published them
    false,                  #no ack, false - acks turned on, true - off.  send a proper acknowledgment from the worker, once we're done with a task
    false,                  #exclusive - queues may only be accessed by the current connection
    false,                  #no wait - TRUE: the server will not respond to the method. The client should not wait for a reply method
    function (\PhpAmqpLib\Message\AMQPMessage $msg) use ($class) {
        try {
            /**
             * @var $worker \RabbitMQApp\Workers\WorkerInterface
             */
            $worker = new $class;
            $worker->work(new \RabbitMQApp\Message\MQMessage($msg->body));
        } catch (\Throwable $e) {
            echo($e->getMessage());
            $msg->nack(true);
            exit();
        }

        $msg->ack();

    } #callback
);

echo 'Started for '.$queueName;

while (count($channel->callbacks)) {
    echo '[-] Waiting for incoming messages', "\n";
    $channel->wait();
}

$connection->close();
$channel->close();