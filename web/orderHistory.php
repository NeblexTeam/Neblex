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
				<div class=" floatleft">				
					<span>Date :</span>
					<input type="text" id="inputDate" onkeyup="filterTable('inputDate','tableOrderHistory', 0)">
					<span>Pair :</span>
					<input type="text" id="inputPair" onkeyup="filterTable('inputPair','tableOrderHistory', 1)">
					<span>Type :</span>
					<input type="select"id="inputType" onkeyup="filterTable('inputType','tableOrderHistory', 2)">
					<!-- <a href="#" class="btn btn-blue">search</a>	 -->
				</div>
				<div class="floatleft">
					<!-- <input type="checkbox" id="cancelledCheckBox" onchange="hideRow('cancelledCheckBox','Cancelled', 7)">
					<label for="" >
						Hide all cancelled
					</label> -->
				</div>
			</div>
			<a class="floatright btn-blue" href='orderHistory?export=true'>Export Complete Order History</a>
			
			<div class=>
				<table class ="table" id="tableOrderHistory">
					<tbody>
						<!-- TITLE ROW -->
						<tr>
							<th class="alignleft" onclick="sortTable('0', 'tableOrderHistory')">
								Date
							</th>
							<th class="alignleft" onclick="sortTable('1', 'tableOrderHistory')">
								Pair
							</th>
							<th class="alignright" onclick="sortTable('2', 'tableOrderHistory')">
								Type
							</th>
							<th class="alignright" onclick="sortTable('3', 'tableOrderHistory')">
								Price
							</th>
							<th class="alignright" onclick="sortTable('4', 'tableOrderHistory')">
								Amount
							</th>
							<th class="alignright"onclick="sortTable('5', 'tableOrderHistory')">
								Filled
							</th>
							<th class="alignright" onclick="sortTable('6', 'tableOrderHistory')">	
								Total								
							</th>
							<th class="alignright" onclick="sortTable('7', 'tableOrderHistory')"> 			
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
									<?=number_format($getOrderHistory[$row]["amount"] / $getOrderHistory[$row]["originalamount"] * 100, 2)?>%
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
