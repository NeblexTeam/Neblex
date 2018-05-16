<?php
	require_once("action/CommonAction.php");

	class NotFoundAction extends CommonAction {

		public function __construct() {
			parent::__construct(parent::$VISIBILITY_PUBLIC, "404 Error Page not found" ,true);
		}

		protected function executeAction() {
			
		}
	}