<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/CoinDAO.php");
	require_once("action/dao/BalanceDAO.php");

	class BalanceAction extends CommonAction {
		public $getCoin;
		public $getBalance;
		public $totalNebl = 0;
		public $price;

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_MEMBER, "Balance Neblex", true);
		}

		protected function executeAction() {
			CommonAction::loading();
			$this->getCoin = CoinDAO::getCoin();
			$this->getBalance = BalanceDAO::getBalance($_SESSION["id_user"]);

			// /* SORTING MULTIDIMENSIONAL ARRAY */
			// I'll sort in javascript later to sort the complete <tr></tr> instead of the inside value
			// usort($this->getCoin, function($a, $b){ return strcmp($a["name"], $b["name"]); }); 
			// print_r($this->getCoin);


			for ($row = 0; $row <=  count($this->getCoin)-1; $row++) { 
					if (isset($_POST["amountDeposit-".$this->getCoin[$row]["id"]])) {
						$amountDeposit = floatval($_POST["amountDeposit-".$this->getCoin[$row]["id"]]);
						$amountDeposit = floatval($this->getBalance[$row]["balance"]) + $amountDeposit;
						BalanceDAO::deposit($_SESSION["id_user"], $this->getCoin[$row]["id"] , $amountDeposit);
					}
					if (isset($_POST["amountWithdraw-".$this->getCoin[$row]["id"]])) {
						$amountWithdraw = floatval($_POST["amountWithdraw-".$this->getCoin[$row]["id"]]);
						$amountWithdraw = floatval($this->getBalance[$row]["balance"]) - $amountWithdraw;
						BalanceDAO::withdraw($_SESSION["id_user"], $this->getCoin[$row]["id"] , $amountWithdraw);
					}
					if (isset($_POST["amountDeposit-".$this->getCoin[$row]["id"]]) || isset($_POST["amountWithdraw-".$this->getCoin[$row]["id"]])) {
						$this->getCoin = CoinDAO::getCoin();
						$this->getBalance = BalanceDAO::getBalance($_SESSION["id_user"]);
					}
					$this->totalNebl = $this->totalNebl + $this->getBalance[$row]["balance"];
			}

			/* GET NEBLIO CURRENT PRICE ACCORDING TO CRYPTOCOMPARE API'S */
			$getApi = file_get_contents('https://min-api.cryptocompare.com/data/price?fsym=NEBL&tsyms=USD');
			$data = json_decode($getApi, TRUE); //decodes in associative array
			$this->price = $data["USD"];

		}
		

	}