<?php
	require_once("action/OpenOrdersAction.php");

	$action = new OpenOrdersAction();
	$action->execute();

	require_once("partial/header.php");
?>
		<div class="container">
			<div>
				<h1 >Open Orders</h1>
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
								Action									
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
								<a href="#" class="btn ">Cancel</a>	
							</td>								
						</tr>
					</tbody>
				</table>
			</div>	
		</div>			
<?php
	require_once("partial/footer.php");
