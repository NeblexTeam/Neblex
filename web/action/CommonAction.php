<?php
	session_start();

	require_once("action/constants.php");
	
	abstract class CommonAction {
		public static $VISIBILITY_PUBLIC = 0;
		public static $VISIBILITY_MEMBER = 1;

		private $pageVisibility;
		private $pageTitle;
		private $pageCssFile;
		private $pageJsFile;
		private $isMenu;

		public function __construct($pageVisibility, $pageTitle, $isMenu = false, $pageJsFile = null, $pageCssFile = null) {
			$this->pageVisibility = $pageVisibility;
			$this->pageTitle = $pageTitle;
			$this->pageCssFile = $pageCssFile;
			$this->isMenu = $isMenu;
			$this->pageJsFile = $pageJsFile;

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

		public function getPageJsFile() {
			if( isset($this->pageJsFile)) {
				echo $this->pageJsFile;
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
		
		public function getIp(){
			$ipaddress = '';
			if (getenv('HTTP_CLIENT_IP'))
				$ipaddress = getenv('HTTP_CLIENT_IP');
			else if(getenv('HTTP_X_FORWARDED_FOR'))
				$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
			else if(getenv('HTTP_X_FORWARDED'))
				$ipaddress = getenv('HTTP_X_FORWARDED');
			else if(getenv('HTTP_FORWARDED_FOR'))
				$ipaddress = getenv('HTTP_FORWARDED_FOR');
			else if(getenv('HTTP_FORWARDED'))
			   $ipaddress = getenv('HTTP_FORWARDED');
			else if(getenv('REMOTE_ADDR'))
				$ipaddress = getenv('REMOTE_ADDR');
			else
				$ipaddress = 'UNKNOWN';
			return $ipaddress;
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
			$headers .= 'From: NeblexTeam<support@localhost>' . "\r\n";
			$headers .= 'Cc: support@localhost' . "\r\n";
			mail($to,$subject,$message,$headers);
	
		}

		public function loading() {
			?>
			<!--API LOADER -->
			<div id="loader-wrapper">
					<div id="loader"></div>
					<div class="loader-section section-top"></div>
			</div>
			<?php
		}

		public function exportOrderHistory($data){
			// output headers so that the file is downloaded rather than displayed
			header('Content-type: text/csv');
			header('Content-Disposition: attachment; filename="orderHistory.csv"');
			
			// do not cache the file
			header('Pragma: no-cache');
			header('Expires: 0');
			
			// create a file pointer connected to the output stream
			$file = fopen('php://output', 'w');
			
			// send the column headers
			fputcsv($file, array('Date (EST)', 'Pair', 'Type', 'Price', 'Amount', 'Filled (%)', 'Total', 'Status'));
			
			// output each row of the data
			foreach ($data as $row)
			{
			fputcsv($file, $row);
			}
			
			exit();
		}
		
	}