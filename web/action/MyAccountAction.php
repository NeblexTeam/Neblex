<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/UserDAO.php");

	class MyAccountAction extends CommonAction {

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_MEMBER, "My Neblex Account" , true);
		}

		protected function executeAction() {

		}
	}