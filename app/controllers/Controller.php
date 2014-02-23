<?php
class Controller {
	
	private $viewPath;
	private $data = array();

	private $template;

	public function __construct(){
		$this->viewPath = VIEW_PATH . strtolower(substr(get_class($this),0,-10)) . DS;
		$this->data = array();
		$this->template = new Template();
	}

	protected function render($view){
		$view = $view . '.php';
		$this->template->render($this->viewPath . $view, $this->data);
	}

	protected function renderPartial($view){
		$data = (object)$this->data;
		require_once $this->viewPath . $view . ".php";	
	}

	protected function addData(Array $data){
		foreach($data as $key=>$value){
			$this->setDataPair($key, $value);
		}
	}

	protected function setTemplate($template){
		$this->template->setTemplate($template);
	}
	
	protected function setDataPair($key, $value){
		$this->data[$key] = $value;
	}

	protected function setViewPath($path){
		$this->viewPath = VIEW_PATH . substr(realpath($path),1);
	}

}
