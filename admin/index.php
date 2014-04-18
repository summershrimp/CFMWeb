<?php

require "config.php";
require "f/sessionstart.php";
require "f/db.php";
require "f/functions.php";

$db = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
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
