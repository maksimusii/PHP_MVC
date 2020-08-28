<?php

namespace application\controller;

use \application\service\Service;
use \application\controller\BaseController;

class HomeController extends BaseController {

	protected function before() {
		parent::before();
		return true;
	}

	public function action_index() {
		return $this->view->render("home/index");
	}

	public function action_about() {
		return $this->view->render("home/index");
	}	

}