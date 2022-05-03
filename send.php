<?php
/**
* 发送消息
 */
$exchangeName = 'demo';
$routeKey = 'hello';
$message = 'Hello World!';
// 建立TCP连接
$connection = new AMQPConnection([
    'host' => 'localhost',
    'port' => '5672',
    'vhost' => '/',
    'login' => 'guest',
'password' => 'guest'
]);
$connection->connect() or die("Cannot connect to the broker!\n");
try {
    $channel = new AMQPChannel($connection);

    $exchange = new AMQPExchange($channel);
    $exchange->setName($exchangeName);
    $exchange->setType(AMQP_EX_TYPE_DIRECT);
    $exchange->declareExchange();

    echo 'Send Message: ' . $exchange->publish($message, $routeKey) . "\n";
    echo "Message Is Sent: " . $message . "\n";
} catch (AMQPConnectionException $e) {
    var_dump($e);
}
$connection->disconnect();// 断开连接