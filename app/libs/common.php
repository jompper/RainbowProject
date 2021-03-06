﻿<?php
	/* Näyttää näkymätiedoston ja lähettää sille muuttujat */
	function render($page, $data = array(), $template = null) {
		$data = (object)$data;
		if($template===null)require TEMPLATE_PATH . DEFAULT_TEMPLATE . '.php';
		else if($template !== false) require TEMPLATE_PATH . $template . '.php';
		else require VIEW_PATH . $page . ".php";
		exit;
	}
  
	function getDB(){
		static $dbh = null;
		
		if($dbh === null){
			$dbh = new PDO(DB_DSN,DB_USERNAME,DB_PASSWORD);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$dbh->query("SET NAMES 'UTF8'");
		}

		return $dbh;
	}

	function notice($notice){
		$_SESSION['notice'] = $notice;
	}
	
	function errorNotice($error){
		$_SESSION['error'] = $error;
	}

	function redirect($controller="", $action = "", $get=""){
		header("Location: " . URL . "{$controller}/{$action}/{$get}");
		exit;
	}
	
	function redirectBack(){
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function getUser(){
		static $user = null;
		if($user === null && isset($_SESSION['user'])){
			$user = User::getUser($_SESSION['user']);
		}
		return $user;
	}
	
  
	function toSafePath($path){
		return preg_replace("/(-{2,})/","-",preg_replace("/[^a-z-]/","-",strtolower(trim($path))));
	}

	function toCamelCase($string){
		$return = "";
		foreach(explode('-',strtolower($string)) as $word){
			$return .= ucfirst(trim($word));
		}
		return $return;
	}
	
	function notFound(){
		header("Location: " . URL . "errors");
		exit;
	}
	
	function getPost($field, $default = null){
		return (isset($_POST[$field])?$_POST[$field]:$default);
	}
	
	function getGet($field, $default = null){
		return (isset($_GET[$field])?$_GET[$field]:$default);
	}
	
	function __autoload($class){
		if(substr($class,-6)=="Helper"){
			$classPath = LIB_PATH . $class . ".php";		
		}else{
			$classPath = MODEL_PATH . $class . "Model.php";
		}
		if(file_exists($classPath)){
			require $classPath;
		}else{
			throw new Exception("Unable to load {$class}.");
		}
	}
	
	
