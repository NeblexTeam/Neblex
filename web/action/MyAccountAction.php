<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/UserDAO.php");
	require_once("action/dao/LastConnectionDAO.php");

	class MyAccountAction extends CommonAction {
		public $connection;

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_MEMBER, "My Neblex Account" , true);
		}

		protected function executeAction() {
			/*Would be cool to set it to each persons own timezone*/
			date_default_timezone_set("America/New_York");

			$this->connection = LastConnectionDAO::getConnection($_SESSION["id_user"]);
		}
	}