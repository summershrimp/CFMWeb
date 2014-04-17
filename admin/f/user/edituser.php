<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$t = $db->update("customers", "`user_name`='" . $_POST['user_name'] .
	"' , `email`='" . $_POST['email'] .
	"' , `sex`='" . $_POST['sex'] .
	"' , `mobile_phone`='" . $_POST['mobile_phone'] .
	"' , `qq`='" . $_POST['qq'] . "'",
	"`user_id`='" . $_GET['detail'] . "'", 1
);
if ($t == false) {
	echo "<div class='return error'>修改失败，请检查输入数据！</div>";
}
else {
	echo "<div class='return success'>修改成功！</div>";
}
?>
