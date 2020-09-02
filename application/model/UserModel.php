<?php

namespace application\model;

use \application\service\Service;
use \application\model\BaseModel;

class UserModel extends BaseModel {

	public function getUserById($id) {
		$statement = self::$connection->prepare("SELECT * FROM user WHERE id = :id");
		$statement->bindValue(':id', $id, \PDO::PARAM_INT);
		$statement->execute();

		return $statement->fetch(\PDO::FETCH_ASSOC);
	}	

	public function getUserByNameAndPassword($login, $password) {
		$statement = self::$connection->prepare("SELECT * FROM user WHERE login = :login AND password=:password");
		$statement->bindValue(':login', $login, \PDO::PARAM_STR);
		$statement->bindValue(':password', md5($password), \PDO::PARAM_STR);
		$statement->execute();

		return $statement->fetch(\PDO::FETCH_ASSOC);
	}
	
	public function createUser($name, $login, $password) {
		$statement = self::$connection->prepare("INSERT INTO user (name, login, password) VALUES (:name, :login, :password)");
		$statement->bindValue(':name', $name, \PDO::PARAM_STR);
		$statement->bindValue(':login', $login, \PDO::PARAM_STR);
		$statement->bindValue(':password', md5($password), \PDO::PARAM_STR);
		$statement->execute();

		return true;
	}

	public function getUserByLogin($login) {
		$statement = self::$connection->prepare("SELECT * FROM user WHERE login = :login");
		$statement->bindValue(':login', $login, \PDO::PARAM_STR);
		$statement->execute();

		return $statement->fetch(\PDO::FETCH_ASSOC);
	}	

	public function getHisoryPagesName() {
		$user_id = (int)$_SESSION["user"]["id"];
		$statement = self::$connection->prepare("SELECT * FROM history_pages WHERE user_id = :user_id");
		$statement->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
		$statement->execute();

		return $statement->fetchAll(\PDO::FETCH_ASSOC);
	}	

	public function setPageName() {
		$name = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$user_id = (int)$_SESSION["user"]["id"];
		$statement = self::$connection->prepare("INSERT INTO history_pages (name, user_id) VALUES (:name, :user_id)");
		$statement->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
		$statement->bindValue(':name', $name, \PDO::PARAM_STR);
		$statement->execute();

		return true;
	}

	public function getRolebyUser($login) {
		$statement = self::$connection->prepare("SELECT b.login, k.role_name
																						  FROM user b
																							LEFT JOIN user_role g ON b.id=g.user_id
																							LEFT JOIN role k ON g.role_id=k.id 
																							WHERE b.login = :login");
		$statement->bindValue(':login', $login, \PDO::PARAM_STR);
		$statement->execute();

		return $statement->fetch(\PDO::FETCH_ASSOC);
	}

}