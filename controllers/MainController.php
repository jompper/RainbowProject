<?php
class MainController {
	public function actionIndex(){
		$user = getUser();
		$tasks = $user->getTasks();
		render('index', array('user' => $user, 'tasks' => $tasks));
	}
}
