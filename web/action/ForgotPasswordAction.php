<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/UserDAO.php");

	class ForgotPasswordAction extends CommonAction {
		public $validEmail = false;

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_PUBLIC, "Reset Password Neblex");
		}

		protected function executeAction() {
			
			if (isset($_POST["resetEmail"])) {
				$this->validEmail = UserDAO::findEmail($_POST["resetEmail"]);

				if($this->validEmail > -1){
					UserDAO::giveToken(CommonAction::generateRandomString(), $email, false);
					CommonAction::mailresetlink($_POST["resetEmail"], UserDAO::getToken($_POST["resetEmail"]));			
				}
			}					
		}			
	}