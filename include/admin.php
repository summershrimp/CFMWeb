<?php

define('IN_CFM', 0);

require "admin.class.php";

if (isset($_GET['check'])) {

}
else if (isset($_SESSION['user'])) {
	require "admin/indexafterlogin.php";
}
else {
	require "admin/indexbeforelogin.php";
}

?>
