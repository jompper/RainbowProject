<?php
class MainController extends Controller {
	public function actionIndex(){
		$user = getUser();
		$this->setDataPair('user', $user);
		$this->setDataPair('tasks', $user->getTasks());
		$this->render('index');
	}
}
