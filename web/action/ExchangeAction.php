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
		public $getOrderFromPairBuy;
		public $getOrderFromPairSell;

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
				if(isset($_SESSION["id_user"]))
				{
					$this->getSpecificBalance = BalanceDAO::getSpecificBalance($_SESSION["id_user"], $this->getSpecificCoin["id"]);
					/* NEBL ID WILL ALWAYS BE 1 */
					$this->getNeblBalance = BalanceDAO::getSpecificBalance($_SESSION["id_user"], 1);
				}
			}

			for($i = 0; $i <= count($this->getCoin)-1; $i++){
				array_push($this->tickerArray, $this->getCoin[$i]["ticker"]);
			}
			sort($this->tickerArray);

			if(isset($_POST["buyPrice"]) && isset($_POST["buyQuantity"])){
				if($_POST["actionButton"] === 'BUY'){

					$amountWithdraw = floatval($_POST["buyQuantity"]) * floatval($_POST["buyPrice"]);
					$amountWithdraw = floatval($this->getNeblBalance["balance"]) - $amountWithdraw;
					/* server double check if user really have this amount of money */
					if($amountWithdraw > 0){
						BalanceDAO::withdraw($_SESSION["id_user"],$this->getNeblId["id"] , $amountWithdraw);
						
						$date = time();
						OrderDAO::createOrder($this->getSpecificCoin["id"] , $_SESSION["id_user"], "b", $_POST["buyQuantity"], $_POST["buyPrice"], $date, $_GET['token'], $_POST["buyQuantity"]);
						$orderid = OrderDAO::getOrderId($this->getSpecificCoin["id"] , $_SESSION["id_user"], "b", $_POST["buyQuantity"], $_POST["buyPrice"], $date, $_GET['token']);
						/* LOOKING FOR ORDER THAT CAN BE PROCESSED */
						$orderReady = OrderDAO::getOrdersFromPair("s", $_GET['token']);
						for($i = 0; $i <= count($orderReady)-1; $i++){
							if($orderReady[$i]["price"] <= $_POST["buyPrice"]){
								//print_r($orderReady);
								if($i === 0){
									$amount = $amount = floatval($orderReady[$i]["amount"]) - floatval($_POST["buyQuantity"]);
								}
								else{
									$amount = $amountleft;
								}
								if($amount > 0)
								{
									/* UPDATING CURRENT ORDER */
									//print_r("--1--");
									OrderDAO::deleteOrder($orderid);
									/* UPDATING ORDER THAT ARE BEING PROCESSED */
									$amountleft = $orderReady[$i]["amount"] - $amount;
									OrderDAO::updateOrder($amountleft, $orderReady[$i]["id"]);
									/* CREATING ORDER HISTORY AND REMOVE FILLED ORDER */
									OrderDAO::createOrderHistory(	$orderReady[$i]["coinid"], 
																	$orderReady[$i]["userid"], 
																	"b",
																	$amount, 
																	$orderReady[$i]["price"],
																	$date,
																	$orderReady[$i]["pair"], 
																	"Filled",  
																	$orderReady[$i]["originalamount"]);

									/* DEPOSIT NEBL INTO SELLER ACCOUNT */
									$amountNebl = $amount * $orderReady[$i]["price"];
									$balance = BalanceDAO::getSpecificBalance($orderReady[$i]["userid"], 1);
									$amountNebl = $amountNebl + $balance["balance"];
									BalanceDAO::deposit($orderReady[$i]["userid"], 1, $amountNebl);		
									
									/* DEPOSIT TOKEN INTO BUYER ACCOUNT */
									$balance = BalanceDAO::getSpecificBalance($_SESSION["id_user"], $orderReady[$i]["coinid"]);
									$amountToken = $amount + $balance["balance"];
									BalanceDAO::deposit($_SESSION["id_user"], $orderReady[$i]["coinid"], $amountToken);	
								}
								else{
									$amountleft = 0 - $amount;
									/* UPDATING CURRENT ORDER */
									OrderDAO::updateOrder($amountleft, $orderid);
									
									/* UPDATING ORDER THAT ARE BEING PROCESSED */
									if($amountleft == 0){
										//print_r($orderid);
										$order = OrderDAO::getOrderFromId($orderid);
										//print_r($order);
										OrderDAO::createOrderHistory(	$order[0]["coinid"], 
																		$order[0]["userid"], 
																		"b",
																		$order[0]["originalamount"], 
																		$order[0]["price"],
																		$date,
																		$order[0]["pair"], 
																		"Filled",  
																		$order[0]["originalamount"]);
										//print_r("--2--");
										OrderDAO::deleteOrder($orderid);
									}
									if($amountleft != 0){
										OrderDAO::updateOrder($amountleft, $orderReady[$i]["id"]);
									}
									//print_r("--3--");
									OrderDAO::deleteOrder($orderReady[$i]["id"]);

									/* CREATING ORDER HISTORY AND REMOVE FILLED ORDER */
									OrderDAO::createOrderHistory(	$orderReady[$i]["coinid"], 
																	$orderReady[$i]["userid"], 
																	"s",
																	$orderReady[$i]["originalamount"], 
																	$orderReady[$i]["price"],
																	$date,
																	$orderReady[$i]["pair"], 
																	"Filled",  
																	$orderReady[$i]["originalamount"]);
									/* DEPOSIT NEBL INTO SELLER ACCOUNT */
									$amountNebl = $orderReady[$i]["amount"] * $orderReady[$i]["price"];
									$balance = BalanceDAO::getSpecificBalance($orderReady[$i]["userid"], 1);
									$amountNebl = $amountNebl + $balance["balance"];
									BalanceDAO::deposit($orderReady[$i]["userid"], 1, $amountNebl);		
									
									/* DEPOSIT TOKEN INTO BUYER ACCOUNT */
									$balance = BalanceDAO::getSpecificBalance($_SESSION["id_user"], $orderReady[$i]["coinid"]);
									$amountToken = $orderReady[$i]["amount"] + $balance["balance"];
									BalanceDAO::deposit($_SESSION["id_user"], $orderReady[$i]["coinid"], $amountToken);	
								}
							}
						}
					}
				}
			}
			if(isset($_POST["sellPrice"]) && isset($_POST["sellQuantity"])){
				if($_POST["actionButton"] === 'SELL'){
					$amountWithdraw = floatval($_POST["sellQuantity"]);
					$amountWithdraw = floatval($this->getSpecificBalance["balance"]) - $amountWithdraw;
					/* server double check if user really have this amount of money */
					if($amountWithdraw > 0){
						BalanceDAO::withdraw($_SESSION["id_user"], $this->getSpecificCoin["id"] , $amountWithdraw);

						$date = time();
						OrderDAO::createOrder($this->getSpecificCoin["id"] , $_SESSION["id_user"], "s", $_POST["sellQuantity"], $_POST["sellPrice"], $date, $_GET['token'], $_POST["sellQuantity"]);
						$orderid = OrderDAO::getOrderId($this->getSpecificCoin["id"] , $_SESSION["id_user"], "s", $_POST["sellQuantity"], $_POST["sellPrice"], $date, $_GET['token']);
						//print_r($orderid);
						/* LOOKING FOR ORDER THAT CAN BE PROCESSED */
						$orderReady = OrderDAO::getOrdersFromPair("b", $_GET['token']);
						for($i = 0; $i <= count($orderReady)-1; $i++){
							if($orderReady[$i]["price"] >= $_POST["sellPrice"]){
								//print_r($orderReady);
								if($i === 0){
									$amount = floatval($orderReady[$i]["amount"]) - floatval($_POST["sellQuantity"]);
								}
								else{
									/* UNDEFINED VARIABLE */
									$amount = $amountleft;
								}
								if($amount > 0)
								{
									//print_r("--4--");
									/* UPDATING CURRENT ORDER */
									OrderDAO::deleteOrder($orderid);
									/* UPDATING ORDER THAT ARE BEING PROCESSED */
									$amountleft = $orderReady[$i]["amount"] - $amount;
									OrderDAO::updateOrder($amountleft, $orderReady[$i]["id"]);
									/* CREATING ORDER HISTORY AND REMOVE FILLED ORDER */
									//print_r( $orderReady[$i]);
									OrderDAO::createOrderHistory(	$orderReady[$i]["coinid"], 
																	$orderReady[$i]["userid"], 
																	"s",
																	$amount, 
																	$orderReady[$i]["price"],
																	$date,
																	$orderReady[$i]["pair"], 
																	"Filled",  
																	$orderReady[$i]["originalamount"]);

									/* DEPOSIT NEBL INTO SELLER ACCOUNT */
									$amountNebl = $amount * $orderReady[$i]["price"];
									$balance = BalanceDAO::getSpecificBalance($_SESSION["id_user"], 1);
									$amountNebl = $amountNebl + $balance["balance"];
									BalanceDAO::deposit($_SESSION["id_user"], 1, $amountNebl);		
									
									/* DEPOSIT TOKEN INTO BUYER ACCOUNT */
									$balance = BalanceDAO::getSpecificBalance($orderReady[$i]["userid"], $orderReady[$i]["coinid"]);
									$amountToken = $amount + $balance["balance"];
									BalanceDAO::deposit($orderReady[$i]["userid"], $orderReady[$i]["coinid"], $amountToken);	
								}
								else{
									$amountleft = 0 - $amount;
									/* UPDATING CURRENT ORDER */
									OrderDAO::updateOrder($amountleft, $orderid);
									
									/* UPDATING ORDER THAT ARE BEING PROCESSED */
									if($amountleft == 0){
										//print_r($orderid);
										$order = OrderDAO::getOrderFromId($orderid);
										//print_r($order);
										OrderDAO::createOrderHistory(	$order[0]["coinid"], 
																		$order[0]["userid"], 
																		"s",
																		$order[0]["originalamount"], 
																		$order[0]["price"],
																		$date,
																		$order[0]["pair"], 
																		"Filled",  
																		$order[0]["originalamount"]);
										//print_r("--5--");
										OrderDAO::deleteOrder($orderid);
									}
									if($amountleft != 0){
										OrderDAO::updateOrder($amountleft, $orderReady[$i]["id"]);
									}
									//print_r("--6--");
									OrderDAO::deleteOrder($orderReady[$i]["id"]);

									/* CREATING ORDER HISTORY AND REMOVE FILLED ORDER */
									OrderDAO::createOrderHistory(	$orderReady[$i]["coinid"], 
																	$orderReady[$i]["userid"], 
																	"b",
																	$orderReady[$i]["originalamount"], 
																	$orderReady[$i]["price"],
																	$date,
																	$orderReady[$i]["pair"], 
																	"Filled",  
																	$orderReady[$i]["originalamount"]);
									/* DEPOSIT NEBL INTO SELLER ACCOUNT */
									$amountNebl = $orderReady[$i]["amount"] * $orderReady[$i]["price"];
									$balance = BalanceDAO::getSpecificBalance($_SESSION["id_user"], 1);
									$amountNebl = $amountNebl + $balance["balance"];
									BalanceDAO::deposit($_SESSION["id_user"], 1, $amountNebl);		
									
									/* DEPOSIT TOKEN INTO BUYER ACCOUNT */
									$balance = BalanceDAO::getSpecificBalance($orderReady[$i]["userid"], $orderReady[$i]["coinid"]);
									$amountToken = $orderReady[$i]["amount"] + $balance["balance"];
									BalanceDAO::deposit($orderReady[$i]["userid"], $orderReady[$i]["coinid"], $amountToken);	
								}
							}
						}
					}
				}
			}
			if(isset($_SESSION["id_user"])){
				$this->getSpecificBalance = BalanceDAO::getSpecificBalance($_SESSION["id_user"], $this->getSpecificCoin["id"]);
				$this->getNeblBalance = BalanceDAO::getSpecificBalance($_SESSION["id_user"], 1);
			}
			if(isset($_GET["token"]))
			{
				$this->getOrderFromPairBuy = OrderDAO::getOrdersFromPair("b", $_GET["token"]);
				$this->getOrderFromPairSell = OrderDAO::getOrdersFromPair("s", $_GET["token"]);
			}
		}
	}