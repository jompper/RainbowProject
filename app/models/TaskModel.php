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
	
	private $timestamp_due_date;
	
	private $project;
	private $priority;
	private $status;
	
	private $comments;
	
	private $errors;
	private $validate_uniqueness;
	
	public function __construct(){
		$this->errors = array();
		$this->validate_uniqueness = false;
	}
	
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
	
	public function getDueDate($format = "d.m.Y"){
		if($this->due_date === null)return"";
		if($this->timestamp_due_date===null){
			$this->timestamp_due_date = strtotime($this->due_date);
		}
		return date($format, $this->timestamp_due_date);
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
	
	public function getProject(){
		if($this->project===null){
			$this->project = Project::getProject($this->project_id);
		}
		return $this->project;
	}
	
	public function getPriority(){
		if($this->priority===null){
			$this->priority = Priority::getPriority($this->priority_id);
		}
		return $this->priority;
	}

	public function getStatus(){
		if($this->status===null){
			$this->status = Status::getStatus($this->status_id);
		}
		return $this->status;
	}
	
	public function getComments(){
		if($this->id===null)return array();
		if($this->comments === null){
			$this->comments = TaskComment::getTaskComments($this->id);
		}
		return $this->comments;
	}
	
	public function setDueDate($due_date){	
		$this->timestamp_due_date = strtotime($due_date);
		$this->due_date = date("Y-m-d", $this->timestamp_due_date);
		if(trim($this->due_date)==''){
			$this->errors['due_date']="Projektin määräaika on pakollinen";
		}else if(strtotime(date("Y-m-d"))>$this->timestamp_due_date){
			$this->errors['due_date']="Määräaika ei voi olla menneisyydessä";
		}else{
			unset($this->errors['due_date']);
		}
	}
	
	public function setHourEstimate($hourEstimate){
		$this->hour_estimate = (int)$hourEstimate;
		if($hourEstimate < 1){
			$this->errors['hour_estimate'] = "Pienin sallittu tuntiarvio on yksi tuntia";
		}else{
			unset($this->errors['hour_estimate']);
		}
	}
	
	public function setName($name){	
		if($this->name == $name)return;
		$this->name = htmlspecialchars($name);
		if(trim($this->name)==''){
			$this->errors['name']="Projektilla on oltava jokin nimi";
		}else if(strlen($this->name)>50){
			$this->errors['name'] = "Nimi on liian pitkä, maksimipituus 50 merkkiä";
		}else{
			unset($this->errors['name']);
		}
		$this->validate_uniqueness = true;
	}
	
	public function setDescription($description){	
		$this->description = htmlspecialchars($description);
	}
		
	public function setProject($projectId){
		if($this->project_id == $projectId)return;
		$this->project_id = $projectId;
		if($this->getProject()===false){
			$this->errors['project'] = "Projekti on virheellinen";
		}else{
			unset($this->errors['project']);
		}
		$this->validate_uniqueness = true;
	}
		
		
	public function setPriority($priorityId){
		$this->priority_id = $priorityId;
		if($this->getPriority()===false){
			$this->errors['priority'] = "Prioriteetti on virheellinen";
		}else{
			unset($this->errors['priority']);
		}
	}

	public function setStatus($statusId){
		$this->status_id = $statusId;
		if($this->getStatus()===false){
			$this->errors['status'] = "Projektin tila on virheellinen";
		}else{
			unset($this->errors['status']);
		}
	}
	
	private function validateProjectTaskNameUniqueness(){
		if($this->name===null || $this->project_id === null){
			$this->errors['customer_project'] = "Tehtävällä tulee olla projekti ja nimi";
		}else if($this->existsProjectTaskName()){
			$this->errors['customer_project'] = "Projektissa on jo saman niminen tehtävä";
		}else {
			unset($this->errors['customer_project']);
		}
	}
	
	private function existsProjectTaskName(){
		$sql = "SELECT 1 FROM tasks WHERE project_id = :project_id AND name ILIKE :name";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':project_id', $this->project_id);
		$stmt->bindParam(':name', $this->name);
		$stmt->execute();
		return $stmt->fetchColumn()===1;
	}
	
	public function validate(){
		if($this->validate_uniqueness)
			$this->validateProjectTaskNameUniqueness();
		return empty($this->errors);
	}

	public function getErrors(){
		return $this->errors;
	}
	
	public function save(){
		if(!$this->validate()){
			return false;
		}
		if($this->id === null){
			return $this->insert();
		}else{
			return $this->update();
		}
	}

	private function insert(){
		$sql = "INSERT INTO tasks (project_id, priority_id, status_id, due_date, hour_estimate, name, description) 
		VALUES (:project_id, :priority_id, :status_id, :due_date, :hour_estimate, :name, :description) RETURNING id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':project_id', $this->project_id);
		$stmt->bindParam(':priority_id', $this->priority_id);
		$stmt->bindParam(':status_id', $this->status_id);
		$stmt->bindParam(':due_date', $this->due_date);
		$stmt->bindParam(':hour_estimate', $this->hour_estimate);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':description', $this->description);
		if($stmt->execute()){
			$this->id = $stmt->fetchColumn();
			return true;
		}
		return false;
	}

	private function update(){
		$sql = "UPDATE tasks SET project_id = :project_id, priority_id = :priority_id, status_id = :status_id, due_date = :due_date, hour_estimate = :hour_estimate, name = :name, description = :description WHERE id = :id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':id', $this->id);
		$stmt->bindParam(':project_id', $this->project_id);
		$stmt->bindParam(':priority_id', $this->priority_id);
		$stmt->bindParam(':status_id', $this->status_id);
		$stmt->bindParam(':due_date', $this->due_date);
		$stmt->bindParam(':hour_estimate', $this->hour_estimate);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':description', $this->description);
		return $stmt->execute();
	}

	public function delete(){
		if($this->id===null)return;
		$sql = "DELETE FROM tasks WHERE id = :id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':id', $this->id);
		$stmt->execute();
		$this->id = null;
	}
	
	public static function getTask($taskId){
		$sql = "SELECT * FROM tasks WHERE id = :id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(":id", $taskId);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__); 
		$stmt->execute();
		return $stmt->fetch();
	}
	
	public static function getTasks(){
		$sql = "SELECT * FROM tasks";
		$stmt = getDB()->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
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
