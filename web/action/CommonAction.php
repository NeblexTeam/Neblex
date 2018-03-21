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
			if( isset($this->isMenu) && $this->isMenu === true) {
				if($_SESSION["visibility"] > 0) {
					require_once("partial/headerMenuLogin.php");
				}
				else{
					require_once("partial/headerMenuLogout.php");
				}
			}
		}
		function generateRandomString($length = 60) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}
		
		public function mailresetlink($to,$token){
			$subject = "Request for password reset on Neblex";
			$uri = 'http://localhost/Neblex/web';
			$message = '
			<html>
			<head>
			<title>Request for password reset on Neblex</title>
			</head>
			<body>
			<img src="http://i0.kym-cdn.com/photos/images/original/000/666/559/acf.gif" alt="someone is trying to hack you">
			<p>Click on this link to reset your password<br>
			If you really are the person asking for this password reset, click on this link : <br>
			<a href="'.$uri.'/reset?token='.$token["tokenreset"].'">Reset Password</a></p>
			
			</body>
			</html>
			';
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From: NeblexTeam<support@neblex.io>' . "\r\n";
			$headers .= 'Cc: support@localhost' . "\r\n";
			mail($to,$subject,$message,$headers);

		}
		
		public function mailconfirmation($to,$token){
			//USE A LOGIN TOKEN BEFORE CREATING THE ACCOUNT
			//IF THE LOGIN TOKEN IS THERE, ACCOUNT CAN'T CONNECT, IF THERE'S NO LOGIN TOKEN, USER CAN CONNECT
			$subject = "Confirmation mail - Neblex";
			$uri = 'http://localhost/Neblex/web';
			$message = '
			<html>
			<head>
			<title>Confirmation mail - Neblex</title>
			</head>
			<body>
			<p>Thank you for registering to Neblex.io<br>
			Click this link to confirm your registration : <br>
			<a href="'.$uri.'/login?token='.$token.'">Confirm email</a><br>
			<h1>HAPPY TRADING</h1>
			<br><br>
			If you did not try to register to neblex.io, ignore this message.
			</p>
			
			</body>
			</html>
			';
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From: NeblexTeam<support@neblex.io>' . "\r\n";
			$headers .= 'Cc: support@localhost' . "\r\n";
			mail($to,$subject,$message,$headers);
	
		}
	}


