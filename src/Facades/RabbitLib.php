<?php

    namespace RabbitLib\Facades;

    use Illuminate\Support\Facades\Facade;

    

    class RabbitLib extends Facade
    {
        public static string $host = '';
        public static string $port = '';
        public static string $user = '';
        public static string $password = '';
        public static string $vhost = '/';
        public static string $queue = '';

        public static function __callStatic($method, $parameters)
        {
            return app(\RabbitLib\RabbitRepository::class)
                ->setQueue(static::$queue)
                ->$method(...$parameters);
        }
    }
