<?php
class Role {

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
			$this->errors['name']="Käyttäjärooli on pakollinen";
		}else if(!preg_match("/^[a-z -]+$/i",$this->name)){
			$this->errors['name']="Käyttäjärooli voi sisältää vain kirjaimia tai merkkejä [- ]";		
		}else if(Role::roleExists($this->name)){
			$this->errors['name']="Käyttäjärooli on jo käytössä";
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
		$sql = "INSERT INTO roles (name) VALUES (:name) RETURNING id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':name', $this->name);
		if($stmt->execute()){
			$this->id = $stmt->fetchColumn();
			return true;
		}
		return false;
	}

	private function update(){
		$sql = "UPDATE roles SET name = :name WHERE id = :id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':id', $this->id);
		$stmt->bindParam(':name', $this->name);
		return $stmt->execute();
	}

	public function delete(){
		if($this->id===null)return;
		$sql = "DELETE FROM roles WHERE id = :id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':id', $this->id);
		$stmt->execute();
		$this->id = null;
	}
	
	public static function getRole($role_id){
		$stmt = getDB()->prepare("SELECT id, name FROM roles WHERE id = :id;");
		$stmt->bindParam(':id', $role_id);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__); 
		$stmt->execute();
		return $stmt->fetch();
	}

	public static function getRoles(){
		$sql = "SELECT id, name FROM roles";
		$stmt = getDB()->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
	}

	public static function roleExists($name){
		$sql = "SELECT 1 FROM roles WHERE name ILIKE :name";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':name', $name);
		$stmt->execute();
		return $stmt->fetchColumn()===1;
	}

}
