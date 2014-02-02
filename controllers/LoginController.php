<?php
class LoginController {
	public function actionIndex(){
		$data = array('username'=>'');
		if(isset($_POST['username'])||isset($_POST['password'])){
			$data['error'] = 'Väärä käyttäjätunnus tai salasana!';
			$data['username'] = $_POST['username'];
		}
		$username = getPost('username');
		$password = getPost('password');
		
		if(!empty($username)&&!empty($password)&&User::login($username, $password))
			header('Location: ' . URL);
		else
			render('login', $data, false);
	}
	
	public function actionLogout(){
		session_destroy();
		header('Location: ' . URL);
	}
}