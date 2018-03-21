<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/UserDAO.php");

	class OpenOrdersAction extends CommonAction {

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_MEMBER, "Open Orders Neblex" , true);
		}

		protected function executeAction() {

		}
	}