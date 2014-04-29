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
	case "provider":
	case "order":
	case "detail":
	case "ant":
	case "good":
	case "user":
	case "address":
	case "feedback":
	case "default":
		require "m/page/$page.php";
		break;
	default:
		echo "<meta http-equiv=\"refresh\" content=\"0; url=?\">";
		break;
	}
?>
</div>
