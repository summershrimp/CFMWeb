<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
?>
<div id="content">
<?php
	if (!isset($_GET['page'])) {
		$page = "default";
	}
	else {
		$page = $_GET['page'];
	}
	switch ($page) {
	case "personal":
	case "shop":
	case "order":
	case "economic":
	case "ant":
	case "user":
	case "default":
		require "m/page/$page.php";
		break;
	default:
		echo "<meta http-equiv=\"refresh\" content=\"0; url=?\">";
		break;
	}
?>
</div>
