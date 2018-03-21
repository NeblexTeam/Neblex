<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/UserDAO.php");

	class OrderHistoryAction extends CommonAction {

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_MEMBER, "Order History Neblex" , true);
		}

		protected function executeAction() {

		}
	}