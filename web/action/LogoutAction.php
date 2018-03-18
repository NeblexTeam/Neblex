<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/UserDAO.php");

	class LogoutAction extends CommonAction {

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_MEMBER, "Logout Neblex");
		}

		protected function executeAction() {

		}
	}