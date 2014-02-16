<?php
class Priority {

	private $id;
	private $priority;
	private $name;

	private $errors;

	public function __construct(){
		$this->errors = array();
	}
	
	public function getId(){
		return $this->id;
	}

	public function getValue(){
		return $this->priority;
	}
	
	public function getName(){
		return $this->name;
	}

	public function setValue($priority){		
		$this->priority = intVal($priority);
		if($this->priority <0 || $this->priority > 100){
			$this->errors['priority']="Prioriteetin tulee olla väliltä 1-100";		
		}else{
			unset($this->errors['priority']);
		}
	}
	
	public function setName($name){		
		$this->name = $name;
		if(trim($this->name)==''){
			$this->errors['name']="Kuvaus on pakollinen";
		}else if(!preg_match("/^[a-z -]+$/i",$this->name)){
			$this->errors['name']="Kuvaus voi sisältää vain kirjaimia tai merkkejä [- ]";		
		}else if(strlen($this->name)>50){
			$this->errors['name'] = "Kuvaus on liian pitkä, maksimipituus 50 merkkiä";
		}else if(Priority::priorityExists($this->name)){
			$this->errors['name']="Kuvaus on jo käytössä";
		}else{
			unset($this->errors['name']);
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
		if($this->id === null){
			return $this->insert();
		}else{
			return $this->update();
		}
	}

	private function insert(){
		$sql = "INSERT INTO priorities (priority, name) VALUES (_priority, :name) RETURNING id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':priority', $this->priority);
		$stmt->bindParam(':name', $this->name);
		if($stmt->execute()){
			$this->id = $stmt->fetchColumn();
			return true;
		}
		return false;
	}

	private function update(){
		$sql = "UPDATE priorities SET priority = :priority, name = :name WHERE id = :id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':id', $this->id);
		$stmt->bindParam(':priority', $this->priority);
		$stmt->bindParam(':name', $this->name);
		return $stmt->execute();
	}

	public function delete(){
		if($this->id===null)return;
		$sql = "DELETE FROM priorities WHERE id = :id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':id', $this->id);
		$stmt->execute();
		$this->id = null;
	}
	
	public static function getPriority($priority_id){
		$stmt = getDB()->prepare("SELECT * FROM priorities WHERE id = :id;");
		$stmt->bindParam(':id', $priority_id);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__); 
		$stmt->execute();
		return $stmt->fetch();
	}

	public static function getPriorities(){
		$sql = "SELECT * FROM priorities ORDER BY priority ASC";
		$stmt = getDB()->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
	}

	public static function priorityExists($name){
		$sql = "SELECT 1 FROM priorities WHERE name ILIKE :name";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':name', $name);
		$stmt->execute();
		return $stmt->fetchColumn()===1;
	}

}
