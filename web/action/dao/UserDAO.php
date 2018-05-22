<?php
	require_once("action/dao/Connection.php");

	class UserDAO {

		public static function authenticate($username, $password) {
			
			$visibility = 0;
			$connection = Connection::getConnection();
			
			$usernameLower = strtolower($username);
			$statementGetInfo = $connection->prepare("SELECT password, tokenconfirmation FROM TABLE_USER WHERE email = ?");
			$statementGetInfo ->bindParam(1, $usernameLower);
			$statementGetInfo ->setFetchMode(PDO::FETCH_ASSOC);
			$statementGetInfo ->execute();

			$info = $statementGetInfo->fetch();

			if($info["tokenconfirmation"] === null)
			{
				if(password_verify($password, $info["password"])){			
					$statement = $connection->prepare("SELECT * FROM TABLE_USER WHERE email = ? AND password = ?");
					$statement->bindParam(1, $usernameLower);
					$statement->bindParam(2, $info["password"]);
					$statement->setFetchMode(PDO::FETCH_ASSOC);
					$statement->execute();

					$user = $statement->fetch();

					if ($user) {
						$_SESSION["id_user"] = $user["id"];
						$_SESSION["email_user"] = $user["email"];
						$visibility = 1;
					}
				}
			}
			else
			{
				$visibility = -1;
			}

			return $visibility;
		}

		public static function accountActivation($newTokenValue, $token){
			$connection = Connection::getConnection();

			$statement = $connection->prepare("UPDATE TABLE_USER SET tokenconfirmation=? WHERE tokenconfirmation = ?");		
			$statement->bindParam(1, $newTokenValue);
			$statement->bindParam(2, $token);
			$statement->execute();
		}

		public static function createAccount($email, $password) {
			$visibility = 0;
			$connection = Connection::getConnection();
			$emailLower = strtolower($email);
			try{
				$statement = $connection->prepare("INSERT INTO TABLE_USER (email, password) VALUES (?,?)");
				$statement->bindParam(1, $emailLower);
				$statement->bindParam(2, $password);
				$statement->execute();
				$_SESSION["creationSuccess"] = true;

				$statementID = $connection->prepare("SELECT id FROM TABLE_USER WHERE email = ?");
				$statementID->bindParam(1, $emailLower);
				$statementID->setFetchMode(PDO::FETCH_ASSOC);
				$statementID->execute();

				$userid = $statementID->fetch();

				return $userid;

			}
			catch(Exception $e){
				$_SESSION["creationSuccess"] = false;
			}
		}	


		public static function modifyAccount($privatekey, $id) {
			$connection = Connection::getConnection();
			
			$statement = $connection->prepare("UPDATE TABLE_USER SET privatekey = ? WHERE ID=?");
			$statement->bindParam(1, $privatekey);
			$statement->bindParam(2, $id);
			$statement->execute();

		}	

		public static function findEmail($email){
			$usernameLower = strtolower($email);	
			$connection = Connection::getConnection();		
			$statement = $connection->prepare("SELECT id FROM TABLE_USER WHERE email = ?");
			$statement->bindParam(1, $usernameLower);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$user = $statement->fetch();
			if($user == null)
			{
				$user = -1;
			}
			return $user;
		}

		public static function giveToken($token, $email, $confirmation){
			$connection = Connection::getConnection();
			if($confirmation === true){
				$statement = $connection->prepare("UPDATE TABLE_USER SET tokenconfirmation=? WHERE email = ?");
			}
			else{
				$statement = $connection->prepare("UPDATE TABLE_USER SET tokenreset=? WHERE email = ?");
			}
			$statement->bindParam(1, $token);
			$statement->bindParam(2, $email);
			$statement->execute();
		}

		public static function getToken($email){
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT tokenreset FROM TABLE_USER WHERE email = ?");
			$statement->bindParam(1, $email);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$token = $statement->fetch();

			return $token;
		}

		public static function getEmail($token){
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT email FROM TABLE_USER WHERE tokenreset = ?");
			$statement->bindParam(1, $token);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$email = $statement->fetch();

			return $email;
		}

		public static function resetPassword($email, $password) {
			$connection = Connection::getConnection();
			$statement = $connection->prepare("UPDATE TABLE_USER SET password = ? WHERE email=?");
			$statement->bindParam(1, $password);
			$statement->bindParam(2, $email["email"]);
			$statement->execute();
		}	
	}