<?php

namespace RabbitLib\resources;

use PhpAmqpLib\Message\AMQPMessage;
trait Queue
{
    public function queue(string $queue_declare,string $dead_letter_exchange = '', array $defineExchange = []):self
    {
        $this->channel->queue_declare($queue_declare, false, true, false, false, false, $defineExchange);
        return $this;
    }

    public function moveToDeadLetterQueue(AMQPMessage $msg)
    {
        $msgBody = $msg->getBody();

        $this->publish($msgBody, [
            'delivery_mode' => 2, // Mensagem persistente
            'application_headers' => ['x-retry-count' => ['I', 0]],
        ], $this->letter_route_key);
    }
}