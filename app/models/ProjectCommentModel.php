<?php
class ProjectComment {
	
	private $id;
	private $project_id;
	private $user_id;
	private $comment;
	private $post_date;
	
	private $timestamp_post_date;
	
	private $project;
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

	public function getProject(){
		if($this->project===null){
			$this->project = Project::getProject($this->project_id);
		}
		return $this->project;
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
		
	public function setProject($projectId){
		if($this->project_id == $projectId)return;
		$this->project_id = $projectId;
		if($this->getProject()===false){
			$this->errors['project'] = "Projekti on virheellinen";
		}else{
			unset($this->errors['project']);
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
		$sql = "INSERT INTO project_comments (user_id, project_id, comment) 
		VALUES (:user_id, :project_id, :comment) RETURNING id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':user_id', $this->user_id);
		$stmt->bindParam(':project_id', $this->project_id);
		$stmt->bindParam(':comment', $this->comment);
		if($stmt->execute()){
			$this->id = $stmt->fetchColumn();
			return true;
		}
		return false;
	}

	
	public static function getProjectComments($projectId){
		$sql = "SELECT * FROM project_comments WHERE project_id = :project_id ORDER BY post_date DESC";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(":project_id", $projectId);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
	}
}