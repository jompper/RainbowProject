<?php
class UserController {
	
	public function actionIndex(){
			$users = User::getUsers();
			render('users', array("users" => $users));
	}
	
	public function actionShow(){
			$user = User::getUser($_GET['id']);
			if($user===false){
				notice("Käyttäjää ei löytynyt");
				redirect("user");
			}
			render("user",array("user" => $user));
	}
	
	public function actionEdit(){
			$user = User::getUser($_GET['id']);
			if($user===false){
				notice("Käyttäjää ei löytynyt");
				redirect("user");
			}
			if(!empty($_POST)){
				$user->setFullName($_POST['fullname']);
				$user->setEmail($_POST['email']);
				$user->setRole($_POST['role']);
				if(!empty($_POST['password'])){
					$user->setPassword($_POST['password'], $_POST['passwordconfirm']);
				}
				if($user->save()){
					notice("Muutokset suoritettiin onnistuneesti");
					redirect("user");
				}
			}
			$this->renderForm(true,$user);
	}
	
	public function actionCreate(){
			$user = new User();
			if(!empty($_POST)){
				$user->setUsername($_POST['username']);
				$user->setPassword($_POST['password'], $_POST['passwordconfirm']);
				$user->setFullName($_POST['fullname']);
				$user->setEmail($_POST['email']);
				$user->setRole($_POST['role']);
				if($user->save()){
					notice("Käyttäjä luotiin onnistuneesti");
					redirect("user");
				}
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
		redirect("user");
	}
	
	private function renderForm($edit, $user){
		$roles = Role::getRoles();
		render('userform', array("edit" => $edit, "user" => $user, "roles" => $roles, "errors" => $user->getErrors()));
	}
}
