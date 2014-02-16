<?php
class Task {
	private $id;
	private $project_id;
	private $priority_id;
	private $status_id;
	private $due_date;
	private $hour_estimate;
	private $name;
	private $description;
	
	private $project;
	private $priority;
	private $status;
	
	private $errors;
	
	public function getId(){
		return $this->id;
	}
	
	public function getProjectId(){
		return $this->project_id;
	}
	
	public function getPriorityId(){
		return $this->priority_id;
	}
	
	public function getStatusId(){
		return $this->status_id;
	}
	
	public function getDueDate(){
		return $this->due_date;
	}
	
	public function getHourEstimate(){
		return $this->hour_estimate;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function getDescription(){
		return $this->description;
	}
	
	public static function getProjectTasks($projectId){
		$sql = "SELECT * FROM tasks WHERE project_id = :project_id ORDER BY name ASC";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(":project_id", $projectId);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
	}
	
	public static function getUserTasks($userId){
		$sql = "SELECT t.* FROM user_tasks ut JOIN tasks t ON ut.task_id = t.id WHERE ut.user_id = :user_id ORDER BY name ASC";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(":user_id", $userId);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
	}
	
	
}
