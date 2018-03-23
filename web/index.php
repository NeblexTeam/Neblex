<?php
	require_once("action/IndexAction.php");

	$action = new IndexAction();
	$action->execute();
	$coin = $action->coin;

	require_once("partial/header.php");
?>
		<div class="container">
			<div>
				<div>
					<!-- Nebl market title -->
					<div >
							<ul class="floatleft">
								<li>NEBL Markets</li>
							</ul>
					<!-- search bar -->		
							<div class="floatleft">
								<input type="text">
							</div>
					</div>
				
					<div class=>
						<table class ="table" id="product">
							<tbody>
								<!-- TITLE ROW -->
								<tr>
									<th class="alignleft  ">
										Pair
									</th>
									<th class="alignleft  ">
										Last Price
									</th>
									<th class="alignright ">
										24H Change
									</th>
									<th class="alignright ">
										24H High
									</th>
									<th class="alignright ">
										24h Low
									</th>
								</tr>
								<!-- COIN ROW -->
								<?php
								for ($row = count($coin)-1; $row >= 0; $row--) { 
								?>
										<tr>
								<?php
										for ($col=0; $col < 5; $col++) { 
											if($col===0){
												?><td class="alignleft"><?=$coin[$row]["name"]."/".$coin[$row]["ticker"]?></td><?php
											}
											else if($col===1){
												?><td class="alignleft">test</td><?php
											}
											else{
												?><td class="alignright">test</td><?php
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
			</div>
		</div>
<?php
	require_once("partial/footer.php");