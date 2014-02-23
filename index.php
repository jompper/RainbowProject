<?php
session_start();
define('ROOT_PATH', dirname(__FILE__));
require 'app/config/config.php';
$controller = (isset($_GET['controller'])?$_GET['controller']:DEFAULT_CONTROLLER);
$action     = (isset($_GET['action'])?$_GET['action']:DEFAULT_ACTION);


if(!isset($_SESSION['user']))app("login");
else app($controller, $action);

function app($controller, $action = DEFAULT_ACTION){
	$controller = toCamelCase(toSafePath($controller)) . "Controller";
	$action 	= "action" . toCamelCase(toSafePath($action));
	
	$controllerFile = CONTROLLER_PATH . $controller . ".php";

	if(!file_exists($controllerFile)){
		notFound();
	}

	require $controllerFile;
	$app = new $controller();
	
	if(method_exists($app, 'filter')){
		$app->filter($action) || notFound();
	}
	if(!method_exists($app, $action)){
		notFound();
	}
	$app->$action();
}
