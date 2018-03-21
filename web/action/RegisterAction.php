<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/UserDAO.php");

	class RegisterAction extends CommonAction {
		public $wrongRegister = false;
		public $confirmationSent = false;
		public $samePassword = true;

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_PUBLIC, "Register");
		}

		protected function executeAction() {

			if(isset($_POST["registerEmail"]) && isset($_POST["registerPassword"]) && isset($_POST["confirmationPassword"]) && isset($_POST["agreement"])){
				if($_POST["confirmationPassword"] === $_POST["registerPassword"]){
					if (isset($_POST["registerPassword"])) {

						$token = CommonAction::generateRandomString();
						$passwordHash = password_hash(($_POST["registerPassword"]), PASSWORD_BCRYPT);

						UserDAO::createAccount($_POST["registerEmail"]
											, $passwordHash);
						if($_SESSION["creationSuccess"] === true){
							UserDAO::giveToken($token, $_POST["registerEmail"], true);
							CommonAction::mailconfirmation($_POST["registerEmail"], $token);	
							$this->confirmationSent = true;
						}
						else{
							$this->wrongRegister = true;
						}
					}
				}
				else
				{
					$this->samePassword = false;
				}
			}	
		}
	}