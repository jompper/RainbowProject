<?php
class Status {

	private $id;
	private $name;

	private $errors;

	public function __construct(){
		$this->errors = array();
	}
	
	public function getId(){
		return $this->id;
	}

	public function getName(){
		return $this->name;
	}

	public function setName($name){		
		$this->name = $name;
		if(trim($this->name)==''){
			$this->errors['name']="Tila on pakollinen";
		}else if(!preg_match("/^[a-z -]+$/i",$this->name)){
			$this->errors['name']="Tila voi sisältää vain kirjaimia tai merkkejä [- ]";		
		}else if(strlen($this->name)>50){
			$this->errors['name'] = "Tila on liian pitkä, maksimipituus 50 merkkiä";
		}else if(Role::roleExists($this->name)){
			$this->errors['name']="Tila on jo käytössä";
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
		$sql = "INSERT INTO statuses (name) VALUES (:name) RETURNING id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':name', $this->name);
		if($stmt->execute()){
			$this->id = $stmt->fetchColumn();
			return true;
		}
		return false;
	}

	private function update(){
		$sql = "UPDATE statuses SET name = :name WHERE id = :id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':id', $this->id);
		$stmt->bindParam(':name', $this->name);
		return $stmt->execute();
	}

	public function delete(){
		if($this->id===null)return;
		$sql = "DELETE FROM statuses WHERE id = :id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':id', $this->id);
		$stmt->execute();
		$this->id = null;
	}
	
	public static function getStatus($statusId){
		$stmt = getDB()->prepare("SELECT * FROM statuses WHERE id = :id;");
		$stmt->bindParam(':id', $statusId);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__); 
		$stmt->execute();
		return $stmt->fetch();
	}

	public static function getStatuses(){
		$sql = "SELECT id, name FROM statuses";
		$stmt = getDB()->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
	}

	public static function statusExists($name){
		$sql = "SELECT 1 FROM statuses WHERE name ILIKE :name";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':name', $name);
		$stmt->execute();
		return $stmt->fetchColumn()===1;
	}

}
