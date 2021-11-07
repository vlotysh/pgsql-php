<?php

require_once __DIR__ . '/../vendor/autoload.php';

use RabbitMQApp\MessageWorkerSender;


$data = implode(' ', array_slice($argv, 1));

if (empty($data)) {
    $data = 'info: Default message';
}

$sender = new \RabbitMQApp\LogWorkerSender();
$sender->send($data);