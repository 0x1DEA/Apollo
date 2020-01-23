<?php
defined('FEBRUARY') or header("Location: /404");
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'apollo');
define('DB_CREDENTIALS', array(DB_HOST, DB_USER, DB_PASS, DB_NAME));
define('SYS_DIR', __DIR__);