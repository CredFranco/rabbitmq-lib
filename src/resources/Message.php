<?php

namespace RabbitLib\resources;

trait Message
{
    public function publish($data, array $application_headers = ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT], string $publish_queue = ''):void
    {
        $msg = new AMQPMessage($data, $application_headers);
        $this->channel->basic_publish($msg, '', $publish_queue == '' ? $this->queue : $publish_queue);
    }

    public function consume(string $jobClass, string $queue = '')
    {
        $callback = function (AMQPMessage $msg) use ($jobClass, $queue) {
            try{

                $this->msg = $msg;

                $arr = json_decode($msg->getBody(), true);
                
                $job = new $jobClass($arr);

                dispatch($job)->onQueue($queue);

                $msg->ack();

            }catch (\Exception $e) {
                $this->error($e->getMessage());
            }
        };
        try{
            $this->channel->basic_consume($this->queue, '', false, false, false, false, $callback);
        }catch(\Exception $e){
            $this->reconnect();
        }


        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function retryMessage(AMQPMessage $msg, $retryCount):void
    {
        $msgBody = $msg->getBody();
        if (!$this->connection->isConnected()) {
            $this->reconnect();
        }
        $this->publish($msgBody, [
            'delivery_mode' => 2, // Mensagem persistente
            'application_headers' => ['x-retry-count' => ['I', $retryCount]],
        ]);

        $this->msg->nack(false, false);
    }

    public function getRetryCount(AMQPMessage $msg)
    {
        if ($msg->has('application_headers')) {
            $headers = $msg->get('application_headers')->getNativeData();
            return isset($headers['x-retry-count']) ? (int)$headers['x-retry-count'] : 0;
        }

        return 0;
    }
}