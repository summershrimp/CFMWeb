<?php

define('IN_CFM', 0);

require "include/admin.class.php";

if (isset($_GET['check'])) {

}
else if (isset($_SESSION['user'])) {
	require "include/admin/indexafterlogin.php";
}
else {
	require "include/admin/indexbeforelogin.php";
}

?>
