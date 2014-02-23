<?php
class UserTasksController extends Controller {

	public function actionNew(){
		$this->renderForm(null, $_GET['id']);
	}
	
	public function actionCreate(){
		if(UserTask::create($_POST['kayttaja'], $_POST['tehtava'])){
			redirect("tasks", $_POST['tehtava']);
		}else{
			$this->setDataPair("error", "Käyttäjä on jo allokoitu kyseiseen tehtävään"); 
			$this->renderForm($_POST['kayttaja'], $_POST['tehtava']);
		}
	}

	private function renderForm($userId, $taskId){
		$this->setDataPair("taskId", $taskId);
		$this->setDataPair("userId", $userId);
		$this->setDataPair("tasks", Task::getTasks());
		$this->setDataPair("users", User::getUsers());
		$this->render("form");
	}
		
	public function actionDelete(){
		$task = UserTask::delete($_GET['userId'], $_GET['taskId']);
		if($task!==false){
			notice("Käyttäjä poistettiin tehtävästä onnistuneesti");
		}
		redirectBack();
	}
}
