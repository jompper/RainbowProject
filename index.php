<?php
session_start();
require 'config.php';
$controller = (isset($_GET['controller'])?$_GET['controller']:DEFAULT_CONTROLLER);
$action 	= (isset($_GET['action'])?$_GET['action']:DEFAULT_ACTION);

//echo "<!--{$controller}/{$action}-->";

if(!isset($_SESSION['user']))app("login");
else app($controller, $action);

function app($controller, $action = DEFAULT_ACTION){
	$controller = toCamelCase(toSafePath($controller)) . "Controller";
	$action 	= "action" . toCamelCase(toSafePath($action));
	if(!file_exists(CONTROLLER_PATH . $controller . ".php"))notFound();
	require CONTROLLER_PATH . $controller . ".php";
	$app = new $controller();
	if(!method_exists($app, $action))notFound();
	$app->$action();
}