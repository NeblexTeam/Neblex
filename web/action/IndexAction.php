<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/UserDAO.php");
	require_once("action/dao/CoinDAO.php");

	class IndexAction extends CommonAction {
		public $coin;

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_PUBLIC, "NTP1 Token Exchange" ,true);
		}

		protected function executeAction() {
			$this->coin = CoinDAO::getCoin();
		}
	}