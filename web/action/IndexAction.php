<?php
	require_once("action/CommonAction.php");
	require_once("action/dao/UserDAO.php");

	class IndexAction extends CommonAction {

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_PUBLIC, "NTP1 Token Exchange" ,true);
		}

		protected function executeAction() {

		}
	}