<?php

namespace application\controller;

use \application\service\Service;
use \application\service\FrontController;
use \application\model\UserModel;

class BaseController extends FrontController {

	public function before() {
		$this->view->addGlobal('title', $this->config->get("title"));
		$this->view->addGlobal('user', $this->session->get("user"));

		if ($this->session->get("user")) {
			$userModel = new UserModel();
			$userModel->setPageName();
		}
	
		return true;
	}
}