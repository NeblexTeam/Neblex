<?php
	require_once("action/OrderHistoryAction.php");

	$action = new OrderHistoryAction();
	$action->execute();
	$getOrderHistory = $action->getOrderHistory;

	require_once("partial/header.php");
?>
		<div class="container">
			<div>
				<h1 >Order History</h1>
			</div>

			<div >
			<!-- search bar -->
				<form>		
					<div class=" floatleft">				
						<span>Date :</span>
						<input type="text">
						<span>Pair :</span>
						<input type="text">
						<span>Type :</span>
						<input type="select">
						<a href="#" class="btn btn-blue">search</a>	
					</div>
					<div class="floatleft">
						<input type="checkbox" id="">
						<label for="" >
							Hide all cancelled
						</label>
						<a href="#" >Export Complete Order History</a>
					</div>
				</form>
			</div>
			
			<div class=>
				<table class ="table" id="product">
					<tbody>
						<!-- TITLE ROW -->
						<tr>
							<th class="alignleft  ">
								Date
							</th>
							<th class="alignleft  ">
								Pair
							</th>
							<th class="alignright ">
								Type
							</th>
							<th class="alignright ">
								Price
							</th>
							<th class="alignright ">
								Amount
							</th>
							<th class="alignright ">
								Filled
							</th>
							<th class="alignright ">	
								Total								
							</th>
							<th class="alignright ">			
								Status						
							</th>		
						</tr>
						<!-- COIN ROW -->
						<?php
						for ($row = 0; $row <=  count($getOrderHistory)-1; $row++) { 
						?>
							<tr>
								<td class="alignleft  ">
									<?=date("Y-m-d H:i:s", $getOrderHistory[$row]["ordertime"])." (EST)";?>
								</td>
								<?php
								if($getOrderHistory[$row]["transactiontype"] === "b") { 
								?>
									<td class="alignleft ">
										<?=$getOrderHistory[$row]["pair"]?>/NEBL
									</td>
									<td class="alignright">
										<span class="green">BUY</span>
									</td>
								<?php
								}
								else
								{ 
								?>
									<td class="alignleft ">
										NEBL/<?=$getOrderHistory[$row]["pair"]?>
									</td>
									<td class="alignright">
										<span class="magenta">SELL</span>
									</td>
								<?php
								}
								?>	
								<td class="alignright ">
									<?=number_format($getOrderHistory[$row]["price"], 8)?>
								</td>
								<td class="alignright ">
									<?=number_format($getOrderHistory[$row]["amount"], 8)?>
								</td>
								<td class="alignright ">
									0.00%
								</td>
								<td class="alignright ">
									<?=number_format($getOrderHistory[$row]["price"] * $getOrderHistory[$row]["amount"], 8)?>							
								</td>
								<td class="alignright ">
								<?php
								if($getOrderHistory[$row]["status"]	=== "Canceled") { 
								?>
									<span style="color:#bebebe;"><?=$getOrderHistory[$row]["status"]?></span>
								<?php
								}
								else
								{ 
								?>
									<?=$getOrderHistory[$row]["status"]?>
								<?php
								}
								?>						
								</td>						
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
