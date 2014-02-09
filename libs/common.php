<?php
	/* Näyttää näkymätiedoston ja lähettää sille muuttujat */
	function render($page, $data = array(), $template = null) {
		$data = (object)$data;
		if($template===null)require 'views/template.php';
		else if($template !== false) require $template;
		else require VIEW_PATH . $page . ".php";
		exit;
	}
  
	function getDB(){
		static $dbh = null;
		
		if($dbh === null){
			$dbh = new PDO('pgsql:');
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$dbh->query("SET NAMES 'UTF8'");
		}

		return $dbh;
	}

	function notice($notice){
		$_SESSION['notice'] = $notice;
	}

	function redirect($controller="", $action = "", $get=""){
		header("Location: " . URL . "{$controller}/{$action}/{$get}");
		exit;
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
		header("Location: " . URL . "error");
	}
	
	function getPost($field, $default = null){
		return (isset($_POST[$field])?$_POST[$field]:$default);
	}
	
	function getGet($field, $default = null){
		return (isset($_GET[$field])?$_GET[$field]:$default);
	}
	
	function __autoload($class){
		if(file_exists(MODEL_PATH . $class . "Model.php"))require MODEL_PATH . $class . "Model.php";
		else throw new Exception("Unable to load {$class}.");
	}
	
	
