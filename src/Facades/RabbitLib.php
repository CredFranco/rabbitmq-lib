<?php

    namespace RabbitLib\Facades;

    use Illuminate\Support\Facades\Facade;

    class RabbitLib extends Facade
    {
        protected static function getFacadeAccessor()
        {
            return \RabbitLib\RabbitRepository::class;
        }
    }
