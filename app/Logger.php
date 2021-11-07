<?php


namespace RabbitMQApp;

use RabbitMQApp\Message\MessageInterface;

class Logger
{
    /**
     * @param string $message
     * @param string $type
     */
    public function log(string $message, string $type = '-')
    {
        $file = fopen(ROOT_PATH . 'tmp/log.txt', 'a+');

        $txt = sprintf("%s: %s\n", $type, $message);
        fwrite($file, $txt);
        fclose($file);
    }
}