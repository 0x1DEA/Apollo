<?php

namespace Apollo\Core;

class Example
{
    public array $info;

    public function __construct()
    {
        $info = array(
            'name'        => 'Example',
            'safename'    => 'example',
            'description' => 'A base template for a Module',
            'author'      => 'Apollo',
            'version'     => '1.0',
            'apollo'      => '*'
        );
    }

    public function activate(Hooks $handler)
    {
        $handler->addHook(
            'load-modules',
            $this->info['safename'],
            function () {
                return true;
            }
        );
    }
}