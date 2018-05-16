<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/OrderDAO.php");

	class OpenOrdersAction extends CommonAction {
		public $getOpenOrders;

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_MEMBER, "Open Orders Neblex" , true);
		}

		protected function executeAction() {
			$this->getOpenOrders = OrderDAO::getOrders($_SESSION["id_user"]);
		}
	}