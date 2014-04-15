<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>管理中心</title>
	<link rel="stylesheet" type="text/css" href="css/common.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script src="js/main.js"></script>
	<script src="js/jquery.min.js"></script>
	<!--<script src="js/ajax.js"></script>-->
</head>
<body>
	<div id="whole">
		<div id="logo">来人 管理页面</div>
		<div id="left">
			<?php require "m/left.php" ?>
		</div>
		<div id="right">
			<?php require "m/banner.php"; ?>
			<?php require "m/content.php"; ?>
		</div>
	</div>
</body>
</html>
