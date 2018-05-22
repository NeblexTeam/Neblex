<?php
	require_once("action/BalanceAction.php");

	$action = new BalanceAction();
	$action->execute();
	$getCoin = $action->getCoin;
	$getBalance = $action->getBalance;
	$totalNebl = $action->totalNebl;
	$price = $action->price;
	$getLastPrice = $action->getLastPrice;
	$getInOrder = $action->getInOrder;

	require_once("partial/header.php");
?>
		<div class="container">
			<div>
				<ul class="floatright">
					<li>
						<label >Estimated Value</label>：
						<!-- CALCULATE ACCORDING TO LAST BUYED PRICE -->
						<strong ><?= $totalNebl ?> NEBL</strong> /
						<strong>$<?=number_format($price*$totalNebl , 2) ?></strong>
					</li>
				</ul>
				<h1 >Deposits & Withdrawals</h1>
			</div>
		
			<div>
			<!-- search bar -->		
				<div class="floatleft">
					<input type="text" id="searchBalance" placeholder="Coin" onkeyup="filterTable('searchBalance','tableBalance', 0)">
				</div>
				<div class="floatleft">
					<!-- <input type="checkbox">
					<label for="" >
						Hide small assets
					</label> -->
				</div>
			</div>
			
			<div class=>
				<table class="table" id="tableBalance">
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
						<form class="modal-content animate"  method="post" action="Balance">
							<?php
							for ($row = 0; $row <=  count($getCoin)-1; $row++) { 
							?>
								<!-- COIN ROW -->
								<tr>
									<td class="alignleft">
										<?=$getCoin[$row]["ticker"]?>
									</td>
									<td class="alignleft ">
										<?=$getCoin[$row]["name"]?>
									</td>
									<?php
									if($getCoin[$row]["ticker"] === "NEBL"){
									?>
										<td class="alignright"><?= number_format($getBalance[$getCoin[$row]["id"]-1]["balance"] + $getInOrder["NEBL"], 8)?></td>
										<td class="alignright"><?= number_format($getBalance[$getCoin[$row]["id"]-1]["balance"], 8)?></td>
										<td class="alignright"><?= number_format($getInOrder["NEBL"], 8)?></td>
										<td class="alignright"><?=number_format(floatval($getBalance[$getCoin[$row]["id"]-1]["balance"]) + $getInOrder["NEBL"], 8)?></td>
									<?php
									}
									else{
										if(!empty($getInOrder)){
											if(array_key_exists($getCoin[$row]["ticker"],$getInOrder)){	
									?>
											<td class="alignright"><?= number_format($getBalance[$getCoin[$row]["id"]-1]["balance"] + $getInOrder[$getCoin[$row]["ticker"]], 8)?></td>
											<td class="alignright"><?= number_format($getBalance[$getCoin[$row]["id"]-1]["balance"], 8)?></td>
											<td class="alignright"><?= number_format($getInOrder[$getCoin[$row]["ticker"]], 8)?></td>
									<?php
											}
											else{
												?>
												<td class="alignright"><?= number_format($getBalance[$getCoin[$row]["id"]-1]["balance"], 8)?></td>
												<td class="alignright"><?= number_format($getBalance[$getCoin[$row]["id"]-1]["balance"], 8)?></td>
												<td class="alignright"><?= number_format(0, 8)?></td>
										<?php
											}
										}
										else{
										?>
											<td class="alignright"><?= number_format($getBalance[$getCoin[$row]["id"]-1]["balance"], 8)?></td>
											<td class="alignright"><?= number_format($getBalance[$getCoin[$row]["id"]-1]["balance"], 8)?></td>
											<td class="alignright"><?= number_format(0, 8)?></td>
										<?php		
										}				
										if(empty($getLastPrice[$getCoin[$row]["ticker"]])){
										?>			
											<td class="alignright">Undefined</td>
										<?php
										}
										else{
											?><td class="alignright"><?=number_format(floatval(($getBalance[$getCoin[$row]["id"]-1]["balance"])+ $getInOrder[$getCoin[$row]["ticker"]])*$getLastPrice[$getCoin[$row]["ticker"]][0]["price"], 8) ?></td><?php
										}
									}
									?>
									<td class="alignright">
									<button type="button" class="btn btn-blue" onclick="document.getElementById('modal-wrapper-deposit-<?=$row?>').style.display='block'; document.getElementById('input-Deposit-<?=$getCoin[$row]["id"]?>').disabled = false;">Deposit</button>
										<div id="modal-wrapper-deposit-<?=$row?>" class="modal">
										
											<div class="modal-content animate">
													
												<div class="imgcontainer">
												<span onclick="document.getElementById('modal-wrapper-deposit-<?=$row?>').style.display='none'; document.getElementById('input-Deposit-<?=$getCoin[$row]["id"]?>').disabled = true;" class="close" title="Close">&times;</span>
												<h1>Enter the ammount of <?=$getCoin[$row]["name"]?> you want to deposit</h1>
												</div>
											
												<div class="containerBox">
													<input type="number" id="input-Deposit-<?=$getCoin[$row]["id"]?>" class="inputNumber" name="amountDeposit-<?=$getCoin[$row]["id"]?>" placeholder="0.00000000" min="0" max="999999" step="0.00000001" disabled>
													<button type="submit" class="boxButton">Deposit</button>
												</div>
												
											</div>	
										</div>						
									</td>
									<td class="alignright">
									<button type="button" class="btn btn-blue" onclick="document.getElementById('modal-wrapper-withdraw-<?=$row?>').style.display='block'; document.getElementById('input-Withdraw-<?=$getCoin[$row]["id"]?>').disabled = false;">Withdrawal</button>
										<div id="modal-wrapper-withdraw-<?=$row?>" class="modal">
										
											<div class="modal-content animate">
													
												<div class="imgcontainer">
												<span onclick="document.getElementById('modal-wrapper-withdraw-<?=$row?>').style.display='none'; document.getElementById('input-Withdraw-<?=$getCoin[$row]["id"]?>').disabled = true;" class="close" title="Close">&times;</span>
												<h1>Enter the ammount of <?=$getCoin[$row]["name"]?> you want to withdraw</h1>
												</div>
											
												<div class="containerBox">
													<input type="number" id="input-Withdraw-<?=$getCoin[$row]["id"]?>" class="inputNumber" name="amountWithdraw-<?=$getCoin[$row]["id"]?>" placeholder="0.00000000" min="0" max="<?=$getBalance[$getCoin[$row]["id"]-1]["balance"]?>" step="0.00000001" disabled>
													<button type="submit" class="boxButton">Withdraw</button>
												</div>
												
											</div>	
										</div>						
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
