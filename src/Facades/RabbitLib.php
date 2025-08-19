<?php

    namespace RabbitLib\Facades;

    use Illuminate\Support\Facades\Facade;

    

    class RabbitLib extends Facade
    {
        public static string $queue = '';

        public static function __callStatic($method, $parameters)
        {
            return app(\RabbitLib\RabbitRepository::class)
                ->setQueue(static::$queue)
                ->$method(...$parameters);
        }
    }
