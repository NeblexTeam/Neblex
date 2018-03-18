<?php
	require_once("action/OrderHistoryAction.php");

	$action = new OrderHistoryAction();
	$action->execute();

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
						<tr>
							<td class="alignleft  ">
								test
							</td>
							<td class="alignleft ">
								test
							</td>
							<td class="alignright">
								test
							</td>
							<td class="alignright ">
								test
							</td>
							<td class="alignright ">
								test
							</td>
							<td class="alignright ">
								test
							</td>
							<td class="alignright ">
								Test								
							</td>
							<td class="alignright ">
								test	
							</td>								
						</tr>
					</tbody>
				</table>
			</div>	
		</div>			
<?php
	require_once("partial/footer.php");
