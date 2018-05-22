<?php
	require_once("action/MyAccountAction.php");

	$action = new MyAccountAction();
	$action->execute();
	$connection = $action->connection;

	require_once("partial/header.php");
?>
		<div class="wrap">
			<div class="container">
				
				<div class="f-cb">
					<div class="floatleft">
						<div class="panel">
							<div class="panel-title">
								My Password
							</div>
							<div class="panel-body">
								<div class="item">
									<a href="./forgotPassword" class="btn btn-blue">Modify</a>
								</div>
							</div>
						</div>
					</div>
					<div class="floatright">
						<div class="panel">
							<div class="panel-title">
								My Email
							</div>
							<div class="panel-body">
								<div class="item">
									<h4><?= $_SESSION["email_user"] ?></h4>
								</div>
							</div>
						</div>
					</div>	
				</div>

				<!-- <div class="f-cb">
					<div class="panel">
						<div class="panel-title">
							My NEBLIO Wallet
						</div>
						<div class="panel-body">
							<form id="privateKey-form">
								<div class="item">
									<p>
										Add or modify my Neblio wallet's private key : 
										<input type="text" name="NeblPrivateKey" id="NeblPrivateKey">
									</p> 
									<p>To <strong>prevent</strong> a potential hacker or even us from getting access to your <span class="magenta">private key</span> we request our users to add their own salt to the hashing process of there private key</p>
									<p class="magenta"><strong>BE CAREFULL. NEVER GIVE YOUR PRIVATE KEY TO UNTRUSTFULL SITE OR PERSON</strong></p>
									<p>
										Enter private key password here : 
										<input type="password" name="PrivateKeySalt" id="PrivateKeySalt">
									</p>
									
									<a href="#" class="btn btn-blue">Modify/Add</a>
								</div>
							</form>
						</div>
					</div>
				</div> -->

				<div>Last login</div>
				<table class="table">
					<colgroup style="width:150px;"></colgroup>
					<colgroup></colgroup>
					<colgroup style="width:150px;"></colgroup>
					<tbody>
						<tr>
							<th>Date</th>
							<th>IP Address</th>
							<th width="30%">Location</th>
						</tr>
					<?php
						for ($row = count($connection)-1; $row >= 0; $row--) { 
					?>
							<tr>
					<?php
							for ($col=0; $col < 3; $col++) { 
								if($col===0){
									?><td><?=date("Y-m-d H:i:s", $connection[$row]["dateconnection"])." (EST)";?></td><?php
								}
								else if($col===1){
									?><td><?=$connection[$row]["ipconnection"]?></td><?php
								}
								else if($col===2){
									$ip = $connection[$row]["ipconnection"];
									$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"), true);
									?><td>
									<?php 
										if(isset($details["region"]) && isset($details["country"])){
											echo $details["region"].", ".$details["country"];
										} 
									?></td><?php
								}
					?>
					<?php
							}
					?>
							</tr>
					<?php
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
<?php
	require_once("partial/footer.php");
