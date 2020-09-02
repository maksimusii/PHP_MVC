<?php

namespace application\controller;

use \application\service\Service;
use \application\controller\BaseController;
use \application\model\AdminModel;

class AdminController extends BaseController {

  public function before() {
		parent::before();
		return true;
  }
  
  public function action_index() {

		$user = $this->session->get("user");
		$role = $this->session->get("role");
		
		$adminModel = new AdminModel();
		$items = $adminModel->getOrders();
		
		if ($role == "Admin") {
			return $this->view->render("admin/index", [
				"items"=>$items
			]);
		} else {
			return $this->view->render("PageUnavailable");
		}
		
	}	
	public function action_changeStatus() {
		$adminModel = new AdminModel();
		$adminModel->setNewOrderStatus($_POST['id_order_status'], $_POST['id_order']);
		$response['result'] = 1;
		$response['order_status'] = $adminModel->getOrderStatusNamebyId($_POST['id_order_status'])["order_status_name"];
		print_r(json_encode($response));
	}
}