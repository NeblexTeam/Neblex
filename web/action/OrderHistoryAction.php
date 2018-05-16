<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/OrderDAO.php");

	class OrderHistoryAction extends CommonAction {
		public $getOrderHistory;

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_MEMBER, "Order History Neblex" , true);
		}

		protected function executeAction() {
			$this->getOrderHistory = OrderDAO::getOrderHistory($_SESSION["id_user"]);
		}
	}