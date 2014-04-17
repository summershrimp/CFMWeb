<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$all_success = true;
$list = "";
if (isset($_POST['chk'])) {
	foreach ($_POST['chk'] as $e) {
		$result = $db->select("provider_id", "providers", "`provider_id`='$e'", 1);
		if ($result == false || $db->fetch($result) == false) {
			$list .= ($list == "" ? "" : ", ") . $e;
			$all_success = false;
		}
		else {
			$db->delete("providers", "`provider_id`='$e'", 1);
		}
	}
	if ($all_success == true) {
		echo "<div class='return success'>批量删除成功！</div>";
	}
	else {
		echo "<div class='return warning'>部分业主未找到！ID：$list</div>";
	}
}
else {
	echo "<div class='return error'>未指定业主！</div>";
}
?>
