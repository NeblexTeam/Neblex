<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/UserDAO.php");
	require_once("action/dao/CoinDAO.php");

	class IndexAction extends CommonAction {
		public $coin;
		//public $coinArray = array();
		//public $tickerArray = array();
		public $getCoin;

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_PUBLIC, "NTP1 Token Exchange" ,true);
		}

		protected function executeAction() {
			//CommonAction::loading();
			$this->getCoin = CoinDAO::getCoin();
			//print_r($this->getCoin);
			// for($i = 0; $i <= count($this->getCoin)-1; $i++){
			// 	$this->coin = CoinDAO::getCoinID($this->getCoin[$i]["ticker"]);
			// 	array_push($this->coinArray, $this->coin);
			// 	array_push($this->tickerArray, $this->getCoin[$i]["ticker"]);
			// }
		}
	}

