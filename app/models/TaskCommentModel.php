<?php
class TaskComment {
	
	private $id;
	private $task_id;
	private $user_id;
	private $comment;
	private $post_date;
	
	private $timestamp_post_date;
	
	private $task;
	private $user;

	private $errors;
	
	public function __construct(){
		$this->errors = array();
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getPostDate($format = "d.m.Y"){
		if($this->post_date === null)return"";
		if($this->timestamp_post_date===null){
			$this->timestamp_post_date = strtotime($this->post_date);
		}
		return date($format, $this->timestamp_post_date);
	}
	
	public function getComment(){
		return $this->comment;
	}

	public function getTask(){
		if($this->task===null){
			$this->task = Task::getTask($this->task_id);
		}
		return $this->task;
	}
	
	public function getUser(){
		if($this->user===null){
			$this->user = User::getUser($this->user_id);
		}
		return $this->user;
	}
	
	public function setComment($comment){	
		$this->comment = htmlspecialchars($comment);
	}
		
	public function setTask($taskId){
		$this->task_id = $taskId;
		if($this->getTask()===false){
			$this->errors['task'] = "Tehtävä on virheellinen";
		}else{
			unset($this->errors['task']);
		}
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
		return $this->insert();
	}

	private function insert(){
		$sql = "INSERT INTO task_comments (user_id, task_id, comment) 
		VALUES (:user_id, :task_id, :comment) RETURNING id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':user_id', $this->user_id);
		$stmt->bindParam(':task_id', $this->task_id);
		$stmt->bindParam(':comment', $this->comment);
		if($stmt->execute()){
			$this->id = $stmt->fetchColumn();
			return true;
		}
		return false;
	}

	
	public static function getTaskComments($taskId){
		$sql = "SELECT * FROM task_comments WHERE task_id = :task_id ORDER BY post_date DESC";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(":task_id", $taskId);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
	}
}