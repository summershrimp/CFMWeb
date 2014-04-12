<?php

require "config.php";
require "f/sessionstart.php";
require "f/db.php";

if (isset($_GET['action'])) {
	require "f/checkaction.php";
}
else if (isset($_SESSION['username'])) {
	require "indexafterlogin.php";
}
else {
	require "indexbeforelogin.php";
}

?>
