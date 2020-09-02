<?php

namespace application\controller;

use \application\service\Service;
use \application\controller\BaseController;
use \application\model\UserModel;

/**
 * /?path=auth/{action}
 */
class AuthController extends BaseController {

	public function before() {
		parent::before();

		if ($this->session->get("user") && !($this->request->get("path") == "auth/logout")) {
			$this->request->redirect("/?path=user/index");
		}

		return true;
	}

	public function action_index() {
		return $this->view->render("auth/index");
	}	

	/**
	 * /?path=auth/login
	 */
	public function action_login() {

		if (!$this->request->isPost()) {
			return $this->view->render("error500");	
		}

		$login = $this->request->getPost("login");
		$password = $this->request->getPost("password");

		$userModel = new UserModel();
		$user = $userModel->getUserByNameAndPassword($login, $password);
		$role = ($userModel->getRolebyUser($login))["role_name"];

		if (!$user) {
			$this->request->redirect("/?path=auth/index");
		}

		$this->session->set("user", $user);
		$this->session->set("role", $role);
		$this->request->redirect("/?path=user/index");
	}

	/**
	 * /?path=auth/signup
	 */
	public function action_signup() {
		return $this->view->render("auth/signup");
	}

	/**
	 * /?path=auth/register
	 */
	public function action_register() {

		if (!$this->request->isPost()) {
			$this->request->redirect("/?path=auth/signup&message=Post is required");
		}

		$firstname = $this->request->getPost("firstname");
		$login = $this->request->getPost("login");
		$password = $this->request->getPost("password");

		if (!$login || !$password) {
			$this->request->redirect("/?path=auth/signup&message=Login and password are required");
		}
		$userModel = new UserModel();
	
		
		if (empty($userModel->getUserByLogin($login))) {
			$userModel->createUser($firstname, $login, $password);
		} else {
			$this->request->redirect("/?path=auth/signup&message=User with Login: " . $login . " already exist");
		}
		

		$this->session->set("user", $user);
		$this->request->redirect("/?path=user/index");
	}	

	/**
	 * /?path=auth/logout
	 */
	public function action_logout() {
		$this->session->destroy();
		$this->request->redirect("/?path=auth/index");
	}	
}