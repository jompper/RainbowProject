<?php
class LoginController extends Controller {
	public function actionIndex(){
		if(isset($_POST['username'])||isset($_POST['password'])){
			$this->setDataPair('error','Väärä käyttäjätunnus tai salasana!');
		}
		
		$username = getPost('username');
		$password = getPost('password');
		
		$this->setDataPair('username', $username);
		
		if(!empty($username)&&!empty($password)&&User::login($username, $password)){
			header('Location: ' . URL);
		} else {
			$this->renderPartial('login');
		}
	}
	
	public function actionLogout(){
		session_destroy();
		header('Location: ' . URL);
	}
}
