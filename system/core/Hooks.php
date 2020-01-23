<?php

namespace Apollo\Core;

/**
 * Class Hooks
 *
 * @package Apollo\Core
 */
class Hooks
{
    private array $hooks;

    /**
     * @param  string  $hook
     * @param  string  $module
     * @param $callback
     */
    public function addHook(string $hook, string $module, $callback)
    {
        $this->hooks[$hook][$module]
            = $callback;
    }

    /**
     * @param  string  $hook
     */
    public function run(string $hook)
    {
        foreach ($this->hooks[$hook] as $callback) {
            $callback();
        }
    }
}