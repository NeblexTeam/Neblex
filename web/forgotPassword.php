<?php
	require_once("action/ForgotPasswordAction.php");

	$action = new ForgotPasswordAction();
	$action->execute();

	require_once("partial/header.php");
?>
		<div>
			<div class="formBlock">
				<form class="loginForm">
					<a href="Index"><img src="./images/logo.png"  height="60" alt="NEBLEX"></a>
					<h3 class="loginFormTitle"><span >Reset Password</span></h3>
					
					<div>
						<p >Make sure you are browsing <strong>https://www.neblex.io</strong></p>
					</div>
					
					<p class="ErrorForm"></p>
					
					<div class="filed">
						<input type="email" placeholder="Your Email" class="ipt" id="email" name="email" errormsg="Invalid email address." nullmsg="This field is required.">
					</div>
					
					<div class="filed alignright">
						<input type="submit" id="forgotPwd-btn" value="Submit" class="btn btn-blue btn-block" ng-disabled="!forgotPwd.email" disabled="disabled">
					</div>
				</form>
			</div>
		</div>
<?php
	require_once("partial/footer.php");