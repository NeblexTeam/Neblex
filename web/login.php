<?php
	require_once("action/LoginAction.php");

	$action = new LoginAction();
	$action->execute();
	$wrongLogin = $action->wrongLogin;
	$emailConfirm = $action->emailConfirm;

	require_once("partial/header.php");
?>

		<div>
			<div class="formBlock">
				<form class="loginForm" method="post" action="login">
					<a href="Index"><img src="./images/logo.png"  height="60" alt="NEBLEX"></a>
					<h3 class="loginFormTitle"><span >Login</span></h3>
					
					<div >
						<p >Make sure you are browsing <strong>https://www.neblex.io</strong></p>
					</div>
					
					<p class="ErrorForm"></p>
					<?php 
						if ($wrongLogin === true) {
							?>
							<div class="magenta">Wrong email or password, try again !</div>
							<?php
						}
						if ($emailConfirm === false) {
							?>
							<div class="magenta">Click the link we send you in your email to activate your account !</div>
							<?php
						}
						if(isset($_GET['token'])) {
							?>
							<div class="green">Your account is now active, <strong>HAPPY TRADING</strong></div>
							<?php
						}
					?>
			
					<div class="filed">
						<input type="email" name="loginEmail" placeholder="Email" id="email" class="ipt" required>
					</div>
			
					<div class="filed">
						<input type="password" name="loginPassword" placeholder="Password" id="pwd" class="ipt" required>
					</div>
			
					<div class="filed">
						<input type="submit" value="Login" id="login-btn" class="btn btn-blue btn-block">
					</div>
			
					<div>
						<p>
							<span class="floatright">Not registred yet? <a href="./register" class="blue">Register</a></span>
							<a href="./forgotPassword" class="blue floatleft ">Forgot Password?</a>
						</p>
					</div>		
				</form>	
			</div>
		</div>
<?php
	require_once("partial/footer.php");
