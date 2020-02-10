<?php

namespace Apollo\Events;

use FastRoute\RouteCollector;
use Symfony\Contracts\EventDispatcher\Event;

class loadRoutes extends Event
{
    protected RouteCollector $r;

    public function __construct(RouteCollector $r)
    {
        $this->r = $r;
    }

    public function getRouter()
    {
        return $this->r;
    }
}