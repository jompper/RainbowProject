<?php
class User {

	private $id;
	private $role_id;
	private $username;
	private $password;
	private $full_name;
	private $email;
	
	private $role;

	private $errors;

	public function __construct(){
		$this->errors = array();
	}
	
	public function getId(){
		return $this->id;
	}

	public function getUsername(){
		return $this->username;
	}

	public function getFullName(){
		return $this->full_name;
	}

	public function getEmail(){
		return $this->email;
	}

	public function getRoleId(){
		return $this->role_id;
	}

	public function getRole(){
		if($this->role===null){
			$this->role = Role::getRole($this->role_id);
		}
		return $this->role;
	}

	public function setUsername($username){
		if($this->username == $username)return;		
		$this->username = $username;
		if(trim($this->username)==''){
			$this->errors['username']="Käyttäjätunnus ei voi olla tyhjä";
		}else if(!preg_match("/^[a-z]+$/i",$this->username)){
			$this->errors['username']="Käyttäjätunnus voi sisältää vain kirjaimia";		
		}else if(User::usernameExists($this->username)){
			$this->errors['username']="Käyttäjätunnus on jo käytössä";
		}else{
			unset($this->errors['username']);
		}
	}

	public function setPassword($password, $password_confirmation){
		if($password != $password_confirmation){
			$this->errors['password'] = "Salasanat eivät täsmää";
		}else if(strlen(trim($password))<6){
			$this->errors['password'] = "Salasanan tulee sisältää vähintään 6 merkkiä";
		}else{
			$this->password = $this->hashPassword($password);
			unset($this->errors['password']);
		}
		
	}

	public function setFullName($fullName){
		if($this->full_name == $fullName)return;
		$this->full_name = htmlspecialchars($fullName);		
		if(trim($this->full_name)==''){
			$this->errors['full_name'] = "Kokonimi on pakollinen";
		}else{
			unset($this->errors['full_name']);
		}
	}
	
	public function setEmail($email){		
		if($this->email == $email)return;
		$this->email = $email;		
		if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
			$this->errors['email'] = "Sähköpostiosoite on virheellinen";
		}else if(User::emailExists($this->email)){
			$this->errors['email']="Sähköpostiosoite on jo käytössä";
		}else{
			unset($this->errors['email']);
		}
	}

	public function setRole($roleId){
		$this->role_id = $roleId;
		if($this->getRole()===null){
			$this->errors['role'] = "Käyttäjäryhmä on virheellinen";
		}else{
			unset($this->errors['role']);
		}
	}

	public function getTasks(){
		$sql = "SELECT t.* FROM user_tasks ut JOIN tasks t ON ut.task_id = t.id JOIN priorities p ON t.priority_id = p.id WHERE ut.user_id = :uid ORDER BY t.due_date, p.priority DESC";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(":uid", $this->id);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_CLASS, 'Task');
	}

	private function hashPassword($password){
		return hash('sha512', $password);
	}
	
	public function verifyPassword($password){
		return $this->password == $this->hashPassword($password);
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
		$sql = "INSERT INTO users (role_id, username, password, full_name, email) VALUES (:role_id, :username, :password, :full_name, :email) RETURNING id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':role_id', $this->role_id);
		$stmt->bindParam(':username', $this->username);
		$stmt->bindParam(':password', $this->password);
		$stmt->bindParam(':full_name', $this->full_name);
		$stmt->bindParam(':email', $this->email);
		if($stmt->execute()){
			$this->id = $stmt->fetchColumn();
			return true;
		}
		return false;
	}

	private function update(){
		$sql = "UPDATE users SET role_id = :role_id, password = :password, full_name = :full_name, email = :email WHERE id = :id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':id', $this->id);
		$stmt->bindParam(':role_id', $this->role_id);
		$stmt->bindParam(':password', $this->password);
		$stmt->bindParam(':full_name', $this->full_name);
		$stmt->bindParam(':email', $this->email);
		return $stmt->execute();
	}

	public function delete(){
		if($this->id===null)return;
		$sql = "DELETE FROM users WHERE id = :id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':id', $this->id);
		$stmt->execute();
		$this->id = null;
	}
	
	public static function login($username, $password) {
		$stmt = getDB()->prepare("SELECT id, username, password FROM users WHERE username ILIKE :username;");
		$stmt->bindParam(':username', $username);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__); 
		$stmt->execute();
		$user = $stmt->fetch();
		if($user !== false){
			if($user->verifyPassword($password)){
				$_SESSION['user'] = $user->getId();
				return true;
			}
		}
		return false;
	}
	
	public static function getUser($user_id){
		$stmt = getDB()->prepare("SELECT * FROM users WHERE id = :id;");
		$stmt->bindParam(':id', $user_id);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__); 
		$stmt->execute();
		return $stmt->fetch();
	}
	
	public static function getUsers(){
		$sql = "SELECT * FROM users ORDER BY full_name ASC";
		$stmt = getDB()->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
	}

	public static function usernameExists($username){
		$sql = "SELECT 1 FROM users WHERE username ILIKE :username";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':username', $username);
		$stmt->execute();
		return $stmt->fetchColumn()===1;
	}

	public static function emailExists($email){
		$sql = "SELECT 1 FROM users WHERE email ILIKE :email";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':email', $email);
		$stmt->execute();
		return $stmt->fetchColumn()===1;
	}
}
