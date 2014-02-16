<?php
class Project {

	private $id;
	private $customer_id;
	private $priority_id;
	private $status_id;
	private $due_date;
	private $name;
	private $description;
	
	private $timestamp_due_date;
	
	private $customer;
	private $priority;
	private $status;

	private $tasks;
	
	private $errors;

	public function __construct(){
		$this->errors = array();
	}
	
	public function getId(){
		return $this->id;
	}

	public function getDueDate($format = "d.m.Y"){
		if($this->due_date === null)return"";
		if($this->timestamp_due_date===null){
			$this->timestamp_due_date = strtotime($this->due_date);
		}
		return date($format, $this->timestamp_due_date);
	}
	
	public function getName(){
		return $this->name;
	}

	public function getDescription(){
		return $this->description;
	}
	
	public function getBusinessId(){
		return $this->business_id;
	}

	public function getCustomerId(){
		return $this->customer_id;
	}
	
	public function getPriorityId(){
		return $this->priority_id;
	}
	
	public function getStatusId(){
		return $this->status_id;
	}
	
	public function getCustomer(){
		if($this->customer===null){
			$this->customer = Customer::getCustomer($this->customer_id);
		}
		return $this->customer;
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
	
	public function getTasks(){
		if($this->id===null)return array();
		if($this->tasks === null){
			$this->tasks = Task::getProjectTasks($this->id);
		}
		return $this->tasks;
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
		$this->validateCustomerProjectNameUniqueness();
	}
	
	public function setDescription($description){	
		$this->description = htmlspecialchars($description);
	}
		
	public function setCustomer($customerId){
		if($this->customer_id == $customerId)return;
		$this->customer_id = $customerId;
		if($this->getCustomer()===false){
			$this->errors['customer'] = "Asiakas on virheellinen";
		}else{
			unset($this->errors['customer']);
		}
		$this->validateCustomerProjectNameUniqueness();
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
	
	private function validateCustomerProjectNameUniqueness(){
		if($this->name===null || $this->customer_id === null){
			$this->errors['customer_project'] = "Projektilla tulee olla nimi ja asiakas";
		}else if($this->existsCustomerProjectName()){
			$this->errors['customer_project'] = "Asiakkaalla on jo saman niminen projekti";
		}else {
			unset($this->errors['customer_project']);
		}
	}
	
	private function existsCustomerProjectName(){
		$sql = "SELECT 1 FROM projects WHERE customer_id = :customer_id AND name ILIKE :name";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':customer_id', $this->customer_id);
		$stmt->bindParam(':name', $this->name);
		$stmt->execute();
		return $stmt->fetchColumn()===1;
	}
	
	
	public function validate(){
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
		$sql = "INSERT INTO projects (customer_id, priority_id, status_id, due_date, name, description) 
		VALUES (:customer_id, :priority_id, :status_id, :due_date, :name, :description) RETURNING id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':customer_id', $this->customer_id);
		$stmt->bindParam(':priority_id', $this->priority_id);
		$stmt->bindParam(':status_id', $this->status_id);
		$stmt->bindParam(':due_date', $this->due_date);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':description', $this->description);
		if($stmt->execute()){
			$this->id = $stmt->fetchColumn();
			return true;
		}
		return false;
	}

	private function update(){
		$sql = "UPDATE projects SET customer_id = :customer_id, priority_id = :priority_id, status_id = :status_id, due_date = :due_date, name = :name, description = :description WHERE id = :id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':id', $this->id);
		$stmt->bindParam(':customer_id', $this->customer_id);
		$stmt->bindParam(':priority_id', $this->priority_id);
		$stmt->bindParam(':status_id', $this->status_id);
		$stmt->bindParam(':due_date', $this->due_date);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':description', $this->description);
		return $stmt->execute();
	}

	public function delete(){
		if($this->id===null)return;
		$sql = "DELETE FROM projects WHERE id = :id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':id', $this->id);
		$stmt->execute();
		$this->id = null;
	}
	
	public static function getProject($projectId){
		$stmt = getDB()->prepare("SELECT * FROM projects WHERE id = :id;");
		$stmt->bindParam(':id', $projectId);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__); 
		$stmt->execute();
		return $stmt->fetch();
	}
	
	public static function getProjects(){
		$sql = "SELECT * FROM projects ORDER BY name ASC";
		$stmt = getDB()->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
	}
	
	public static function getCustomerProjects($customerId){
		$sql = "SELECT * FROM projects WHERE customer_id = :customer_id ORDER BY name ASC";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(":customer_id", $customerId);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
	}
}
