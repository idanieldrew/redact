<?php


require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('redact_rabbit','5672','guest','guest');
$channel = $connection->channel();

$channel->queue_declare('x', false, false, false, false);

$msg = new AMQPMessage('hello world');
$channel->basic_publish($msg,'','x');

echo 'send it';

$channel->close();
$connection->close();


