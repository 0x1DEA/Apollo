<?php

use Apollo\Core\Apollo;
use Apollo\Core\Database;
use Apollo\Core\ErrorHandler;
use Apollo\Core\Extensions;
use Apollo\Core\Router;
use Apollo\Core\Templates;
use Symfony\Component\EventDispatcher\EventDispatcher;

require_once './../config.php';

require_once(SYS_DIR.'/vendor/autoload.php');

$apollo       = new Apollo();
$db           = new Database(DB_CREDENTIALS);
$templates    = new Templates($db);
$errorHandler = new ErrorHandler($db);
$router       = new Router($apollo);
$eventHandler = new EventDispatcher();
$extensions   = new Extensions();

$apollo->db      = &$db;
$apollo->handler = &$errorHandler;

$extensions->load($eventHandler);

$router->register();

$router->dispatch();