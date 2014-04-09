<?php
if (isset($_POST['old']) && isset($_POST['new']) && isset($_POST['rep'])) {
	if ($_POST['old'] == "" || $_POST['new'] == "" || $_POST['rep'] == "") {
		$str = "旧密码、新密码和重复密码均不能为空！";
		$status = "error";
	}
	else if ($_POST['new'] != $_POST['rep']) {
		$str = "两次输入的密码不一致！";
		$status = "error";
	}
	else {
		$username = $_SESSION['username'];
		$db = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$result = $db->select("*", "admin_users", "`admin_name`='$username'", 1);
		$result = $db->fetch($result);
		$old = md5($_POST['old']);
		if ($result['salt']) {
			$old=md5($old . $result['salt']);
		}
		if ($old != $result['admin_pass']) {
			$str = "旧密码输入错误！";
			$status = "error";
		}
		else {
			$password = md5($_POST['new']);
			if ($result['salt']) {
				$password=md5($password . $result['salt']);
			}
			$db->update("admin_users", "`admin_pass`='$password'", "`admin_name`='$username'", 1);
			$str = "修改成功！";
			$status = "success";
		}
	}
	echo "<div class=\"return$status\">$str</div>";
}
else if (isset($_POST['old']) || isset($_POST['new']) || isset($_POST['rep'])) {
	$str = "旧密码、新密码和重复密码均不能为空！";
	$status = "error";
	echo "<div class=\"return$status\">$str</div>";
}
else {
	echo "<meta http-equiv=\"refresh\" content=\"0; url=?page=personal\">";
}
?>
