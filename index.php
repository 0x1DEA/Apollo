<?php

define('FEBRUARY', 1);

require_once './system/config.php';

require_once(SYS_DIR.'/vendor/autoload.php');

require_once './system/core/Apollo.php';
require_once './system/core/Database.php';
require_once './system/core/Templates.php';
require_once './system/core/Router.php';
require_once './system/core/ErrorHandler.php';
require_once './system/core/Hooks.php';

require_once './system/processors/Comic.php';

use Apollo\Core\Apollo;
use Apollo\Core\Database;
use Apollo\Core\Templates;
use Apollo\Core\Router;
use Apollo\Core\ErrorHandler;
use Apollo\Core\Hooks;

$path = explode("/", $_SERVER['REQUEST_URI']);

$apollo    = new Apollo();
$db        = new Database(DB_CREDENTIALS);
$templates = new Templates($db);
$handler   = new ErrorHandler();
$router    = new Router();
// TODO: Add hooks and modules
$modules = new Hooks();

$apollo->theme = 1;

$resourceTypes = array('comic');

// TODO: Implement advanced routing
$pageData = array(
    'apollo' => array(
        'theme'   => &$apollo->theme,
        'version' => &$apollo->version
    )
);

/*
 * Old Hardcoded Routing
if (empty($path[0])) {
    $path[0] = 'index';
}

if ((count($path) === 2) && (($path[0] === 'comic') || ($path[0] === 'page'))) {
    $comic      = new Comic($db);
    $returnData = $comic->fetch($path[1], $path[0]);
    if (empty($returnData)) {
        //header("Location: /404");
    } else {
        $template          = 'comic';
        $pageData['comic'] = $returnData;
    }
} else {
    $data = $db->query(
        'SELECT * FROM `pages` WHERE `slug` = ?',
        $_SERVER['REQUEST_URI'])->fetchArray();
    if (empty($data)) {
        //$handler->notFound();
    } else {
        $template         = $data['template'];
        $pageData['page'] = $data;
    }
}*/

$data = $db->query(
    'SELECT * FROM `pages` WHERE `slug` = ?',
    trim($_SERVER['REQUEST_URI'], '/')
)->fetchArray();
if (empty($data)) {
    $handler->notFound();
} else {
    $template         = $data['template'];
    $pageData['page'] = $data;
}

try {
    $templates->render($template, $pageData);
} catch (\Twig\Error\LoaderError $e) {
    $handler->error(ErrorHandler::TEMPLATE_LOADER);
} catch (\Twig\Error\RuntimeError $e) {
    $handler->error(ErrorHandler::TEMPLATE_RUNTIME);
} catch (\Twig\Error\SyntaxError $e) {
    $handler->error(ErrorHandler::TEMPLATE_SYNTAX);
} catch (TypeError $e) {
    // Type error is most likely a missing template from an unset $template
    $handler->error(ErrorHandler::TEMPLATE_MISSING);
}