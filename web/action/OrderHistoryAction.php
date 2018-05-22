<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/OrderDAO.php");

	class OrderHistoryAction extends CommonAction {
		public $getOrderHistory;
		public $data = array();

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_MEMBER, "Order History Neblex" , true);
		}

		protected function executeAction() {
			$this->getOrderHistory = OrderDAO::getOrderHistory($_SESSION["id_user"]);

			if (isset($_GET['export'])) {
				if(count($this->getOrderHistory) > 0){
					for($i=0; $i<=count($this->getOrderHistory)-1;$i++){
						$data[$i]["Date"] = date("Y-m-d H:i:s", $this->getOrderHistory[$i]["ordertime"]);
						$data[$i]["Pair"] = $this->getOrderHistory[$i]["pair"];
						$data[$i]["Type"] = $this->getOrderHistory[$i]["transactiontype"];
						$data[$i]["Price"] = $this->getOrderHistory[$i]["price"];
						$data[$i]["Amount"] = $this->getOrderHistory[$i]["amount"];
						$data[$i]["Filled"] = number_format($this->getOrderHistory[$i]["amount"]/$this->getOrderHistory[$i]["originalamount"]*100, 2);
						$data[$i]["Total"] = $this->getOrderHistory[$i]["amount"]*$this->getOrderHistory[$i]["price"];
						$data[$i]["Status"] = $this->getOrderHistory[$i]["status"];
					}
					CommonAction::exportOrderHistory($data);
				}
			}
		}
	}