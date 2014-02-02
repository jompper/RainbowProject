<?php
class User {

	private $id;
	private $username;
	private $password;

	public function __construct($id=null, $username=null, $password=null){
		if(isset($this->id))return;
		$this->id = $id;
		$this->username = $username;
		$this->password = $password;
	}

	public function getId(){
		return $this->id;
	}

	public function getUsername(){
		return $this->username;
	}

	private function hashPassword($password){
		return hash('sha512', $password);
	}
	
	public function verifyPassword($password){
		return $this->password == $this->hashPassword($password);
	}
	
	public static function login($username, $password) {
		$stmt = getDB()->prepare("SELECT id, username, password FROM users WHERE username = :username;");
		$stmt->bindParam(':username', $username);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__); 
		$stmt->execute();
		$user = $stmt->fetch();
		if($user !== false){
			if($user->verifyPassword($password)){
				echo "FUUUU";
				$_SESSION['user'] = $user->getId();
				return true;
			}
		}
		return false;
	}
	
	public static function getUser($user_id){
		$stmt = getDB()->prepare("SELECT id, username, password FROM users WHERE id = :id;");
		$stmt->bindParam(':id', $user_id);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__); 
		$stmt->execute();
		return $stmt->fetch();
	}
	
	public static function getUsers(){
		$sql = "SELECT id, username, password FROM users";
		$stmt = getDB()->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
	}
}
