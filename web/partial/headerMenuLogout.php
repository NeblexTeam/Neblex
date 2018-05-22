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
		<li class="right"><a href="Register" class="link">Register</a></li>
        <li class="right"><a href="Login" class="link">Login</a></li>
    </ul>
</nav>
