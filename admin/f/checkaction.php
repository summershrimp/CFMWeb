<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
switch ($_GET['action']) {
case 'login':
	require "f/action/login.php";
	break;
case 'logout':
	require "f/action/logout.php";
	break;
case 'ajax':
	require "f/ajax.php";
	break;
default:
	echo "<meta http-equiv=\"refresh\" content=\"0; url=?\">";
	break;
}
?>
