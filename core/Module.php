<?php

namespace Apollo\Core;

class Module
{
    public array $modules;

    public function __construct()
    {
        $info = array(
            'name'        => '',
            'safename'    => '',
            'description' => '',
            'author'      => '',
            'version'     => '1.0',
            'apollo'      => '*'
        );
    }

    public function load(string $name)
    {
        $this->modules[$name] = new $name();
    }
}