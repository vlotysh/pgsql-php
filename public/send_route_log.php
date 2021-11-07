<?php
#./command.sh execute php public/send_route_log.php error "Critical error!"
require_once __DIR__ . '/../vendor/autoload.php';

use RabbitMQApp\MessageWorkerSender;


$severity = isset($argv[1]) && !empty($argv[1]) ? $argv[1] : 'info';

$data = implode(' ', array_slice($argv, 2));
if (empty($data)) {
    $data = "Hello World!";
}

$sender = new \RabbitMQApp\LogRoutingWorkerSender($severity);
$sender->send($data);