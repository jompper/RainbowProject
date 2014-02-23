<?php
class ProjectsController extends Controller {
	
	public function actionIndex(){
		$this->setDataPair("projects", Project::getProjects());
		$this->render('projects');
	}
	
	public function actionShow(){
		$project = Project::getProject($_GET['id']);
		if($project===false){
			notice("Projektia ei löytynyt");
			redirect("projects");
		}
		$this->setDataPair("project", $project);
		$this->setDataPair("tasks", $project->getTasks());
		$this->setDataPair("comments", $project->getComments());
		$this->render("project");
	}
	
	public function actionEdit(){
		$project = Project::getProject($_GET['id']);
		if($project===false){
			notice("Projektia ei löytynyt");
			redirect("projects");
		}
		$this->renderForm(true, $project);
	}

	public function actionUpdate(){
		$project = Project::getProject($_GET['id']);
		if($project===false){
			notice("Projektia ei löytynyt");
			redirect("projects");
		}
		$project->setName($_POST['nimi']);
		$project->setDescription($_POST['kuvaus']);
		$project->setDueDate($_POST['maara_aika']);
		$project->setPriority($_POST['prioriteetti']);
		$project->setStatus($_POST['tila']);
		if($project->save()){
			notice("Muutokset suoritettiin onnistuneesti");
			redirect("projects");
		}
		$this->renderForm(true,$project);
	}
	
	public function actionNew(){
		$project = new Project();
		if(isset($_GET['id'])){
			$project->setCustomer($_GET['id']);
		}
		$this->renderForm(false, $project);
	}
	
	public function actionCreate(){
		$project = new Project();
		$project->setName($_POST['nimi']);
		$project->setDescription($_POST['kuvaus']);
		$project->setDueDate($_POST['maara_aika']);
		$project->setCustomer($_POST['asiakas']);
		$project->setPriority($_POST['prioriteetti']);
		$project->setStatus($_POST['tila']);
		if($project->save()){
			notice("Projekti luotiin onnistuneesti");
			redirect("projects");
		}
		$this->renderForm(false, $project);
	}
	
	public function actionDelete(){
		$project = Project::getProject($_GET['id']);
		if($project!==null){
			if(count($project->getTasks())){
				errorNotice("Projektiin liityy tehtäviä, poisto ei mahdollinen");
			}else{
				$project->delete();
				notice("Projekti poistettiin onnistuneesti");
			}
		}
		redirect("projects");
	}
	
	public function actionComment(){
		$projectComment = new ProjectComment;
		$projectComment->setComment($_POST['kommentti']);
		$projectComment->setProject($_GET['id']);
		$projectComment->setUser($_SESSION['user']);
		$projectComment->save();
		redirectBack();
	}
	
	private function renderForm($edit, $project){
		$this->setDataPair("edit", $edit);
		$this->setDataPair("project", $project);
		$this->setDataPair("errors", $project->getErrors());
		$this->setDataPair("customers", Customer::getCustomers());
		$this->setDataPair("priorities", Priority::getPriorities());
		$this->setDataPair("statuses", Status::getStatuses());
		$this->render('projectform');
	}
}
