<?php
class Template {
	private $template;
	
	private $title;
	private $description;

	private $css;
	private $js;

	public function __construct(){
		$this->template = DEFAULT_TEMPLATE;
		$this->title = DEFAULT_TITLE;
		$this->description = "";
		$this->css = array();
		$this->js = array();
	}

	public function render($view, $data){
        $data = (object)$data;
        require_once TEMPLATE_PATH . $this->template . ".php";
    }

	public function setTemplate($template){
		$this->template = $template;
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function setDescription($description){
		$this->description = $description;
	}

	public function addCSS($cssFile){
		$this->css[]= $cssFile;
	}

	public function addJS($jsFile){
		$this->js[] = $jsFile;
	}
}
