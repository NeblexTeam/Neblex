<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/UserDAO.php");

	class ForgotPasswordAction extends CommonAction {

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_PUBLIC, "Reset Password Neblex");
		}

		protected function executeAction() {

		}
	}