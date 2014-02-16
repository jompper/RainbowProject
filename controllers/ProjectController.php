<?php
class ProjectController {
	
	public function actionIndex(){
			$projects = Project::getProjects();
			render('projects', array("projects" => $projects));
	}
	
	public function actionShow(){
			$project = Project::getProject($_GET['id']);
			if($project===false){
				notice("Projektia ei löytynyt");
				redirect("project");
			}
			$tasks = $project->getTasks();
			render("project",array("project" => $project, "tasks" => $tasks));
	}
	
	public function actionEdit(){
			$project = Project::getProject($_GET['id']);
			if($project===false){
				notice("Projektia ei löytynyt");
				redirect("project");
			}
			if(!empty($_POST)){
				$project->setName($_POST['nimi']);
				$project->setDescription($_POST['kuvaus']);
				$project->setDueDate($_POST['maara_aika']);
				$project->setPriority($_POST['prioriteetti']);
				$project->setStatus($_POST['tila']);
				if($project->save()){
					notice("Muutokset suoritettiin onnistuneesti");
					redirect("project");
				}
			}
			$this->renderForm(true,$project);
	}
	
	public function actionCreate(){
			$project = new Project();
			if(!empty($_POST)){
				$project->setName($_POST['nimi']);
				$project->setDescription($_POST['kuvaus']);
				$project->setDueDate($_POST['maara_aika']);
				$project->setCustomer($_POST['asiakas']);
				$project->setPriority($_POST['prioriteetti']);
				$project->setStatus($_POST['tila']);
				if($project->save()){
					notice("Projekti luotiin onnistuneesti");
					redirect("project");
				}
			}
			$this->renderForm(false, $project);
	}
	
	public function actionDelete(){
		$project = Project::getProject($_GET['id']);
		if($project!==null){
			$project->delete();
			notice("Projekti poistettiin onnistuneesti");
		}
		redirect("project");
	}
	
	private function renderForm($edit, $project){
		render('projectform', array("edit" => $edit, 
									 "project" => $project, 
									 "errors" => $project->getErrors(),
									 "customers" => Customer::getCustomers(),
									 "priorities" => Priority::getPriorities(),
									 "statuses" => Status::getStatuses()
									 )
			  );
	}
}
