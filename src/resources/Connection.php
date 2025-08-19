<?php

namespace RabbitLib\resources;

use PhpAmqpLib\Connection\AMQPStreamConnection;

trait Connection
{
    public function connect():void
    {
        if($this->host == ''){
            throw new \Exception('Host é obrigatório. Você precisa configurar o host no arquivo .env e coloca-lo no serviço de configuração do Laravel');
        }

        if($this->port == ''){
            throw new \Exception('Port é obrigatório. Você precisa configurar a porta no arquivo .env e coloca-lo no serviço de configuração do Laravel');
        }
        
        if($this->user == ''){
            throw new \Exception('User é obrigatório. Você precisa configurar o usuário no arquivo .env e coloca-lo no serviço de configuração do Laravel');
        }

        if($this->password == ''){
            throw new \Exception('Password é obrigatório. Você precisa configurar a senha no arquivo .env e coloca-lo no serviço de configuração do Laravel');
        }

        if($this->vhost == ''){
            throw new \Exception('Vhost é obrigatório. Você precisa configurar o vhost no arquivo .env e coloca-lo no serviço de configuração do Laravel');
        }

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