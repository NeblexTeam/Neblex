<?php
	require_once("action/NotFoundAction.php");

	$action = new NotFoundAction();
	$action->execute();

	require_once("partial/header.php");
?>

<?php
	require_once("partial/footer.php");