<?php


namespace RabbitMQApp;


/**
 * Class QueueProcessor
 * @package RabbitMQApp
 */
class QueueProcessor
{
    /**
     * @param array $queuesConfig
     */
    public function runQueue(array $queuesConfig)
    {
        $path = __DIR__ .'/../src/listen.php';
        foreach ($queuesConfig as $item) {
           echo shell_exec(sprintf("php %s %s '%s' &", $path, $item['name'], $item['class']));
        }
    }
}