<?php

define ('DEFAULT_TITLE', 'Rainbow Project');

define('DB_DSN', 'pgsql:');
define('DB_USERNAME', null);
define('DB_PASSWORD', null);

define('DS', DIRECTORY_SEPARATOR);
define('APP_PATH', ROOT_PATH . DS . 'app' . DS);
define('URL', dirname($_SERVER['PHP_SELF']) . "/");

define('CONTROLLER_PATH', APP_PATH . 'controllers' . DS);
define('MODEL_PATH', APP_PATH . 'models' . DS);
define('VIEW_PATH', APP_PATH . 'views' . DS);

define('TEMPLATE_PATH', APP_PATH . 'templates' . DS);

define('LIB_PATH', APP_PATH . 'libs' . DS);

define('DEFAULT_CONTROLLER', 'main');
define('DEFAULT_ACTION', 'index');
define('DEFAULT_TEMPLATE', 'default');

require LIB_PATH . 'common.php';
require LIB_PATH . 'Template.php';
require CONTROLLER_PATH . 'Controller.php';

