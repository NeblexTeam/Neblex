<?php

	class Connection {
		
		private static $connection = null;
		
		public static function getConnection() {
			if (Connection::$connection == null) {
				try{
					$dns = DB_HOST.DB_PORT.DB_NAME.DB_USER.DB_PASS;
					Connection::$connection = new PDO($dns);
					Connection::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					Connection::$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

				}
				catch (PDOException $e){
					// report error message
					echo $e->getMessage();
				}
			}

			return Connection::$connection;
		}
	}