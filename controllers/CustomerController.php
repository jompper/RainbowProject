<?php
class CustomerController {
	
	public function actionIndex(){
			$customers = Customer::getCustomers();
			render('customers', array("customers" => $customers));
	}
	
	public function actionShow(){
			$customer = Customer::getCustomer($_GET['id']);
			if($customer===false){
				notice("Asiakasta ei löytynyt");
				redirect("customer");
			}
			render("customer",array("customer" => $customer));
	}
	
	public function actionEdit(){
			$customer = Customer::getCustomer($_GET['id']);
			if($customer===false){
				notice("Asiakasta ei löytynyt");
				redirect("customer");
			}
			if(!empty($_POST)){
				$customer->setName($_POST['yritys']);
				$customer->setBusinessId($_POST['business_id']);
				$customer->setEmail($_POST['email']);
				$customer->setPhone($_POST['phone']);
				$customer->setPriority($_POST['priority']);
				if($customer->save()){
					notice("Muutokset suoritettiin onnistuneesti");
					redirect("customer");
				}
			}
			$this->renderForm(true,$customer);
	}
	
	public function actionCreate(){
			$customer = new Customer();
			if(!empty($_POST)){
				$customer->setName($_POST['yritys']);
				$customer->setBusinessId($_POST['business_id']);
				$customer->setEmail($_POST['email']);
				$customer->setPhone($_POST['phone']);
				$customer->setPriority($_POST['priority']);
				if($customer->save()){
					notice("Asiakas luotiin onnistuneesti");
					redirect("customer");
				}
			}
			$this->renderForm(false, $customer);
	}
	
	public function actionDelete(){
		$customer = Customer::getCustomer($_GET['id']);
		if($customer!==null){
			$customer->delete();
			notice("Asiakas poistettiin onnistuneesti");
		}
		redirect("customer");
	}
	
	private function renderForm($edit, $customer){
		render('customerform', array("edit" => $edit, 
									 "customer" => $customer, 
									 "errors" => $customer->getErrors(),
									 "priorities" => Priority::getPriorities()
									 )
			  );
	}
}
