<?php
	require_once("action/dao/Connection.php");
	require_once("action/dao/ConnectionAPI.php");

	class CoinDAO {

		public static function getCoin(){
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT * FROM TABLE_COIN");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$coin = $statement->fetchall();

			return $coin;
		}

		public static function getCoinById() {
			$connection = Connection::getConnection();
			try{
					/*GENERATE TABLE_BALANCE*/
				$statement = $connection->prepare("SELECT * FROM TABLE_COIN ORDER BY id");
				$statement->setFetchMode(PDO::FETCH_ASSOC);
				$statement->execute();

				$coins = $statement->fetchall();
				return $coins;
			}
			catch(Exception $e){
			}
		}	

		public static function getSpecificCoin($coinId){
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT id FROM TABLE_COIN WHERE ticker = ?");
			$statement->bindParam(1, $coinId);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$coin = $statement->fetch();

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

		public static function getCoinID($ticker){
			$apiInstance = ConnectionAPI::getAPI();

			try {
				$result = $apiInstance->getTokenId($ticker);
				return $result;
			} catch (Exception $e) {
				echo 'Exception when calling NTP1Api->getTokenId: ', $e->getMessage(), PHP_EOL;
			}
		
		}

	}