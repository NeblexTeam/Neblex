<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/UserDAO.php");

	class BalanceAction extends CommonAction {

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_PUBLIC, "Balance Neblex", true);
		}

		protected function executeAction() {

		}
	}