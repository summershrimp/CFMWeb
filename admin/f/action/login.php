<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$username = $_POST['username'];
$password = $_POST['password'];
if ($username == "" || $password == "") {
	echo "<script>alert('用户名或密码不能为空！');</script>";
	echo "<meta http-equiv=\"refresh\" content=\"0; url=?\">";
	exit();
}
$db = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$result = $db->select("*", "admin_users", "`admin_name`='$username'", 1);
$result = $db->fetch($result);
if (isset($result['salt'])) {
	$password=md5($password . $result['salt']);
}
if ($password == $result['admin_pass']) {
	if ($_SERVER["REMOTE_ADDR"]) {
		$ip = $_SERVER["REMOTE_ADDR"];
	}
	else {
		$ip = "Unknown";
	}
	$db->update("admin_users", "`last_ip`='$ip'", "`admin_name`='$username'", 1);
	$_SESSION['username'] = $username;
	echo "<meta http-equiv=\"refresh\" content=\"0; url=?\">";
}
else {
	echo "<script>alert('用户名或密码错误！');</script>";
	echo "<meta http-equiv=\"refresh\" content=\"0; url=?\">";
}
?>
