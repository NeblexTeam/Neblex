<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/CoinDAO.php");
	require_once("action/dao/BalanceDAO.php");
	require_once("action/dao/OrderDAO.php");

	class ExchangeAction extends CommonAction {
		public $tickerArray = array();
		public $getCoin;
		public $getSpecificCoin;
		public $getSpecificBalance;
		public $getNeblBalance;
		public $getNeblId;

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_PUBLIC, "NTP1 Token Exchange" ,true);
		}

		protected function executeAction() {
			CommonAction::loading();

			$this->getCoin = CoinDAO::getCoin();
			$this->getNeblId = CoinDAO::getSpecificCoin("NEBL");

			if(isset($_GET['token']))
			{
				$this->getSpecificCoin = CoinDAO::getSpecificCoin($_GET['token']);
				$this->getSpecificBalance = BalanceDAO::getSpecificBalance($_SESSION["id_user"], $this->getSpecificCoin["id"]);
				/* NEBL ID WILL ALWAYS BE 1 */
				$this->getNeblBalance = BalanceDAO::getSpecificBalance($_SESSION["id_user"], 1);
			}

			for($i = 0; $i <= count($this->getCoin)-1; $i++){
				array_push($this->tickerArray, $this->getCoin[$i]["ticker"]);
			}
			sort($this->tickerArray);

			if(isset($_POST["buyPrice"]) && isset($_POST["buyQuantity"])){
				if($_POST["actionButton"] === 'BUY'){

					$amountWithdraw = floatval($_POST["buyQuantity"]) * floatval($_POST["buyPrice"]);
					$amountWithdraw = floatval($this->getNeblBalance["balance"]) - $amountWithdraw;
					BalanceDAO::withdraw($_SESSION["id_user"],$this->getNeblId["id"] , $amountWithdraw);

					$date = time();

					OrderDAO::createOrder($this->getSpecificCoin["id"] , $_SESSION["id_user"], "b", $_POST["buyQuantity"], $_POST["buyPrice"], $date, $_GET['token']);
					$orderid = OrderDAO::getOrderId($this->getSpecificCoin["id"] , $_SESSION["id_user"], "b", $_POST["buyQuantity"], $_POST["buyPrice"], $date, $_GET['token']);
					OrderDAO::createOrderHistory($this->getSpecificCoin["id"], $_SESSION["id_user"], "b",  $_POST["buyQuantity"], $_POST["buyPrice"], $orderid, $date, $_GET['token'], "OnGoing");

					$this->getNeblBalance = BalanceDAO::getSpecificBalance($_SESSION["id_user"], 1);
				}
			}
			if(isset($_POST["sellPrice"]) && isset($_POST["sellQuantity"])){
				if($_POST["actionButton"] === 'SELL'){
					$amountWithdraw = floatval($_POST["sellQuantity"]);
					$amountWithdraw = floatval($this->getSpecificBalance["balance"]) - $amountWithdraw;
					BalanceDAO::withdraw($_SESSION["id_user"], $this->getSpecificCoin["id"] , $amountWithdraw);

					$date = time();

					OrderDAO::createOrder($this->getSpecificCoin["id"] , $_SESSION["id_user"], "s", $_POST["sellQuantity"], $_POST["sellPrice"], $date, $_GET['token']);
					$orderid = OrderDAO::getOrderId($this->getSpecificCoin["id"] , $_SESSION["id_user"], "s", $_POST["sellQuantity"], $_POST["sellPrice"], $date, $_GET['token']);
					OrderDAO::createOrderHistory($this->getSpecificCoin["id"], $_SESSION["id_user"], "s",  $_POST["sellQuantity"], $_POST["sellPrice"], $orderid, $date, $_GET['token'], "OnGoing");

					$this->getSpecificBalance = BalanceDAO::getSpecificBalance($_SESSION["id_user"], $this->getSpecificCoin["id"]);
				}
			}
		}
	}