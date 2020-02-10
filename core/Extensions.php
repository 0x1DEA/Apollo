<?php

namespace Apollo\Core;

use Symfony\Component\EventDispatcher\EventDispatcher;

class Extensions
{

    public function load(EventDispatcher $eventHandler)
    {
        $files = array_diff(scandir(SYS_DIR.'/extensions'), array('.', '..'));
        foreach ($files as $file) {
            $class = '\\Apollo\\Extensions\\'.basename($file, '.php');
            $eventHandler->addSubscriber(new $class());
        }
    }
}