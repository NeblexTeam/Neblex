<?php
	require_once("action/IndexAction.php");

	$action = new IndexAction();
	$action->execute();
	$getCoin = $action->getCoin;
	//$coinArray = $action->coinArray;
	//$tickerArray = $action->tickerArray;
	$getLast24hPrices = $action->getLast24hPrices;
	$getLastPrice = $action->getLastPrice;
	$get24hPrice = $action->get24hPrice;

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
								<input type="text" id="inputMarket" placeholder="Pair" onkeyup="filterTable('inputMarket','tableIndex', 0)">
							</div>
					</div>
				
					<div class=>
						<table class ="table" id="tableIndex">
							<tbody>
								<!-- TITLE ROW -->
								<tr>
									<th class="alignleft" onclick="sortTable('0', 'tableIndex')">
										Pair
									</th>
									<th class="alignleft" onclick="sortTable('1', 'tableIndex')">
										Last Price
									</th>
									<th class="alignright" onclick="sortTable('2', 'tableIndex')">
										24H Change
									</th>
									<th class="alignright" onclick="sortTable('3', 'tableIndex')">
										24H High
									</th>
									<th class="alignright" onclick="sortTable('4', 'tableIndex')">
										24h Low
									</th>
								</tr>
								<!-- COIN ROW -->
								<?php
								for ($row = count($getCoin)-1; $row >= 0; $row--) { 
								?>
										<tr>
								<?php
									if($getCoin[$row]["ticker"] != "NEBL"){
										for ($col=0; $col < 5; $col++) { 
											$amountInArray = count($getLast24hPrices[$getCoin[$row]["ticker"]])-1;
											if($col===0){
												?><td class="alignleft"><div id="divTokenName"><?=$getCoin[$row]["name"]."/".$getCoin[$row]["ticker"]?></div></td><?php
											}
											else if($col===1){
												if($amountInArray >= 0){
													?><td class="alignleft"><?=number_format($getLastPrice[$getCoin[$row]["ticker"]][0]["price"], 8)?></td><?php
												}
												else{
													?><td class="alignleft">Undefined</td><?php
												}
											}
											else if($col===2){
												if($amountInArray >= 0){
													$percent = $getLastPrice[$getCoin[$row]["ticker"]][0]["price"] / $get24hPrice[$getCoin[$row]["ticker"]][0]["price"];
													if($percent >= 1){
														?><td class="alignright green"><?=number_format(($percent * 100)-100, 2)?>%</td><?php
													}
													else{
														$percent =  $get24hPrice[$getCoin[$row]["ticker"]][0]["price"] / $getLastPrice[$getCoin[$row]["ticker"]][0]["price"];
														?><td class="alignright magenta">-<?=number_format(($percent * 100)-100, 2)?>%</td><?php
													}
												}
												else{
													?><td class="alignright">Undefined</td><?php
												}
											}
											else if($col===3){
												if($amountInArray >= 0){
													?><td class="alignright"><?=number_format($getLast24hPrices[$getCoin[$row]["ticker"]][$amountInArray]["price"], 8)?></td><?php
												}
												else{
													?><td class="alignright">Undefined</td><?php
												}
											}
											else{
												if($amountInArray >= 0){
													?><td class="alignright"><?=number_format($getLast24hPrices[$getCoin[$row]["ticker"]][0]["price"], 8)?></td><?php
												}
												else{
													?><td class="alignright">Undefined</td><?php
												}
											}
								?>
								<?php
										}
								?>
										</tr>
								<?php
									}
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