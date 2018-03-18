<?php
	require_once("action/LoginAction.php");

	$action = new LoginAction();
	$action->execute();

	require_once("partial/header.php");
?>

		<div>
			<div class="formBlock">
				<form class="loginForm " id="login-form">
					<a href="Index"><img src="./images/logo.png"  height="60" alt="NEBLEX"></a>
					<h3 class="loginFormTitle"><span >Login</span></h3>
					
					<div >
						<p >Make sure you are browsing <strong>https://www.neblex.io</strong></p>
					</div>
					
					<p class="ErrorForm"></p>
			
					<div class="filed">
						<input type="email" name="email" placeholder="Email" id="email" class="ipt" errormsg="Invalid email address." nullmsg="This field is required.">
					</div>
			
					<div class="filed">
						<input type="password" placeholder="Password" id="pwd" class="ipt" nullmsg="This field is required.">
					</div>
			
					<div class="filed">
						<input type="submit" value="Login" id="login-btn" class="btn btn-blue btn-block" disabled="disabled">
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
