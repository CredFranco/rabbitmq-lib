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

    protected string $queue = '';
    protected string $host = '';
    protected string $port = '';
    protected string $user = '';
    protected string $password = '';
    protected string $vhost = '/';

    public function __construct()
    {
        $this->connect();
    }

    public function setQueue(string $queue): self
    {
        $this->queue = $queue;
        $this->queue();
        return $this;
    }

    public function setHost(string $host): self
    {
        $this->host = $host;
        return $this;
    }

    public function setPort(string $port): self
    {
        $this->port = $port;
        return $this;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
    
    
}