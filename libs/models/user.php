<?php
class User {

	private $id;
	private $username;
	private $password;

	public function __construct($id, $username, $password){
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

	public function verifyPassword($password){
		return $this->password == $password;
	}

	public static function getUsers(){
		$sql = "SELECT id, username, password FROM users";
		$stmt = getDB()->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
	}
}
