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
$result = $GLOBALS['db']->select("*", "admin_users", "`admin_name`='$username'", 1);
$result = $GLOBALS['db']->fetch($result);
if (!isset($result['salt'])) {
	$salt = rand(1000, 9999);
	$result['salt'] = $salt;
	$result['admin_pass'] = md5($result['admin_pass'] . $salt);
	$GLOBALS['db']->update("admin_users", "`salt`='$salt'", "`admin_name`='$username'", 1);
	$GLOBALS['db']->update("admin_users", "`admin_pass`='" . $result['admin_pass'] . "'", "`admin_name`='$username'", 1);
}
$password = md5(md5($password) . $result['salt']);
if ($password == $result['admin_pass']) {
	if ($_SERVER["REMOTE_ADDR"]) {
		$ip = $_SERVER["REMOTE_ADDR"];
	}
	else {
		$ip = "Unknown";
	}
	$GLOBALS['db']->update("admin_users", "`last_ip`='$ip'", "`admin_name`='$username'", 1);
	$_SESSION['username'] = $username;
	echo "<meta http-equiv=\"refresh\" content=\"0; url=?\">";
}
else {
	echo "<script>alert('用户名或密码错误！');</script>";
	echo "<meta http-equiv=\"refresh\" content=\"0; url=?\">";
}
?>
