<?php

namespace RabbitLib\resources;

use PhpAmqpLib\Connection\AMQPStreamConnection;

trait Connection
{
    public function connect():void
    {
        $this->connection = new AMQPStreamConnection($this->host, $this->port, $this->user, $this->password, $this->vhost,
        $this->insistent,
        'AMQPLAIN',
        $this->credentials,
        'en_US',
        $this->connectionTimeout,
        $this->readTimeout,
        $this->context,
        $this->keepaLive,
        60);
        $this->channel = $this->connection->channel();
    }

    public function reconnect()
    {
        // Fechar a conexão e o canal, caso estejam abertas
        if ($this->channel && $this->channel->is_open()) {
            $this->channel->close();
        }

        if ($this->connection && $this->connection->isConnected()) {
            $this->connection->close();
        }

        // Restabelecendo a conexão
        $this->connect();

    }

    public function close()
    {
        $this->channel->close();
        $this->connection->close();
    }
}