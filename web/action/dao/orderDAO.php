<?php
	require_once("action/dao/Connection.php");

	class OrderDAO {
		public static function createOrder($coinId, $userId, $transactionType, $amount, $price, $date, $pair) {
			$connection = Connection::getConnection();
			try{
				$statement = $connection->prepare("INSERT INTO TABLE_ORDER (coinid, userid, transactiontype, amount, price, ordertime, pair) VALUES (?,?,?,?,?,?,?)");
				$statement->bindParam(1, $coinId);
				$statement->bindParam(2, $userId);
				$statement->bindParam(3, $transactionType);
				$statement->bindParam(4, $amount);
				$statement->bindParam(5, $price);
				$statement->bindParam(6, $date);
				$statement->bindParam(7, $pair);
				$statement->execute();
			}
			catch(Exception $e){
			}
		}	

		public static function createOrderHistory($coinId, $userId, $transactionType, $amount, $price, $orderid, $ordertime, $pair, $status) {
			$connection = Connection::getConnection();
			try{
				$statement = $connection->prepare("INSERT INTO TABLE_ORDER_HISTORY (coinid, userid, transactiontype, amount, price, orderid, ordertime, pair, status) VALUES (?,?,?,?,?,?,?,?,?)");
				$statement->bindParam(1, $coinId);
				$statement->bindParam(2, $userId);
				$statement->bindParam(3, $transactionType);
				$statement->bindParam(4, $amount);
				$statement->bindParam(5, $price);
				$statement->bindParam(6, $orderid);
				$statement->bindParam(7, $ordertime);
				$statement->bindParam(8, $pair);
				$statement->bindParam(9, $status);
				$statement->execute();
			}
			catch(Exception $e){
				print_r($e);
			}
		}	

		public static function getOrders($userId) {
			$connection = Connection::getConnection();
			try{
				$statement = $connection->prepare("SELECT * FROM TABLE_ORDER WHERE userid = ? ORDER BY id");
				$statement->bindParam(1, $userId);
				$statement->setFetchMode(PDO::FETCH_ASSOC);
				$statement->execute();
	
				$orders = $statement->fetchAll();
				return $orders;
			}
			catch(Exception $e){
			}
		}	

		public static function getOrderHistory($userId) {
			$connection = Connection::getConnection();
			try{
				$statement = $connection->prepare("SELECT * FROM TABLE_ORDER_HISTORY WHERE userid = ? ORDER BY id");
				$statement->bindParam(1, $userId);
				$statement->setFetchMode(PDO::FETCH_ASSOC);
				$statement->execute();
	
				$orders = $statement->fetchAll();
				return $orders;
			}
			catch(Exception $e){
			}
		}	

		public static function getOrderId($coinId, $userId, $transactionType, $amount, $price, $date, $pair) {
			$connection = Connection::getConnection();
			try{
				$statement = $connection->prepare("SELECT id FROM TABLE_ORDER WHERE coinid = ? AND userid = ? AND transactiontype = ? AND amount= ? AND price = ? AND ordertime=? AND pair=?");
				$statement->bindParam(1, $coinId);
				$statement->bindParam(2, $userId);
				$statement->bindParam(3, $transactionType);
				$statement->bindParam(4, $amount);
				$statement->bindParam(5, $price);
				$statement->bindParam(6, $date);
				$statement->bindParam(7, $pair);
				$statement->setFetchMode(PDO::FETCH_ASSOC);
				$statement->execute();
	
				$order = $statement->fetch();
				$orderid = $order["id"];
				return $orderid;
			}
			catch(Exception $e){
				print_r($e);
			}
		}	

	}