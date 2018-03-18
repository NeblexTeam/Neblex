<?php
	require_once("action/RegisterAction.php");

	$action = new RegisterAction();
	$action->execute();

	require_once("partial/header.php");
?>
		<div>
			<div class="formBlock">
				<form class="loginForm" id="register-form">
					<a href="Index"><img src="./images/logo.png"  height="60" alt="NEBLEX"></a>
					<h3 class="loginFormTitle"><span >Register</span></h3> 

					<div >
						<p >Make sure you are browsing <strong>https://www.neblex.io</strong></p>
					</div>

	 				<div class="ErrorForm"></div>
		
					<div class="filed">
						<input id="email" type="email" placeholder="Email" class="ipt" name="email" errormsg="Invalid email address." nullmsg="This field is required.">
					</div>
		
					<div class="filed">
						<input type="password" placeholder="Password" class="ipt" name="userPassword" id="regiterPassword" errormsg="Password must be at least 8 characters with uppercase letters and numbers." nullmsg="This field is required.">
					</div>
		
					<div class="filed">
						<input type="password" placeholder="Confirm Password" class="ipt" errormsg="Passwords do not match.Please try again." nullmsg="This field is required." id="regiterRepeatPassword">
					</div>

					<div class="filed">
						<label><input id="agreement" type="checkbox" datatype="checked" nullmsg="This field is required." >I agree to Neblex's <a href="#" target="_blank" class="blue ">Terms Of Use</a></label>
					</div>
		
					<div class="filed">	
						<input type="submit" value="Register" class="btn btn-blue btn-block" id="register-btn" disabled="disabled">
					</div> 
		
					<div>
						<p class="alignright">Already Registered? <a href="./login" class="blue ">Login</a></p>
					</div>
				</form> 
			</div>
		</div>
<?php
	require_once("partial/footer.php");