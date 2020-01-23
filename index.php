<?php

define('FEBRUARY', 1);
require_once './system/config.php';

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

//use Apollo\Core\ErrorHandler;
//use Apollo\Core\Hooks;

use Apollo\Processors\Comic;

$path = explode("/", $_GET['path']);

// TODO: Functional error handler
$db        = new Database(DB_CREDENTIALS);
$apollo    = new Apollo();
$templates = new Templates($db);
$router    = new Router();
//$handler   = new ErrorHandler();

$apollo->router = &$router;
$apollo->theme  = 1;
// TODO: Add hooks and modules
//$modules   = new Hooks();

/*
$modules = array();
foreach (glob(CTRL_DIR.'modules/*.php') as $filename) {
    $file = CTRL_DIR.'modules/'.$filename.'.php';
    require_once $file;
    $modules->list[$filename] = new $filename(ass this deosns mak sense);
}*/

$resourceTypes = array('comic');

$apolloInfo = array(
    'theme'   => &$apollo->theme,
    'version' => &$apollo->version
);

// TODO: Implement advanced routing
$pageData = array('apollo' => $apolloInfo);
if (empty($path[0])) {
    $path[0] = 'index';
}

if ((count($path) === 2) && (($path[0] === 'comic') || ($path[0] === 'page'))) {
    $comic      = new Comic($db);
    $returnData = $comic->fetch($path[1], $path[0]);
    if (empty($returnData)) {
        header("Location: /404");
    } else {
        $template          = 'comic';
        $pageData['comic'] = $returnData;
    }
} else {
    $data = $db->query(
        'SELECT * FROM `pages` WHERE `slug` = ?',
        $_GET['path']
    )->fetchArray();
    if (empty($data)) {
        header("Location: /404");
    } else {
        $template         = $data['template'];
        $pageData['page'] = $data;
    }
}
// TODO: Implement template errors
$templates->render($template, $pageData);
