<?php
/**
 * Apollo Webcomic Publisher 0.1.0
 * Copyright 2020 SeeBeyond
 *
 * Website: https://seebeyond.dev/apollo
 * license: MIT License
 */

namespace Apollo\Core;

class Apollo
{
    /**
     * Version
     *
     * @var string
     */
    public string $version = "0.1.0";
    /**
     * Configuration
     *
     * @var array
     */
    public array $config = array();
    /**
     * Site Settings
     *
     * @var array
     */
    public array $settings = array();
    /**
     * Asset URL
     *
     * @var string
     */
    public string $assetUrl;

    /**
     * @var Router
     */
    public Router $router;

    /**
     * @var string
     */
    public string $theme = '1';
    /**
     * @var ErrorHandler
     */
    public ErrorHandler $handler;
    /**
     * @var Database
     */
    public Database $db;

    public function __construct()
    {
    }
}