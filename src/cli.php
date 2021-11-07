<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

define('ROOT_PATH', __DIR__ . '/../');

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/../.env');