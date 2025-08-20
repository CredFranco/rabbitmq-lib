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
    protected int $port = 5672;
    protected string $user = '';
    protected string $password = '';
    protected string $vhost = '/';

    public function __construct()
    {
        $this->host = config('services.rabbitlib.host','');
        $this->port = config('services.rabbitlib.port',5672);
        $this->user = config('services.rabbitlib.user','');
        $this->password = config('services.rabbitlib.password','');

        $this->connect();
    }

    public function setQueue(string $queue): self
    {
        $this->queue = $queue;
        $this->queue($queue);
        return $this;
    }    
}