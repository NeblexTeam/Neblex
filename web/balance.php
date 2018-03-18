<?php
	require_once("action/BalanceAction.php");

	$action = new BalanceAction();
	$action->execute();

	require_once("partial/header.php");
?>
		<div class="container">
			<div>
				<ul class="floatright">
					<li>
						<label >Estimated Value</label>：
						<strong >20.04525036 NEBL</strong> /
						<strong>$371.32</strong>
					</li>
				</ul>
				<h1 >Deposits & Withdrawals</h1>
			</div>
		
			<div>
			<!-- search bar -->		
				<div class="floatleft">
					<input type="text">
				</div>
				<div class="floatleft">
					<input type="checkbox">
					<label for="" >
						Hide small assets
					</label>
				</div>
			</div>
			
			<div class=>
				<table class="table">
					<tbody>
						<!-- TITLE ROW -->
						<tr>
							<th class="alignleft">
								Coin
							</th>
							<th class="alignleft">
								Name
							</th>
							<th class="alignright">
								Total Balance
							</th>
							<th class="alignright">
								Available Balance
							</th>
							<th class="alignright">
								In order
							</th>
							<th class="alignright">
								NEBL Value
							</th>
							<th class="alignright">									
							</th>
							<th class="alignright">									
							</th>		
						</tr>
						<!-- COIN ROW -->
						<tr>
							<td class="alignleft">
								test
							</td>
							<td class="alignleft ">
								test
							</td>
							<td class="alignright">
								test
							</td>
							<td class="alignright">
								test
							</td>
							<td class="alignright">
								test
							</td>
							<td class="alignright">
								test
							</td>
							<td class="alignright">
								<a href="#" class="btn btn-blue">Deposit</a>									
							</td>
							<td class="alignright">
								<a href="#" class="btn btn-blue">Withdrawal</a>	
							</td>								
						</tr>
						<tr>
							<td class="alignleft">
								test
							</td>
							<td class="alignleft">
								test
							</td>
							<td class="alignright">
								test
							</td>
							<td class="alignright">
								test
							</td>
							<td class="alignright">
								test
							</td>
							<td class="alignright">
								test
							</td>
							<td class="alignright">
								<a href="#" class="btn btn-blue">Deposit</a>									
							</td>
							<td class="alignright">
								<a href="#" class="btn btn-blue">Withdrawal</a>	
							</td>								
						</tr>
					</tbody>
				</table>
			</div>	
		</div>			
<?php
	require_once("partial/footer.php");
