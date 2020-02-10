<?php

namespace Apollo\Core;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

abstract class ExtensionBase implements EventSubscriberInterface
{
    private array $info;

    public array $events;

    public function __construct()
    {
        $this->info = array(
            'title'       => 'Apollo ExtensionBase',
            'name'        => 'apollo_extension',
            'uuid'        => 'NaN',
            'description' => 'A basic plugin',
            'author'      => 'Apollo Cafe',
            'version'     => '1.0',
            'apollo'      => '*'
        );
    }

}