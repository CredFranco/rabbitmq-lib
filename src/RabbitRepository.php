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
        if($this->host == ''){
            throw new \Exception('Host é obrigatório');
        }

        if($this->port == ''){
            throw new \Exception('Port é obrigatório');
        }
        
        if($this->user == ''){
            throw new \Exception('User é obrigatório');
        }

        if($this->password == ''){
            throw new \Exception('Password é obrigatório');
        }

        if($this->vhost == ''){
            throw new \Exception('Vhost é obrigatório');
        }

        if($this->queue == ''){
            throw new \Exception('Queue é obrigatório');
        }


        $this->connect();
        $this->queue();
    }

    
}