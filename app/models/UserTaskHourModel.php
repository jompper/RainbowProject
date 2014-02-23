<?php
class UserTaskHour {
	private $id;
	private $user_id;
	private $task_id;
	private $start_time;
	private $end_time;
	private $description;
	
	private $timestamp_start_time;
	private $timestamp_end_time;
	
	private $user;
	private $task;
	
	private $errors;
	
	public function __construct(){
		$this->errors = array();
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getUserId(){
		return $this->user_id;
	}
	
	public function getTaskId(){
		return $this->task_id;
	}

	public function getStartTime($format = "d.m.Y H:i"){
		if($this->start_time === null)return"";
		if($this->timestamp_start_time===null){
			$this->timestamp_start_time = strtotime($this->start_time);
		}
		return date($format, $this->timestamp_start_time);
	}
	
	public function getEndTime($format = "d.m.Y H:i"){
		if($this->end_time === null)return"";
		if($this->timestamp_end_time===null){
			$this->timestamp_end_time = strtotime($this->end_time);
		}
		return date($format, $this->timestamp_end_time);
	}
	
	public function getDescription(){
		return $this->description;
	}
	
	public function getUser(){
		if($this->user===null){
			$this->user = User::getUser($this->user_id);
		}
		return $this->user;
	}
	
	public function getTask(){
		if($this->task===null){
			$this->task = Task::getTask($this->task_id);
		}
		return $this->task;
	}

	public function setStartTime($start_time){	
		$this->timestamp_start_time = strtotime($start_time);
		$this->start_time = date("Y-m-d H:i", $this->timestamp_start_time);
		if(trim($this->start_time)==''){
			$this->errors['start_time']="Aloitusaika on pakollinen";
		}else if(strtotime(date("Y-m-d", strtotime("+1 day")))<$this->timestamp_start_time){
			$this->errors['start_time']="Aloitusaika ei voi olla tulevaisuudessa";
		}else{
			unset($this->errors['start_time']);
		}
	}
	
	public function setEndTime($end_time){	
		$this->timestamp_end_time = strtotime($end_time);
		$this->end_time = date("Y-m-d H:i", $this->timestamp_end_time);
		if(trim($this->end_time)==''){
			$this->errors['end_time']="Lopetusaika on pakollinen";
		}else if($this->timestamp_end_time < $this->timestamp_start_time){
			$this->errors['end_time']="Lopetusajan on oltavan aloitusajan jälkeen";
		}else{
			unset($this->errors['end_time']);
		}
	}
	
	public function setDescription($description){	
		$this->description = htmlspecialchars($description);
	}
		
	public function setUser($userId){
		if($this->user_id == $userId)return;
		$this->user_id = $userId;
		if($this->getUser()===false){
			$this->errors['user'] = "Käyttäjä on virheellinen";
		}else{
			unset($this->errors['user']);
		}
	}
		
	public function setTask($taskId){
		if($this->task_id == $taskId)return;
		$this->task_id = $taskId;
		if($this->getTask()===false){
			$this->errors['task'] = "Tehtävä on virheellinen";
		}else{
			unset($this->errors['task']);
		}
	}

	private function validateUniqueness(){
		if($this->description===null || $this->user_id === null || $this->user_id === null || $this->start_time === null){
			$this->errors['uniqueness'] = "Kuvaus, Tehtävä, Käyttäjä ja aloitusaika ovat pakollisia";
		}else if($this->exists()){
			$this->errors['uniqueness'] = "Käyttäjälle on jo merkitty tunnit";
		}else {
			unset($this->errors['uniqueness']);
		}
	}
	
	private function exists(){
		$sql = "SELECT 1 FROM user_task_hours WHERE user_id = :user_id AND task_id = :task_id AND start_time = :start_time AND description ILIKE :description";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':user_id', $this->user_id);
		$stmt->bindParam(':task_id', $this->task_id);
		$stmt->bindParam(':start_time', $this->start_time);
		$stmt->bindParam(':description', $this->description);
		$stmt->execute();
		return $stmt->fetchColumn()===1;
	}
	
	public function validate(){
		$this->validateUniqueness();
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
		$sql = "INSERT INTO user_task_hours (user_id, task_id, start_time, end_time, description) 
		VALUES (:user_id, :task_id, :start_time, :end_time, :description) RETURNING id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':user_id', $this->user_id);
		$stmt->bindParam(':task_id', $this->task_id);
		$stmt->bindParam(':start_time', $this->start_time);
		$stmt->bindParam(':end_time', $this->end_time);
		$stmt->bindParam(':description', $this->description);
		if($stmt->execute()){
			$this->id = $stmt->fetchColumn();
			return true;
		}
		return false;
	}

	private function update(){
		$sql = "UPDATE user_task_hours SET user_id = :user_id, task_id = :task_id, start_time = :start_time, end_time = :end_time, description = :description WHERE id = :id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':id', $this->id);
		$stmt->bindParam(':user_id', $this->user_id);
		$stmt->bindParam(':task_id', $this->task_id);
		$stmt->bindParam(':start_time', $this->start_time);
		$stmt->bindParam(':end_time', $this->end_time);
		$stmt->bindParam(':description', $this->description);
		return $stmt->execute();
	}

	public function delete(){
		if($this->id===null)return;
		$sql = "DELETE FROM user_task_hours WHERE id = :id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':id', $this->id);
		$stmt->execute();
		$this->id = null;
	}
	
	public static function getUserTaskHour($id){
		$sql = "SELECT * FROM user_task_hours WHERE id = :id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__); 
		$stmt->execute();
		return $stmt->fetch();
	}
	
	public static function getUserHours($userId){
		$sql = "SELECT * FROM user_task_hours WHERE user_id = :id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(":id", $userId);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
	}
	
	public static function getTaskHours($taskId){
		$sql = "SELECT * FROM user_task_hours WHERE task_id = :id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(":id", $taskId);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
	}
	
	public static function getUserTask($userId, $taskId){
		$sql = "SELECT * FROM user_task_hours WHERE user_id = :user_id AND task_id = :id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(":user_id", $userId);
		$stmt->bindParam(":task_id", $taskId);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
	}
	
	public static function getUserTaskHours(){
		$sql = "SELECT * FROM user_task_hours";
		$stmt = getDB()->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
	}

}
