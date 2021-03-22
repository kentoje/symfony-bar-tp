<?php

namespace App\Services;

class HelloService {
    private string $message;

    public function __construct($args)
    {
        $this->message = $args['message'];
    }

    public function say(): string
    {
        return $this->message;
    }
}