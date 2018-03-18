<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/UserDAO.php");

	class RegisterAction extends CommonAction {

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_PUBLIC, "Register Neblex");
		}

		protected function executeAction() {

		}
	}