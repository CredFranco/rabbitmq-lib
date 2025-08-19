<?php

namespace RabbitLib;

use RabbitLib\resources\Connection;
use RabbitLib\resources\Exchange;
use RabbitLib\resources\Message;
use RabbitLib\resources\Queue;

class RabbitRepository
{
    use Connection, Exchange, Queue, Message;
    
    protected $connection;
    public $channel;
    protected float $connectionTimeout = 360.0;
    protected float $readTimeout = 360.0;
    private mixed $context = null;
    private bool $keepaLive = false;
    private mixed $credentials = null;
    private bool $insistent = false;
    private $msg;
    private int $retryLimit = 3;
    public string $letter_route_key = '';

    public string $host = '';
    public string $port = '';
    public string $user = '';
    public string $password = '';
    public string $vhost = '/';
    public string $queue = '';

    public function __construct()
    {
        $this->host = config('rabbitlib.host');
        $this->port = config('rabbitlib.port');
        $this->user = config('rabbitlib.user');
        $this->password = config('rabbitlib.password');
        $this->queue = config('rabbitlib.queue');

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

        if($this->queue == ''){
            throw new \Exception('Queue é obrigatório. Você precisa configurar a fila no arquivo .env e coloca-lo no serviço de configuração do Laravel');
        }


        $this->connect();
    }

    public function setQueue(string $queue): self
    {
        $this->queue = $queue;
        $this->queue();
        return $this;
    }
    
}