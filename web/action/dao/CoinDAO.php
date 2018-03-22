<?php
	require_once("action/dao/Connection.php");

	class CoinDAO {

		public static function getCoin(){
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT * FROM TABLE_COIN");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$coin = $statement->fetchall();

			return $coin;
		}

		public static function createCoin($name, $ticker) {
			$connection = Connection::getConnection();
			$nameUpper = strtoupper($name);
			$tickerUpper = strtoupper($ticker);
			try{
				$statement = $connection->prepare("INSERT INTO TABLE_COIN (name, ticker) VALUES (?,?)");
				$statement->bindParam(1, $namerUpper);
				$statement->bindParam(2, $tickerUpper);
				$statement->execute();
			}
			catch(Exception $e){
			}
		}	

	}