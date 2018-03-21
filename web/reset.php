<?php
	require_once("action/ResetAction.php");

	$action = new ResetAction();
	$action->execute();
	$passwordReseted = $action->passwordReseted;
	$passwordResetFail = $action->passwordResetFail;
	$passwordConfirmation = $action->passwordConfirmation;

	require_once("partial/header.php");
?>
		<div>
			<div class="f-prz formBlock">
				<form class="loginForm" method="post">
					<a href="Index"><img src="./images/logo.png"  height="60" alt="NEBLEX"></a>
					<h3 class="loginFormTitle"><span >Reset Password</span></h3>
					
					<div >
						<p >Make sure you are browsing <strong>https://www.neblex.io</strong></p>
					</div>
					
					<div class="ErrorForm" ></div>

					<div>
						<?php 
								if ($passwordResetFail == true) {
									?>
									<div class="magenta">If you're trying to reset your password, please click on the link we've sent in your email</div>
									<?php
								}
							?>
					</div>
					<div>
						<?php 
								if ($passwordConfirmation == false) {
									?>
									<div class="magenta">Password and Confirmation don't match</div>
									<?php
								}
							?>
					</div>
					<div>
						<?php 
								if ($passwordReseted == true) {
									?>
									<div class="green">Your password has been succesfully changed, <a href="Login">Login</a></div>
									<?php
								}
							?>
					</div>
					
					<div class="filed">
					<input type="password" name="resetPassword" placeholder="Password" class="ipt" id="resetPassword" datatype="pwd" required>
					</div>
		
					<div class="filed">
						<input type="password" name="confirmResetPassword" placeholder="Confirm Password" class="ipt" required>
					</div>
					
					<div class="filed">	
						<input type="submit" value="Modify password" class="btn btn-blue btn-block" id="register-btn">
					</div> 
				</form>
			</div>
		</div>
<?php
	require_once("partial/footer.php");
