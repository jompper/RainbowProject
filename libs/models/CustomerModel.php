<?php
class Customer {

	private $id;
	private $priority_id;
	private $name;
	private $business_id;
	private $email;
	private $phone;
	
	private $projects;
	private $priority;

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

	public function getBusinessId(){
		return $this->business_id;
	}

	public function getEmail(){
		return $this->email;
	}

	public function getPhone(){
		return $this->phone;
	}
	
	public function getPriorityId(){
		return $this->priority_id;
	}
	
	public function getPriority(){
		if($this->priority===null){
			$this->priority = Priority::getPriority($this->priority_id);
		}
		return $this->priority;
	}

	public function setName($name){	
		$this->name = htmlspecialchars($name);
		if(trim($this->name)==''){
			$this->errors['name']="Yrityksen nimi ei voi olla tyhjä";
		}else if(strlen($this->name)>255){
			$this->errors['name'] = "Nimi on liian pitkä, maksimipituus 255 merkkiä";
		}else{
			unset($this->errors['name']);
		}
	}

	public function setBusinessId($business_id){
		if($this->business_id == htmlspecialchars($business_id))return;
		$this->business_id = htmlspecialchars($business_id);
		if(trim($this->business_id)==''){
			$this->errors['business_id']="Y-tunnus on pakollinen";
		}else if(strlen($this->business_id)>20){
			$this->errors['business_id'] = "Y-tunus on liian pitkä, maksimipituus 20 merkkiä";
		}else if(Customer::businessIdExists($this->business_id)){
			$this->errors['business_id']="Järjestelmässä on jo yritys samalla Y-tunnuksella";
		}else{
			unset($this->errors['business_id']);
		}
	}
	
	public function setEmail($email){
		$this->email = $email;		
		if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
			$this->errors['email'] = "Sähköpostiosoite on virheellinen";
		}else{
			unset($this->errors['email']);
		}
	}

	public function setPhone($phone){
		$this->phone = $phone;		
		if(preg_match("/[^0-9 ()+-]+/",$this->phone)){
			$this->errors['phone'] = "Puhelinnumerossa voi käyttää vain seuraavia merkkejä [0-9 ()+-]";
		}else{
			unset($this->errors['phone']);
		}
	}
	
	public function setPriority($priorityId){
		$this->priority_id = $priorityId;
		if($this->getPriority()===false){
			$this->errors['priority'] = "Prioriteetti on virheellinen";
		}else{
			unset($this->errors['priority']);
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
		$sql = "INSERT INTO customers (priority_id, name, business_id, email, phone) VALUES (:priority_id, :name, :business_id, :email, :phone) RETURNING id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':priority_id', $this->priority_id);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':business_id', $this->business_id);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':phone', $this->phone);
		if($stmt->execute()){
			$this->id = $stmt->fetchColumn();
			return true;
		}
		return false;
	}

	private function update(){
		$sql = "UPDATE customers SET priority_id = :priority_id, name = :name, business_id = :business_id, email = :email, phone = :phone WHERE id = :id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':id', $this->id);
		$stmt->bindParam(':priority_id', $this->priority_id);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':business_id', $this->business_id);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':phone', $this->phone);
		return $stmt->execute();
	}

	public function delete(){
		if($this->id===null)return;
		$sql = "DELETE FROM customers WHERE id = :id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':id', $this->id);
		$stmt->execute();
		$this->id = null;
	}
	
	public static function getCustomer($customer_id){
		$stmt = getDB()->prepare("SELECT * FROM customers WHERE id = :id;");
		$stmt->bindParam(':id', $customer_id);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__); 
		$stmt->execute();
		return $stmt->fetch();
	}
	
	public static function getCustomers(){
		$sql = "SELECT * FROM customers ORDER BY name ASC";
		$stmt = getDB()->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
	}

	public static function businessIdExists($business_id){
		$sql = "SELECT 1 FROM customers WHERE business_id ILIKE :business_id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':business_id', $business_id);
		$stmt->execute();
		return $stmt->fetchColumn()===1;
	}

}
