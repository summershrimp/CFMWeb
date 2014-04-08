<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
switch ($_GET['action']) {
case 'login':
	require "f/action/login.php";
	break;
case 'personal':
case 'shop':
case 'order':
case 'economic':
case 'ant':
case 'user':
	echo "<meta http-equiv=\"refresh\" content=\"0; url='?page=" . $_GET['action'] . "'\">";
	break;
case 'logout':
	require "f/action/logout.php";
	break;
default:
	echo "<meta http-equiv=\"refresh\" content=\"0; url=?\">";
	break;
}
?>
