<?php
	require_once("action/dao/Connection.php");

	class BalanceDAO {
		public static function generateBalance($userid) {
			$connection = Connection::getConnection();
			try{
					/*GENERATE TABLE_BALANCE*/
				$statement = $connection->prepare("SELECT * FROM TABLE_COIN");
				$statement->setFetchMode(PDO::FETCH_ASSOC);
				$statement->execute();

				$coin = $statement->fetchall();
				for ($row = 0; $row <=  count($coin)-1; $row++){
					$statement = $connection->prepare("INSERT INTO TABLE_BALANCE (userid, coinid) VALUES (?,?)");
					$statement->bindParam(1, $userid["id"]);
					$statement->bindParam(2, $coin[$row]["id"]);
					$statement->execute();
				}
			}
			catch(Exception $e){
			}
		}	

		public static function getBalance($userid) {
			$connection = Connection::getConnection();
			try{
					/*GENERATE TABLE_BALANCE*/
				$statement = $connection->prepare("SELECT * FROM TABLE_BALANCE WHERE userid = ? ORDER BY coinid");
				$statement->bindParam(1, $userid);
				$statement->setFetchMode(PDO::FETCH_ASSOC);
				$statement->execute();

				$balance = $statement->fetchall();
				return $balance;
			}
			catch(Exception $e){
			}
		}	

		public static function getSpecificBalance($userid, $coinid) {
			$connection = Connection::getConnection();
			try{
					/*GENERATE TABLE_BALANCE*/
				$statement = $connection->prepare("SELECT balance FROM TABLE_BALANCE WHERE userid = ? AND coinid = ?");
				$statement->bindParam(1, $userid);
				$statement->bindParam(2, $coinid);
				$statement->setFetchMode(PDO::FETCH_ASSOC);
				$statement->execute();

				$balance = $statement->fetch();
				return $balance;
			}
			catch(Exception $e){
			}
		}	

		/* SOMEWHAT CAN'T REMEMBER MORE THEN 15 DIGIT, NEED TO LOOK IT UP*/
		public static function deposit($userid, $coinid , $amount) {
			$connection = Connection::getConnection();
			try{
				$statement = $connection->prepare("UPDATE TABLE_BALANCE SET balance = ? WHERE userid = ? AND coinid = ?");
				$statement->bindParam(1, $amount);
				$statement->bindParam(2, $userid);
				$statement->bindParam(3, $coinid);
				$statement->execute();
			}
			catch(Exception $e){
				echo $e;
			}
		}	

		public static function withdraw($userid, $coinid , $amount) {
			$connection = Connection::getConnection();

			try{
				$statement = $connection->prepare("UPDATE TABLE_BALANCE SET balance = ? WHERE userid = ? AND coinid = ?");
				$statement->bindParam(1, $amount);
				$statement->bindParam(2, $userid);
				$statement->bindParam(3, $coinid);
				$statement->execute();
			}
			catch(Exception $e){
				echo $e;
			}
		}		

	}