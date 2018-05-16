<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<link rel='stylesheet' type='text/css' href='css/global.css' />
	<script src="js/preventClickJacking.js"></script>
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/main.js"></script>
	<?php
		$action->getPageJsFile();
	 ?>
	<?php
		$action->getPageCssFile();
	 ?>
	<title><?php $action->getPageTitle(); ?></title>
	</title>
</head>
	<body>
		<?php $action->getIsMenu();?>
