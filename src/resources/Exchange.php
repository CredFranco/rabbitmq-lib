<?php

namespace RabbitLib\resources;

trait Exchange
{
    public function define_exchange(string $exchange):self
    {
        $this->channel->exchange_declare($exchange, 'direct', false, true, false);
        return $this;
    }
}