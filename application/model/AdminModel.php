<?php

namespace application\model;

use \application\service\Service;
use \application\model\BaseModel;
use \application\model\UserModel;

class AdminModel extends BaseModel {

  public function getOrders() {
		$statement = self::$connection->prepare("
		SELECT 
			b.id, 
			k.login, 
			h.name, 
			b.created, 
			b.amount, 
			g.order_status_name														
		FROM 
			orders b
		LEFT JOIN 
			user k 
		ON 
			b.user_id=k.id
		LEFT JOIN 
			goods h 
		ON 
			h.id=b.good_id
		LEFT JOIN 
			order_status g 
		ON 
			b.id_order_status=g.id
		ORDER BY 
			created DESC
		");
		$statement->execute();

		return $statement->fetchAll(\PDO::FETCH_ASSOC);
	}	

	public function setNewOrderStatus($id_order_status, $id_order) {
		$statement = self::$connection->prepare("
		UPDATE 
			orders
		SET 
			id_order_status = :id_order_status
		WHERE 
			id = :id_order
		");
		$statement->bindValue(':id_order_status', $id_order_status, \PDO::PARAM_INT);
		$statement->bindValue(':id_order', $id_order, \PDO::PARAM_INT);
		$statement->execute();

		return true;
	}
	public function getOrderStatusNamebyId($id_order_status) {
		$statement = self::$connection->prepare("SELECT * FROM order_status WHERE id = :id");
		$statement->bindValue(':id', $id_order_status, \PDO::PARAM_INT);
		$statement->execute();

		return $statement->fetch(\PDO::FETCH_ASSOC);
	}
}