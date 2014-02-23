<?php
class TasksController extends Controller {
	
	public function actionIndex(){
		$this->setDataPair("tasks", Task::getTasks());
		$this->render('tasks');
	}
	
	public function actionShow(){
		$task = Task::getTask($_GET['id']);
		if($task===false){
			notice("Tehtävää ei löytynyt");
			redirect("tasks");
		}
		$this->setDataPair("task", $task);
		$this->setDataPair("comments", $task->getComments());
		$this->setDataPair("users", User::getTaskUsers($task->getId()));
		$this->setDataPair("hours", UserTaskHour::getTaskHours($task->getId()));
		$this->render("task");
	}
	
	public function actionEdit(){
		$task = Task::getTask($_GET['id']);
		if($project===false){
			notice("Tehtävää ei löytynyt");
			redirect("tasks");
		}
		$this->renderForm(true, $task);
	}

	public function actionUpdate(){
		$task = Task::getTask($_GET['id']);
		if($task===false){
			notice("Tehtävää ei löytynyt");
			redirect("tasks");
		}
		$task->setName($_POST['nimi']);
		$task->setDescription($_POST['kuvaus']);
		$task->setDueDate($_POST['maara_aika']);
		$task->setHourEstimate($_POST['tuntiarvio']);
		$task->setPriority($_POST['prioriteetti']);
		$task->setStatus($_POST['tila']);
		if($task->save()){
			notice("Muutokset suoritettiin onnistuneesti");
			redirect("tasks");
		}
		$this->renderForm(true,$task);
	}
	
	public function actionNew(){
		$task = new Task();
		if(isset($_GET['id'])){
			$task->setProject($_GET['id']);
		}
		$this->renderForm(false, $task);
	}
	
	public function actionCreate(){
		$task = new Task();
		$task->setName($_POST['nimi']);
		$task->setDescription($_POST['kuvaus']);
		$task->setDueDate($_POST['maara_aika']);
		$task->setHourEstimate($_POST['tuntiarvio']);
		$task->setProject($_POST['projekti']);
		$task->setPriority($_POST['prioriteetti']);
		$task->setStatus($_POST['tila']);
		if($task->save()){
			notice("Tehtävä luotiin onnistuneesti");
			redirect("projects",$task->getProjectId());
		}
		$this->renderForm(false, $task);
	}
	
	public function actionDelete(){
		$task = Task::getTask($_GET['id']);
		if($task!==null){
			$task->delete();
			notice("Tehtävä poistettiin onnistuneesti");
		}
		redirectBack();
	}
	
	public function actionComment(){
		$taskComment = new TaskComment;
		$taskComment->setComment($_POST['kommentti']);
		$taskComment->setTask($_GET['id']);
		$taskComment->setUser($_SESSION['user']);
		$taskComment->save();
		redirectBack();
	}
	
	private function renderForm($edit, $task){
		$this->setDataPair("edit", $edit);
		$this->setDataPair("task", $task);
		$this->setDataPair("errors", $task->getErrors());
		$this->setDataPair("projects", Project::getProjects());
		$this->setDataPair("priorities", Priority::getPriorities());
		$this->setDataPair("statuses", Status::getStatuses());
		$this->render('taskform');
	}
}
