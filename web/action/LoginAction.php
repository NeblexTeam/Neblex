<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/UserDAO.php");
	require_once("action/dao/LastConnectionDAO.php");

	class LoginAction extends CommonAction {
		public $wrongLogin = false;
		public $emailConfirm = true;
		public $tooManyConnections = false;
	
		public function __construct() {
			parent::__construct(parent::$VISIBILITY_PUBLIC, "Login Neblex");
		}

		protected function executeAction() {

			if ($_SESSION["visibility"] > 0) {
				header("location:index");
				exit;
			}
			
			//Activate account
			if(isset($_GET['token'])) {
				UserDao::accountActivation(null,$_GET['token']);
			}

			if (isset($_POST["loginEmail"]) && isset($_POST["loginPassword"])) {
				$userid = UserDAO::findEmail($_POST["loginEmail"]);
				$connectionAttempt = 0;
				if($userid["id"] > -1){
					$connection = LastConnectionDAO::getConnection($userid["id"]);
					for($i=0;$i<=count($connection)-1;$i++){
						if($connection[$i]["connectionattempt"] === 0){
							$connectionAttempt += 1;
						}
						if($connectionAttempt === 5 && ($connection[$i]["dateconnection"]+120) < time()){
							LastConnectionDAO::updateConnectionAttempt($userid["id"]);
						}
					}
				}
				if($connectionAttempt < 5){
					$visibility = UserDAO::authenticate($_POST["loginEmail"], $_POST["loginPassword"]);

					if ($visibility === 1) {
						LastConnectionDAO::connectionSuccess(	
																time(), 
																CommonAction::getIp(),
																$_SESSION["id_user"]
															);
						$_SESSION["visibility"] = $visibility;
							
						header("location:index");
						exit;
					}
					else if($visibility === 0){
						if($userid > -1){
							LastConnectionDAO::connectionFail(
																time(), 
																CommonAction::getIp(), 
																$userid["id"]
															);	
						}
						$this->wrongLogin = true;
					}
					else if($visibility === -1){
						$this->emailConfirm = false;
					}
				}
				else{
					$this->tooManyConnections = true;
				}
			}
		}
	}
