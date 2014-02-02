<?php
class ErrorController {
	public function actionIndex(){
		render('404',array(),false);
	}
}