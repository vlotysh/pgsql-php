<?php
#./command.sh execute php public/receive_route_log.php info warning error
require_once __DIR__ . '/../vendor/autoload.php';

use RabbitMQApp\MessageWorkerConsumer;

$severities = array_slice($argv, 1);
if (empty($severities)) {
    file_put_contents('php://stderr', "Usage: $argv[0] [info] [warning] [error]\n");
    exit(1);
}


$reciver = new \RabbitMQApp\LogRoutingWorkerConsumer(implode(' ' , $severities));
$reciver->listen();
