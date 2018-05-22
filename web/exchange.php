<?php
	require_once("action/ExchangeAction.php");

	$action = new ExchangeAction();
	$action->execute();
	$tickerArray = $action->tickerArray;
	$getSpecificCoin = $action->getSpecificCoin;
	$getSpecificBalance = $action->getSpecificBalance;
	$getNeblBalance = $action->getNeblBalance;
	$isTokenReal;

	$getOrderFromPairBuy = $action->getOrderFromPairBuy;
	$getOrderFromPairSell = $action->getOrderFromPairSell;

	require_once("partial/header.php");
?>
	<div>
		<strong>Choose the pair you wan't to trade in</strong>
		<select onchange="location = this.value;">

			<?php
			if(isset($_GET['token'])){
				for ($row = 0; $row <=  count($tickerArray)-1; $row++) { 
					if($tickerArray[$row] !== "NEBL"){
						if($_GET['token'] === $tickerArray[$row]){
							$isTokenReal=true;
				?>
					<option value="exchange?token=<?=$tickerArray[$row]?>" selected><a href="#"><?=$tickerArray[$row]?></a></option>
				<?php
						}
						else{
				?>
					<option value="exchange?token=<?=$tickerArray[$row]?>"><a href="#"><?=$tickerArray[$row]?></a></option>
				<?php
						}
					}
				}
				if($isTokenReal!==true){
					header("Location:exchange?token=$tickerArray[0]");
				}
			}
			else{
				header("Location:exchange?token=$tickerArray[0]");
			}
			?>

		</select>
	</div>
	<div class="container">
	<?php
		if($_SESSION["visibility"] > 0){
	?>
		<div class="buybox">
			<div>
				<b class="alignleft">Buy <?=$_GET['token']?></b>
				<div class="floatright">
					<span id="buy_Maximum"><?=number_format($getNeblBalance["balance"], 8)?></span> NEBL
				</div>
			</div>
			<form name="transaction" method="post" action="exchange?token=<?=$_GET['token']?>">
				<div class="spaced">
					<span>Price:</span>
					<input type="number" name="buyPrice" id="buyPrice" class="floatright" onkeyup="totalPrice('buy')" onchange="totalPrice('buy')" placeholder="NEBL" min="0" max="999999" step="0.00000001">
				</div>
				<div ></div>
				<div class="spaced">
					<span >Amount:</span>
					<input type="number" id="buyOrder" name="buyQuantity" class="floatright" onkeyup="totalPrice('buy')" onchange="totalPrice('buy')" placeholder="<?=$_GET['token']?>" min="0" max="999999" step="0.00000001">
				</div>
				<div>
					Total:<span id="buyTotal">0.00000000</span> NEBL
				</div>
				<input type="submit" id="buyButton" name="actionButton" value="BUY" class="btn-large btn-gray" disabled>
		</div>
		
		<div class="sellbox">
			<div>
				<b class="alignleft">Sell <?=$_GET['token']?></b>
				<div class="floatright">
					<span id="sell_Maximum"><?=number_format($getSpecificBalance["balance"], 8)?></span> <?=$_GET['token']?>
				</div>
			</div>
				<div class="spaced">
					<span>Price:</span>
					<input type="number" name="sellPrice" id="sellPrice" class="floatright" onkeyup="totalPrice('sell')" onchange="totalPrice('sell')" placeholder="NEBL" min="0" max="999999" step="0.00000001">
				</div>
				<div ></div>
				<div class="spaced">
					<span >Amount:</span>
					<input type="number" id="sellOrder" name="sellQuantity" class="floatright" onkeyup="totalPrice('sell')" onchange="totalPrice('sell')" placeholder="<?=$_GET['token']?>" min="0" max="999999" step="0.00000001">
				</div>
				<div>
					Total:<span id="sellTotal">0.00000000</span> NEBL
				</div>

				<input type="submit" id="sellButton" name="actionButton" value="SELL" class="btn-large btn-gray" disabled>
			</form>
		</div>
		<?php
		}
		else{
		?>	
		<div>
			<strong>You need to be <a href="login">connected</a> to issue order !</strong>
		</div>	
		<?php
		}
		?>
		<div class="orderBook">
			<div class="titleOrderBook"> 
				<p class="floatleft">Price (NEBL)</p>
				<p class="floatleft">Amount (<?=$_GET['token']?>)</p>
				<p class="floatright">Total (NEBL)</p>
			</div>
			<?php
			for($i=0; $i<=count($getOrderFromPairBuy)-1; $i++){
			?>
				<div class="buyOrder"> 
					<p class="floatleft"><?= number_format($getOrderFromPairBuy[$i]["price"],8) ?></p>
					<p class="floatleft"><?= number_format($getOrderFromPairBuy[$i]["amount"],8) ?></p>
					<p class="floatright"><?= number_format($getOrderFromPairBuy[$i]["amount"] * $getOrderFromPairBuy[$i]["price"],8) ?></p>
				</div>
			<?php
			}
			?>
			
			<?php
			for($i=0; $i<=count($getOrderFromPairSell)-1; $i++){
			?>
				<div class="sellOrder"> 
					<p class="floatleft"><?= number_format($getOrderFromPairSell[$i]["price"],8) ?></p>
					<p class="floatleft"><?= number_format($getOrderFromPairSell[$i]["amount"],8) ?></p>
					<p class="floatright"><?= number_format($getOrderFromPairSell[$i]["amount"] * $getOrderFromPairSell[$i]["price"],8) ?></p>
				</div>
			<?php
			}
			?>
		</div>
	</div>

		
<?php
	require_once("partial/footer.php");
