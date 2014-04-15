<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
if (isset($_POST['old']) && $_POST['old'] != "") {
	$result = $db->select("*", "admin_users", "`admin_name`='$username'", 1);
	$result = $db->fetch($result);
	$old = $_POST['old'];
	if (!isset($result['salt'])) {
	$salt=rand(1000,9999);
	$result['salt']=$salt;
	$result['admin_pass']=md5($result['admin_pass'].$salt);
	$db->update("admin_users", "`salt`='$salt'", "`admin_name`='$username'", 1);
	$db->update("admin_users", "`admin_pass`='".$result['admin_pass']."'", "`admin_name`='$username'", 1);
	}
	
	$old=md5(md5($old) . $result['salt']);
	
	if ($old != $result['admin_pass']) {
		$str = "旧密码输入错误！";
		$status = "error";
	}
	else {
		if (isset($_POST['new']) && isset($_POST['rep']) && $_POST['new'] != "" && $_POST['rep'] != "") {
			if ($_POST['new'] != $_POST['rep']) {
				$str = "两次输入的密码不一致！";
				$status = "error";
			}
			else {
				$password = $_POST['new'];
				$password=md5(md5($password) . $result['salt']);
				
				$db->update("admin_users", "`admin_pass`='$password'", "`admin_name`='$username'", 1);
			}
		}
		if (isset($_POST['email']) && $_POST['email'] != "") {
			$db->update("admin_users", "`email`='" . $_POST['email'] . "'", "`admin_name`='$username'", 1);
		}
		if (isset($_POST['phone']) && $_POST['phone'] != "") {
			$db->update("admin_users", "`phone`='" . $_POST['phone'] . "'", "`admin_name`='$username'", 1);
		}
		$str = "修改成功！";
		$status = "success";
	}
}
else {
	$str = "旧密码不能为空！";
	$status = "error";
}
echo "<div class=\"return$status\">$str</div>";
?>
