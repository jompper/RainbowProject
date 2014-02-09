<?php

define('DB_DSN', 'pgsql:');
define('DB_USERNAME', null);
define('DB_PASSWORD', null);


define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', dirname(__FILE__));
define('URL', dirname($_SERVER['PHP_SELF']) . "/");

define('CONTROLLER_PATH', ROOT_PATH . DS . 'controllers' . DS);
define('MODEL_PATH', ROOT_PATH . DS . 'libs/models' . DS);
define('VIEW_PATH', ROOT_PATH . DS . 'views' . DS);

define('DEFAULT_CONTROLLER', 'main');
define('DEFAULT_ACTION', 'index');

require 'libs/common.php';