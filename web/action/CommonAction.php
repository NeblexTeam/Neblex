<?php
	session_start();

	require_once("action/constants.php");
	
	abstract class CommonAction {
		public static $VISIBILITY_PUBLIC = 0;
		public static $VISIBILITY_MEMBER = 1;

		private $pageVisibility;
		private $pageTitle;
		private $pageCssFile;
		private $isMenu;

		public function __construct($pageVisibility, $pageTitle,  $isMenu = false, $pageCssFile = null) {
			$this->pageVisibility = $pageVisibility;
			$this->pageTitle = $pageTitle;
			$this->pageCssFile = $pageCssFile;
			$this->isMenu = $isMenu;
		}

		public function execute() {			
			if (!empty($_GET["action"]) && $_GET["action"] == "logout") {
				session_unset();
				session_destroy();
				session_start();
			}
			
			if (empty($_SESSION["visibility"])) {
				$_SESSION["visibility"] = CommonAction::$VISIBILITY_PUBLIC;
			}

			if ($_SESSION["visibility"] < $this->pageVisibility) {
				header("location:index");
				exit;
			}

			$this->executeAction();
		}

		// Template method
		abstract protected function executeAction();

		public function isLoggedIn() {
			return $_SESSION["visibility"] > CommonAction::$VISIBILITY_PUBLIC;
		}

		public function getUsername() {
			// Condition ternaire
			return $this->isLoggedIn() ? $_SESSION["username"] : "invité";
		}

		public function getPageTitle() {
			echo $this->pageTitle;
		}

		public function getPageCssFile() {
			if( isset($this->pageCssFile) && strpos($this->pageCssFile, "stylesheet")) {
				echo $this->pageCssFile;
			}
		}

		public function getIsMenu() {
			if( isset($this->isMenu) && $this->isMenu == true) {
				if($_SESSION["visibility"] < $this->pageVisibility) {
					require_once("partial/headerMenuLogin.php");
				}
				else{
					require_once("partial/headerMenuLogout.php");
				}
			}
		}
	}