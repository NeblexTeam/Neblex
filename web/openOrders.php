<?php
	require_once("action/OpenOrdersAction.php");

	$action = new OpenOrdersAction();
	$action->execute();
	$getOpenOrders = $action->getOpenOrders;

	require_once("partial/header.php");
?>
		<div class="container">
			<div>
				<h1 >Open Orders</h1>
			</div>
			
			<div class=>
				<table class ="table" id="tableOrder">
					<tbody>
						<!-- TITLE ROW -->
						<tr>
							<th class="alignleft">
								Date
							</th>
							<th class="alignleft">
								Pair
							</th>
							<th class="alignright">
								Type
							</th>
							<th class="alignright">
								Price
							</th>
							<th class="alignright">
								Amount
							</th>
							<th class="alignright">
								Filled
							</th>
							<th class="alignright">	
								Total								
							</th>
							<th class="alignright">
								Action									
							</th>		
						</tr>
						<!-- COIN ROW -->
						<form name="cancelOrder" method="post" action="openOrders">
						<?php
						for ($row = 0; $row <=  count($getOpenOrders)-1; $row++) { 
						?>
							<tr>
								<td class="alignleft  ">
									<?=date("Y-m-d H:i:s", $getOpenOrders[$row]["ordertime"])." (EST)";?>
								</td>
								<?php
								if($getOpenOrders[$row]["transactiontype"] === "b") { 
								?>
									<td class="alignleft ">
										<?=$getOpenOrders[$row]["pair"]?>/NEBL
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
										NEBL/<?=$getOpenOrders[$row]["pair"]?>
									</td>
									<td class="alignright">
										<span class="magenta">SELL</span>
									</td>
								<?php
								}
								?>	
								<td class="alignright ">
									<?=number_format($getOpenOrders[$row]["price"], 8)?>
								</td>
								<td class="alignright ">
									<?=number_format($getOpenOrders[$row]["amount"], 8)?>
								</td>
								<td class="alignright ">
									<?=number_format($getOpenOrders[$row]["amount"] / $getOpenOrders[$row]["originalamount"] * 100, 2)?>%
								</td>
								<td class="alignright ">
									<?=number_format($getOpenOrders[$row]["price"] * $getOpenOrders[$row]["amount"], 8)?>							
								</td>
								<td class="alignright ">
									<button type="submit" id="cancelOrder-<?=$row?>" name="cancelOrder-<?=$row?>" value="Cancel-<?=$row?>" class="btn">Cancel</button>
								</td>								
							</tr>
						<?php
						}
						?>
						</form>
					</tbody>
				</table>
			</div>	
		</div>			
<?php
	require_once("partial/footer.php");
