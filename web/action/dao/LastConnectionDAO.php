<?php
	require_once("action/dao/Connection.php");

	class LastConnectionDAO {

		public static function connectionSuccess($dateConnection, $ipConnection, $userId) {
			$connection = Connection::getConnection();
			
			/*REMOVE WHEN THE WEBSITE WILL BE ONLINE,THIS IS FOR THE FACT THAT I CAN'T RETURN MY LOCALHOST IP ADRESS*/
			$ipConnection="127.0.0.1";
			/************************************************************************************************************/
			try{
				$statement = $connection->prepare("SELECT * FROM TABLE_LASTCONNECTION WHERE userid = ?");
				$statement->bindParam(1, $userId);
				$statement->setFetchMode(PDO::FETCH_ASSOC);
				$statement->execute();

				$connectionAmount = $statement->fetchall();

			}
			catch(Exception $e){
				echo $e->getMessage();
			}

			try{
				if(count($connectionAmount) >= 5){
					$statement = $connection->prepare("UPDATE TABLE_LASTCONNECTION SET (dateconnection, ipconnection, connectionattempt, userid) = (?,?, 1,?) WHERE dateconnection = (SELECT MIN(dateconnection) FROM TABLE_LASTCONNECTION WHERE userid = ?)");
					$statement->bindParam(1, $dateConnection);
					$statement->bindParam(2, $ipConnection);
					$statement->bindParam(3, $userId);
					$statement->bindParam(4, $userId);
				}
				else{
					$statement = $connection->prepare("INSERT INTO TABLE_LASTCONNECTION (dateconnection, ipconnection, connectionattempt, userid) VALUES (?,?, 1,?)");
					$statement->bindParam(1, $dateConnection);
					$statement->bindParam(2, $ipConnection);
					$statement->bindParam(3, $userId);
				}			
				$statement->execute();
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}


		public static function connectionFail($dateConnection, $ipConnection, $userId) {
			$connection = Connection::getConnection();
			/*REMOVE WHEN THE WEBSITE WILL BE ONLINE,THIS IS FOR THE FACT THAT I CAN'T RETURN MY LOCALHOST IP ADRESS*/
			$ipConnection="127.0.0.1";
			/************************************************************************************************************/
			try{
				$statement = $connection->prepare("SELECT * FROM TABLE_LASTCONNECTION WHERE userid = ?");
				$statement->bindParam(1, $userId);
				$statement->setFetchMode(PDO::FETCH_ASSOC);
				$statement->execute();

				$connectionAmount = $statement->fetchall();

			}
			catch(Exception $e){
				echo $e->getMessage();
			}

			try{
				if(count($connectionAmount) >= 5){
					$statement = $connection->prepare("UPDATE TABLE_LASTCONNECTION SET (dateconnection, ipconnection, connectionattempt, userid) = (?,?, 0,?) WHERE dateconnection = (SELECT MIN(dateconnection) FROM TABLE_LASTCONNECTION WHERE userid = ?)");
					$statement->bindParam(1, $dateConnection);
					$statement->bindParam(2, $ipConnection);
					$statement->bindParam(3, $userId);
					$statement->bindParam(4, $userId);
				}
				else{
					$statement = $connection->prepare("INSERT INTO TABLE_LASTCONNECTION (dateconnection, ipconnection, connectionattempt, userid) VALUES (?,?, 0,?)");
					$statement->bindParam(1, $dateConnection);
					$statement->bindParam(2, $ipConnection);
					$statement->bindParam(3, $userId);
				}			
				$statement->execute();
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
		public static function getConnection($userId) {
			$connection = Connection::getConnection();
			try{
				$statement = $connection->prepare("SELECT * FROM TABLE_LASTCONNECTION WHERE userid = ?");
				$statement->bindParam(1, $userId);
				$statement->setFetchMode(PDO::FETCH_ASSOC);
				$statement->execute();

				$connection = $statement->fetchall();
			}
			catch(Exception $e){
				echo $e->getMessage();
			}

			return $connection;
		}

		public static function updateConnectionAttempt($userid){
			$connection = Connection::getConnection();
			
			$statement = $connection->prepare("UPDATE TABLE_LASTCONNECTION SET connectionattempt=1 WHERE ID =(SELECT ID FROM TABLE_LASTCONNECTION WHERE userid=? ORDER BY ID LIMIT 1) ");		
			$statement->bindParam(1, $userid);
			$statement->execute();

		}
	}