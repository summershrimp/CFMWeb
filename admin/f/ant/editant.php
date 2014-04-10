<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$t = $db->update("ants", "`ant_name`='" . $_POST['name'] .
	"' , `email`='" . $_POST['email'] .
	"' , `ant_real_name`='" . $_POST['real_name'] .
	"' , `sex`='" . $_POST['sex'] .
	"' , `mobile_phone`='" . $_POST['mobile'] . "'",
	"`ant_id`='" . $_GET['detail'] . "'", 1
);
if ($t == false) {
	echo "<div class='returnerror'>修改失败，请检查输入数据！</div>";
}
else {
	echo "<div class='returnsuccess'>修改成功！</div>";
}
?>
