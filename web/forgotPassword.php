<?php
	require_once("action/ForgotPasswordAction.php");

	$action = new ForgotPasswordAction();
	$action->execute();
	$validEmail = $action->validEmail;

	require_once("partial/header.php");
?>
		<div>
			<div class="formBlock">
				<form class="loginForm" method="post" action="forgotPassword">
					<a href="Index"><img src="./images/logo.png"  height="60" alt="NEBLEX"></a>
					<h3 class="loginFormTitle"><span >Reset Password</span></h3>
					
					<div>
						<p >Make sure you are browsing <strong>https://www.neblex.io</strong></p>
					</div>
					
					<p class="ErrorForm"></p>
					<?php 
						if ($validEmail === -1) {
							?>
							<div class="magenta">No user registred with this email</div>
							<?php
						}
						if ($validEmail > -1) {
							?>
							<div class="green">An email has been sent to reset your password</div>
							<?php
						}
					?>
					<div class="filed">
						<input type="email" placeholder="Your Email" class="ipt" id="email" name="resetEmail" required>
					</div>
					
					<div class="filed alignright">
						<input type="submit" id="forgotPwd-btn" value="Submit" class="btn btn-blue btn-block">
					</div>
				</form>
			</div>
		</div>
<?php
	require_once("partial/footer.php");