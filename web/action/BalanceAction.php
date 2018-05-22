<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/CoinDAO.php");
	require_once("action/dao/BalanceDAO.php");
	require_once("action/dao/OrderDAO.php");

	class BalanceAction extends CommonAction {
		public $getCoin;
		public $getBalance;
		public $totalNebl = 0;
		public $price;
		public $getLastPrice;
		public $getInOrder;

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_MEMBER, "Balance Neblex", true);
		}

		protected function executeAction() {
			CommonAction::loading();
			$this->getCoin = CoinDAO::getCoin();
			$this->getBalance = BalanceDAO::getBalance($_SESSION["id_user"]);

			for ($row = 0; $row <=  count($this->getCoin)-1; $row++) { 
				$this->getLastPrice[$this->getCoin[$row]["ticker"]] = OrderDAO::getLastPrice($this->getCoin[$row]["ticker"]);

					if (isset($_POST["amountDeposit-".$this->getCoin[$row]["id"]])) {
						if($_POST["amountDeposit-".$this->getCoin[$row]["id"]] < 1000000){
							$amountDeposit = floatval($_POST["amountDeposit-".$this->getCoin[$row]["id"]]);
							$amountDeposit = floatval($this->getBalance[$row]["balance"]) + $amountDeposit;
							BalanceDAO::deposit($_SESSION["id_user"], $this->getCoin[$row]["id"] , $amountDeposit);
						}
					}
					if (isset($_POST["amountWithdraw-".$this->getCoin[$row]["id"]])) {
						/* server double check if user really have this amount of money */
						$getSpecificBalance = BalanceDAO::getSpecificBalance($_SESSION["id_user"], $this->getCoin[$row]["id"]);
						if($_POST["amountWithdraw-".$this->getCoin[$row]["id"]] < $getSpecificBalance["balance"]){
							$amountWithdraw = floatval($_POST["amountWithdraw-".$this->getCoin[$row]["id"]]);
							$amountWithdraw = floatval($this->getBalance[$row]["balance"]) - $amountWithdraw;
							BalanceDAO::withdraw($_SESSION["id_user"], $this->getCoin[$row]["id"] , $amountWithdraw);
						}
					}
					if (isset($_POST["amountDeposit-".$this->getCoin[$row]["id"]]) || isset($_POST["amountWithdraw-".$this->getCoin[$row]["id"]])) {
						$this->getCoin = CoinDAO::getCoin();
						$this->getBalance = BalanceDAO::getBalance($_SESSION["id_user"]);
					}
					$getInOrderBuy[$this->getCoin[$row]["ticker"]] = OrderDAO::getOrdersFromPair("b", $this->getCoin[$row]["ticker"]);
					if(!empty($getInOrderBuy[$this->getCoin[$row]["ticker"]]))
					{
						for($i = 0; $i<=count($getInOrderBuy[$this->getCoin[$row]["ticker"]])-1; $i++ ){
							if(!empty($this->getInOrder["NEBL"])){
								$this->getInOrder["NEBL"] = floatval($this->getInOrder["NEBL"]) + (floatval($getInOrderBuy[$this->getCoin[$row]["ticker"]][$i]["amount"]) * floatval($getInOrderBuy[$this->getCoin[$row]["ticker"]][$i]["price"]) );
							}
							else{
								$this->getInOrder["NEBL"] = floatval($getInOrderBuy[$this->getCoin[$row]["ticker"]][$i]["amount"]) * floatval($getInOrderBuy[$this->getCoin[$row]["ticker"]][$i]["price"]);
							}

						}
					}
					$getInOrderSell[$this->getCoin[$row]["ticker"]] = OrderDAO::getOrdersFromPair("s", $this->getCoin[$row]["ticker"]);
					if(!empty($getInOrderSell[$this->getCoin[$row]["ticker"]]))
					{
						for($i = 0; $i<=count($getInOrderSell[$this->getCoin[$row]["ticker"]])-1; $i++ ){
							if(!empty($this->getInOrder[$this->getCoin[$row]["ticker"]])){
								$this->getInOrder[$this->getCoin[$row]["ticker"]] = floatval($this->getInOrder[$this->getCoin[$row]["ticker"]]) + floatval($getInOrderSell[$this->getCoin[$row]["ticker"]][$i]["amount"]);
							}
							else
							{
								$this->getInOrder[$this->getCoin[$row]["ticker"]] = floatval($getInOrderSell[$this->getCoin[$row]["ticker"]][$i]["amount"]);
							}
						}
					}
					else{
						$this->getInOrder[$this->getCoin[$row]["ticker"]] = 0;
					}
					if(!empty($this->getLastPrice[$this->getCoin[$row]["ticker"]]))
					{
						$this->totalNebl = $this->totalNebl + floatval(($this->getBalance[$row]["balance"])+$this->getInOrder[$this->getCoin[$row]["ticker"]])*floatval($this->getLastPrice[$this->getCoin[$row]["ticker"]][0]["price"]);
					}
			}
			$this->totalNebl = $this->totalNebl + floatval($this->getBalance[0]["balance"]) + $this->getInOrder["NEBL"];
			/* GET NEBLIO CURRENT PRICE ACCORDING TO CRYPTOCOMPARE API'S */
			$getApi = file_get_contents('https://min-api.cryptocompare.com/data/price?fsym=NEBL&tsyms=USD');
			$data = json_decode($getApi, TRUE); //decodes in associative array
			$this->price = $data["USD"];

		}
		

	}