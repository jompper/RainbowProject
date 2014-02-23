<?php
class UserTaskHoursController extends Controller {
	
	public function actionIndex(){
		$this->setDataPair("hours", UserTaskHour::getUserTaskHours());
		$this->render('list');
	}
	
	public function actionNew(){
		$hour = new UserTaskHour;
		if(isset($_GET['id'])){
			$hour->setTask($_GET['id']);
		}
		$hour->setUser($_SESSION['user']);
		$this->renderForm($hour);
	}
	
	public function actionCreate(){
		$hour = new UserTaskHour();
		$hour->setDescription($_POST['kuvaus']);
		$hour->setStartTime($_POST['aloitusaika']);
		$hour->setEndTime($_POST['lopetusaika']);
		$hour->setTask($_POST['tehtava']);
		$hour->setUser($_POST['kayttaja']);
		if($hour->save()){
			notice("Tuntimerkintä luotiin onnistuneesti");
			redirect("tasks",$hour->getTask()->getId());
		}
		$this->renderForm($hour);
	}
	
	public function actionDelete(){
		$hour = UserTaskHour::getUserTaskHour($_GET['id']);
		if($hour!==null){
			$hour->delete();
			notice("Tuntimerkintä poistettiin onnistuneesti");
		}
		redirectBack();
	}
	
	private function renderForm($hour){
		$this->setDataPair("hour", $hour);
		$this->setDataPair("tasks", Task::getTasks());
		$this->setDataPair("users", User::getUsers());
		$this->setDataPair("errors", $hour->getErrors());
		$this->render('form');
	}
}
