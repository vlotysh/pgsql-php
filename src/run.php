<?php

require_once 'cli.php';

$currentProcess = getmypid();
$data = shell_exec("ps faux | grep 'src/run.php'");
var_dump($currentProcess);
foreach (explode(PHP_EOL,$data) as $processLine ) {
    var_dump($processLine);
    list ($user,$processId) = explode(' ', preg_replace('/\s+/', ' ', $processLine));
    if ((int) $processId !== $currentProcess) {
       @shell_exec(sprintf('kill -9 %s' ,$processId));
    }
}


$path = __DIR__ . '/../config/routes.yaml';
$loader = new \RabbitMQApp\ConfigLoader();
$routes = $loader->loadConfig($path);

$processor = new \RabbitMQApp\QueueProcessor();
$processor->runQueue($routes);