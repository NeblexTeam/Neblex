<?php
	require_once("action/ResetAction.php");

	$action = new ResetAction();
	$action->execute();

	require_once("partial/header.php");
?>
		<div>
			<div class="f-prz formBlock">
				<form class="loginForm  " id="forgotPwd-form" novalidate="novalidate">
					<a href="Index"><img src="./images/logo.png"  height="60" alt="NEBLEX"></a>
					<h3 class="loginFormTitle"><span >Reset Password</span></h3>
					
					<div >
						<p >Make sure you are browsing <strong>https://www.neblex.io</strong></p>
					</div>
					
					<p class="ErrorForm f-nomargin"></p>
					
					<div class="filed">
					<input type="password" ng-model="register.pwd" placeholder="Password" class="ipt pwd  " name="userPassword" id="regiterPassword" datatype="pwd" errormsg="Password must be at least 8 characters with uppercase letters and numbers." nullmsg="This field is required.">
					<input type="text" name="password" ng-model="register.password" id="password" style="display:none;" >
					</div>
		
					<div class="filed">
						<input type="password" ng-model="register.rePwd" placeholder="Confirm Password" class="ipt pwd  " datatype="*" errormsg="Passwords do not match.Please try again." recheck="userPassword" nullmsg="This field is required." id="regiterRepeatPassword">
					</div>
		
					<input style="display: none" id="ts" type="text" ng-model="register.ts" name="ts" >
					
					<div class="filed">	
						<input type="submit" value="Modify password" class="btn btn-blue btn-block" id="register-btn" ng-disabled="!register.email || !register.pwd || !register.rePwd || !register.agreement" ng-show="!loadingGeetest" disabled="disabled">
					</div> 
				</form>
			</div>
		</div>
<?php
	require_once("partial/footer.php");
