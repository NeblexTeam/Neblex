<nav id="navHeader">
<ul>
	<li class="left"><a href="Index"><img src="./images/logo.png" alt="NEBLEX"></a></li>
<?php
if(isset($_GET['token'])){
	?><li class="left"><a href="exchange?token=<?=$_GET['token']?>" class="link">Exchange</a></li><?php
}else{
?>
	<li class="left"><a href="Exchange" class="link">Exchange</a></li>
<?php 
}
?>
	<li class="right"><a href="Logout" class="link">Logout</a></li>
	<li class="right"><a href="MyAccount" class="link">MyAccount</a></li>	
	<li class="right"><a href="Balance" class="link">Balance</a></li>
	<li class="right"><a href="OpenOrders" class="link">Open Orders</a></li>
	<li class="right"><a href="OrderHistory" class="link">Order History</a></li>
</ul>
</nav>