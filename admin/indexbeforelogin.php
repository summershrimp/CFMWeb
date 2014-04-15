<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>后台管理</title>
	<link rel="stylesheet" type="text/css" href="css/common.css">
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
	<div id="login" class="boxdiv">
		<span class="titlespan dep2">登录</span>
		<form action="?action=login" method="post">
			<p style="font-weight:bold">
				<span class="fixed">用户名：</span>
				<input class="text" type="text" name="username">
				<br>
				<span class="fixed">密码：</span>
				<input class="text" type="password" name="password">
			</p>
			<p class="psubmit">
				<input class="button" type="submit" value="提交">
				<input class="button" type="reset" value="重置">
			</p>
		</form>
	</div>
</body>
</html>
