<?php

require_once __DIR__ . '/../vendor/autoload.php';

use RabbitMQApp\MessageWorkerSender;


$data = implode(' ', array_slice($argv, 1));

if (empty($data)) {
    $data = 'Text for sending';
}

$sender = new MessageWorkerSender();
$sender->send($data);