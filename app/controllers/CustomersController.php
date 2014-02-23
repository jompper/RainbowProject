<?php
class CustomersController extends Controller {
	
	public function actionIndex(){
		$this->setDataPair("customers", Customer::getCustomers());
		$this->render('customers');
	}
	
	public function actionShow(){
		$customer = Customer::getCustomer($_GET['id']);
		if($customer===false){
			notice("Asiakasta ei löytynyt");
			redirect("customers");
		}
		$this->setDataPair("customer", $customer);
		$this->setDataPair("projects", Project::getCustomerProjects($customer->getId()));
		$this->render("customer");
	}
	
	public function actionEdit(){
		$customer = Customer::getCustomer($_GET['id']);
		if($customer===false){
			notice("Asiakasta ei löytynyt");
			redirect("customers");
		}
		$this->renderForm(true,$customer);
	}
	
	public function actionUpdate(){
		$customer = Customer::getCustomer($_GET['id']);
		if($customer===false){
			notice("Asiakasta ei löytynyt");
			redirect("customers");
		}
		$customer->setName($_POST['yritys']);
		$customer->setBusinessId($_POST['business_id']);
		$customer->setEmail($_POST['email']);
		$customer->setPhone($_POST['phone']);
		$customer->setPriority($_POST['priority']);
		if($customer->save()){
			notice("Muutokset suoritettiin onnistuneesti");
			redirect("customers");
		}
		$this->renderForm(true,$customer);
	}
	
	public function actionNew(){
		$customer = new Customer();
		$this->renderForm(false, $customer);
	}
	
	public function actionCreate(){
		$customer = new Customer();
		$customer->setName($_POST['yritys']);
		$customer->setBusinessId($_POST['business_id']);
		$customer->setEmail($_POST['email']);
		$customer->setPhone($_POST['phone']);
		$customer->setPriority($_POST['priority']);
		if($customer->save()){
			notice("Asiakas luotiin onnistuneesti");
			redirect("customers");
		}
		$this->renderForm(false, $customer);
	}
	
	public function actionDelete(){
		$customer = Customer::getCustomer($_GET['id']);
		if($customer!==null){
			$customer->delete();
			notice("Asiakas poistettiin onnistuneesti");
		}
		redirect("customers");
	}
	
	private function renderForm($edit, $customer){
		$this->setDataPair("edit", $edit);
		$this->setDataPair("customer", $customer);
		$this->setDataPair("errors", $customer->getErrors());
		$this->setDataPair("priorities", Priority::getPriorities());
		$this->render('customerform');
	}
}
