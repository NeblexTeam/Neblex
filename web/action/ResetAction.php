<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/UserDAO.php");

	class ResetAction extends CommonAction {
		public $token;
		public $passwordConfirmation = true;
		public $passwordResetFail = false;
		public $passwordReseted = false;

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_PUBLIC, "Reset Password Neblex");
		}

		protected function executeAction() {
			if(isset($_GET['token'])){
				$this->token=$_GET['token'];
			}
			if(isset($_POST["resetPassword"]) && isset($_POST["confirmResetPassword"]))
			{
				if($_POST["resetPassword"] === $_POST["confirmResetPassword"]){
					$this->passwordConfirmation = true;
					$emailInDB = UserDAO::getEmail($this->token);
					if($this->token != null && $emailInDB != null)
					{
						$passwordHash = password_hash(($_POST["resetPassword"]), PASSWORD_BCRYPT);
						UserDAO::resetPassword($emailInDB, $passwordHash);
						$this->passwordReseted = true;
						UserDao::giveToken(null,$emailInDB["email"], false);
					}
					else
					{
						$this->passwordResetFail = true;
					}
				}
				else{
					$this->passwordConfirmation = false;
				}
			}	
		}
	}