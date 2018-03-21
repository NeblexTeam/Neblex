<?php
	require_once("action/RegisterAction.php");

	$action = new RegisterAction();
	$action->execute();

	$wrongRegister = $action->wrongRegister;
	$confirmationSent = $action->confirmationSent;
	$samePassword = $action->samePassword;

	require_once("partial/header.php");
?>
		<div>
			<div class="formBlock">
				<form class="loginForm" method="post" action="register">
					<a href="Index"><img src="./images/logo.png"  height="60" alt="NEBLEX"></a>
					<h3 class="loginFormTitle"><span >Register</span></h3> 

					<div >
						<p >Make sure you are browsing <strong>https://www.neblex.io</strong></p>
					</div>

	 				<div class="ErrorForm"></div>
					 <?php 
							if ($wrongRegister === true) {
								?>
								<div class="magenta"><strong>The email you chose is already being used</strong></div>
								<?php
							}
					?>
					<?php 
							if ($samePassword === false) {
								?>
								<div class="magenta"><strong>Password and Confirmation don't match</strong></div>
								<?php
							}
					?>
					<?php 
							if ($confirmationSent === true) {
								?>
								<div class="green"><strong>Confirmation mail sent, go check your email !</strong></div>
								<?php
							}
					?>

					<div class="filed">
						<input type="email" id="registerEmail" placeholder="Email" class="ipt" name="registerEmail" required>
					</div>
		
					<div class="filed">
						<input type="password" id="regiterPassword" placeholder="Password" class="ipt" name="registerPassword" required>
					</div>
		
					<div class="filed">
						<input type="password"  id="confirmationPassword" placeholder="Confirm Password" class="ipt"  name="confirmationPassword" required>
					</div>

					<div class="filed">
					<!-- oninvalid="this.setCustomValidity('Before proceeding, read and accept our terms of use')" -->
						<label><input id="agreement" name="agreement" type="checkbox" datatype="checked" required>I agree to Neblex's <a href="#" target="_blank" class="blue ">Terms Of Use</a></label>
					</div>
		
					<div class="filed">	
						<input type="submit" value="Register" class="btn btn-blue btn-block" id="register-btn">
					</div> 
		
					<div>
						<p class="alignright">Already Registered? <a href="./login" class="blue ">Login</a></p>
					</div>
				</form> 
			</div>
		</div>
<?php
	require_once("partial/footer.php");