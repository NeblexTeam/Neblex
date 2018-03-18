<?php
	require_once("action/IndexAction.php");

	$action = new IndexAction();
	$action->execute();

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
								</tr>
							</tbody>
						</table>
					</div>				
				</div>
			</div>
		</div>
<?php
	require_once("partial/footer.php");