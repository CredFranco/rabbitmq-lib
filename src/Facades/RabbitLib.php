<?php

    namespace RabbitLib\Facades;


    class RabbitLib
    {
        protected static string $collection;

        public static function __callStatic($method, $parameters)
        {
            return app(\RabbitLib\RabbitRepository::class)
                ->setCollection(static::$collection)
                ->$method(...$parameters);
        }
    }
