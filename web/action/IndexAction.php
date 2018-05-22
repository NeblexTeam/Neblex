<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/CoinDAO.php");
	require_once("action/dao/OrderDAO.php");

	class IndexAction extends CommonAction {
		public $coin;
		//public $coinArray = array();
		//public $tickerArray = array();
		public $getCoin;
		public $getLastPrice;
		public $getLast24hPrices = array();
		public $get24hPrice;

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_PUBLIC, "NTP1 Token Exchange" ,true);
		}

		protected function executeAction() {
			//CommonAction::loading();
			$this->getCoin = CoinDAO::getCoin();
			/* FOR USING NEBLIO API */
			//print_r($this->getCoin);
			// for($i = 0; $i <= count($this->getCoin)-1; $i++){
			// 	$this->coin = CoinDAO::getCoinID($this->getCoin[$i]["ticker"]);
			// 	array_push($this->coinArray, $this->coin);
			// 	array_push($this->tickerArray, $this->getCoin[$i]["ticker"]);
			// }
			for($i = 0; $i <= count($this->getCoin)-1; $i++){
				$this->getLast24hPrices[$this->getCoin[$i]["ticker"]] = OrderDAO::get24hPrices($this->getCoin[$i]["ticker"]);
				$this->get24hPrice[$this->getCoin[$i]["ticker"]] = OrderDAO::get24hPrice($this->getCoin[$i]["ticker"]);
				$this->getLastPrice[$this->getCoin[$i]["ticker"]] = OrderDAO::getLastPrice($this->getCoin[$i]["ticker"]);
			}

		}
	}

