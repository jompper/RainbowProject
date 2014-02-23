<?php
class ErrorsController extends Controller{
	public function actionIndex(){
		$this->render('404');
	}
}