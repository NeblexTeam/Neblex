<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/UserDAO.php");

	class LoginAction extends CommonAction {

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_PUBLIC, "Login Neblex");
		}

		protected function executeAction() {

		}
	}