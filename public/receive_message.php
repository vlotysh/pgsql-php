<?php

require_once __DIR__ . '/../vendor/autoload.php';

use RabbitMQApp\MessageWorkerConsumer;

$reciver = new MessageWorkerConsumer();
$reciver->listen();
