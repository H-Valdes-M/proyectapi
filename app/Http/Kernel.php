<?php

namespace App\Http;

class Kernel
{
    protected $middleware = [
        // ...
        \Fruitcake\Cors\HandleCors::class,
    ];
}