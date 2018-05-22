<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/OrderDAO.php");
	require_once("action/dao/BalanceDAO.php");

	class OpenOrdersAction extends CommonAction {
		public $getOpenOrders;

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_MEMBER, "Open Orders Neblex" , true);
		}

		protected function executeAction() {
			$this->getOpenOrders = OrderDAO::getOrders($_SESSION["id_user"]);
			for($i = 0; $i <= count($this->getOpenOrders)-1; $i++){
				if(isset($_POST["cancelOrder-$i"])){
					if($_POST["cancelOrder-$i"] === "Cancel-$i"){
						OrderDAO::createOrderHistory(	$this->getOpenOrders[$i]["coinid"], 
														$this->getOpenOrders[$i]["userid"], 
														$this->getOpenOrders[$i]["transactiontype"],
														$this->getOpenOrders[$i]["amount"], 
														$this->getOpenOrders[$i]["price"],
														time(),
														$this->getOpenOrders[$i]["pair"], 
														"Cancelled",  
														$this->getOpenOrders[$i]["originalamount"]);

						OrderDAO::deleteOrder($this->getOpenOrders[$i]["id"]);
						if($this->getOpenOrders[$i]["transactiontype"] === 's'){
							$balance = BalanceDAO::getSpecificBalance($_SESSION["id_user"], $this->getOpenOrders[$i]["coinid"]);
							$amountToken = $this->getOpenOrders[$i]["amount"] + $balance["balance"];
							BalanceDAO::deposit($_SESSION["id_user"], $this->getOpenOrders[$i]["coinid"] , $amountToken);	
						}
						else{
							$amountNebl = $this->getOpenOrders[$i]["amount"] * $this->getOpenOrders[$i]["price"];
							$balance = BalanceDAO::getSpecificBalance($_SESSION["id_user"], 1);
							$amountNebl = $amountNebl + $balance["balance"];
							BalanceDAO::deposit($_SESSION["id_user"], 1, $amountNebl);	
						}	
					}
				}
			}
			$this->getOpenOrders = OrderDAO::getOrders($_SESSION["id_user"]);
		}
	}