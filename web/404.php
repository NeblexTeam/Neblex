<?php
	require_once("action/NotFoundAction.php");

	$action = new NotFoundAction();
	$action->execute();

	require_once("partial/header.php");
?>

<img src="./images/404.png" alt="NEBLEX404" style="display: block; margin-left: auto; margin-right: auto;" width="1000" height="382">

<?php
	require_once("partial/footer.php");