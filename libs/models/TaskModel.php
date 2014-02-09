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
}
