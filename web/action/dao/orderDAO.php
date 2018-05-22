<?php
	require_once("action/dao/Connection.php");

	class OrderDAO {
		public static function createOrder($coinId, $userId, $transactionType, $amount, $price, $date, $pair, $originalamount) {
			$connection = Connection::getConnection();
			try{
				$statement = $connection->prepare("INSERT INTO TABLE_ORDER (coinid, userid, transactiontype, amount, price, ordertime, pair, originalamount) VALUES (?,?,?,?,?,?,?,?)");
				$statement->bindParam(1, $coinId);
				$statement->bindParam(2, $userId);
				$statement->bindParam(3, $transactionType);
				$statement->bindParam(4, $amount);
				$statement->bindParam(5, $price);
				$statement->bindParam(6, $date);
				$statement->bindParam(7, $pair);
				$statement->bindParam(8, $originalamount);
				$statement->execute();
			}
			catch(Exception $e){
			}
		}	

		public static function createOrderHistory($coinId, $userId, $transactionType, $amount, $price, $ordertime, $pair, $status, $originalamount) {
			$connection = Connection::getConnection();
			try{
				$statement = $connection->prepare("INSERT INTO TABLE_ORDER_HISTORY (coinid, userid, transactiontype, amount, price, ordertime, pair, status,originalamount) VALUES (?,?,?,?,?,?,?,?,?)");
				$statement->bindParam(1, $coinId);
				$statement->bindParam(2, $userId);
				$statement->bindParam(3, $transactionType);
				$statement->bindParam(4, $amount);
				$statement->bindParam(5, $price);
				$statement->bindParam(6, $ordertime);
				$statement->bindParam(7, $pair);
				$statement->bindParam(8, $status);
				$statement->bindParam(9, $originalamount);
				$statement->execute();
			}
			catch(Exception $e){
			}
		}	

		public static function getOrders($userId) {
			$connection = Connection::getConnection();
			try{
				$statement = $connection->prepare("SELECT * FROM TABLE_ORDER WHERE userid = ? ORDER BY id DESC");
				$statement->bindParam(1, $userId);
				$statement->setFetchMode(PDO::FETCH_ASSOC);
				$statement->execute();
	
				$orders = $statement->fetchAll();
				return $orders;
			}
			catch(Exception $e){
			}
		}	

		public static function deleteOrder($orderid) {
			$connection = Connection::getConnection();
			try{
				$statement = $connection->prepare("DELETE FROM TABLE_ORDER WHERE id = ?");
				$statement->bindParam(1, $orderid);
				$statement->execute();
			}
			catch(Exception $e){
			}
		}	

		public static function getOrdersFromPair($transactiontype, $pair) {
			$connection = Connection::getConnection();
			try{
				$statement = $connection->prepare("SELECT * FROM TABLE_ORDER WHERE pair = ? AND transactiontype = ? ORDER BY price");
				$statement->bindParam(1, $pair);
				$statement->bindParam(2, $transactiontype);
				$statement->setFetchMode(PDO::FETCH_ASSOC);
				$statement->execute();
	
				$orders = $statement->fetchAll();
				return $orders;
			}
			catch(Exception $e){
			}
		}	

		public static function getOrderFromId($id) {
			$connection = Connection::getConnection();
			try{
				$statement = $connection->prepare("SELECT * FROM TABLE_ORDER WHERE id = ?");
				$statement->bindParam(1, $id);

				$statement->setFetchMode(PDO::FETCH_ASSOC);
				$statement->execute();
	
				$order = $statement->fetchAll();
				return $order;
			}
			catch(Exception $e){
			}
		}	

		public static function getOrderHistory($userId) {
			$connection = Connection::getConnection();
			try{
				$statement = $connection->prepare("SELECT * FROM TABLE_ORDER_HISTORY WHERE userid = ? ORDER BY id DESC");
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
			}
		}	

		public static function updateOrder($amount, $orderid) {
			$connection = Connection::getConnection();
			try{
				$statement = $connection->prepare("UPDATE TABLE_ORDER SET amount = ? WHERE id = ?");
				$statement->bindParam(1, $amount);
				$statement->bindParam(2, $orderid);
				$statement->execute();
			}
			catch(Exception $e){
			}
		}	

		public static function get24hPrices($pair) {
			$connection = Connection::getConnection();

			/* RIGHT NOW MINUS 24 HOURS */
			$last24h = time() - 86400;

			try{
				$statement = $connection->prepare("SELECT price FROM TABLE_ORDER_HISTORY WHERE status = 'Filled' AND ordertime >= ? AND pair = ? ORDER BY price");
				$statement->bindParam(1, $last24h);
				$statement->bindParam(2, $pair);
				$statement->setFetchMode(PDO::FETCH_ASSOC);
				$statement->execute();
	
				$prices = $statement->fetchAll();
				return $prices;
			}
			catch(Exception $e){
			}
		}

		public static function get24hPrice($pair) {
			$connection = Connection::getConnection();

			/* RIGHT NOW MINUS 24 HOURS */
			$last24h = time() - 86400;

			try{
				$statement = $connection->prepare("SELECT price FROM TABLE_ORDER_HISTORY WHERE status = 'Filled' AND ordertime >= ? AND pair = ? ORDER BY ordertime");
				$statement->bindParam(1, $last24h);
				$statement->bindParam(2, $pair);
				$statement->setFetchMode(PDO::FETCH_ASSOC);
				$statement->execute();
	
				$prices = $statement->fetchAll();
				return $prices;
			}
			catch(Exception $e){
			}
		}
		
		public static function getLastPrice($pair) {
			$connection = Connection::getConnection();
			try{
				$statement = $connection->prepare("SELECT price FROM TABLE_ORDER_HISTORY WHERE status = 'Filled' AND pair = ? ORDER BY ordertime DESC LIMIT 1");
				$statement->bindParam(1, $pair);
				$statement->setFetchMode(PDO::FETCH_ASSOC);
				$statement->execute();
	
				$price = $statement->fetchAll();
				return $price;
			}
			catch(Exception $e){
			}
		}	

	}