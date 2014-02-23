<?php
class UsersController extends Controller {
	
	public function filter($action){
		if(getUser()->isAdmin()){
			return true;
		}
		$action = substr($action,6);
		if($action == "Update" && $_GET['id'] == $_SESSION['user'])
			return true;
		else
			return !in_array($action, array("New", "Create", "Edit", "Update", "Index", "Show"));
	}
	
	public function actionIndex(){
		$this->setDataPair("users", User::getUsers());
		$this->render('users');
	}
	
	public function actionShow(){
		$user = User::getUser($_GET['id']);
		if($user===false){
			notice("Käyttäjää ei löytynyt");
			redirect("users");
		}
		$this->setDataPair("user", $user);
		$this->render("user");
	}
	
	public function actionEdit(){
		$user = User::getUser($_GET['id']);
		if($user===false){
			notice("Käyttäjää ei löytynyt");
			redirectBack();
		}
		$this->renderForm(true,$user);
	}
	
	public function actionUpdate(){
		$user = User::getUser($_GET['id']);
		if($user===false){
			notice("Käyttäjää ei löytynyt");
			redirectBack();
		}
		$user->setFullName($_POST['fullname']);
		$user->setEmail($_POST['email']);
		
		if(!empty($_POST['password'])){
			$user->setPassword($_POST['password'], $_POST['passwordconfirm']);
		}
		if($_SESSION['admin']){
			$user->setAdmin($_POST['admin']);
		}
		if($user->save()){
			notice("Muutokset suoritettiin onnistuneesti");
			if($_SESSION['admin']){
				redirect("users");
			}else{
				redirect();
			}
		}
		$this->renderForm(true,$user);
	}
	
	public function actionNew(){
		$user = new User();
		$this->renderForm(false, $user);
	}
	
	public function actionCreate(){
		$user = new User();
		$user->setUsername($_POST['username']);
		$user->setPassword($_POST['password'], $_POST['passwordconfirm']);
		$user->setFullName($_POST['fullname']);
		$user->setEmail($_POST['email']);
		$user->setAdmin($_POST['admin']);
		if($user->save()){
			notice("Käyttäjä luotiin onnistuneesti");
			redirect("users");
		}
		$this->renderForm(false, $user);
	}
	
	public function actionDelete(){
		$user = User::getUser($_GET['id']);
		if($user!==null){
			$current = getUser()->getId() == $user->getId();
			$user->delete();
			notice("Käyttäjä poistettiin onnistuneesti");
			if($current)redirect("login","logout");
		}
		redirect("users");
	}
	
	public function actionProfile(){
		$user = getUser();
		$this->renderForm(true, $user);
	}
	
	private function renderForm($edit, $user){
		$this->setDataPair("edit", $edit);
		$this->setDataPair("user", $user);
		$this->setDataPair("errors", $user->getErrors());
		$this->render('userform');
	}
}
