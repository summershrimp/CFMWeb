<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$db = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$result = $db->select("*", "admin_users", "`admin_name`='" . $_SESSION['username'] . "'", 1);
$result = $db->fetch($result);
if (isset($_GET['function'])) {
	switch ($_GET['function']) {
	case 'changepassword':
		require "f/changepassword.php";
		break;
	}
}
?>
<div class="boxdiv">
	<span class="titlespan">个人信息</span>
	<div>
		<span class="fixed">用户名：</span>
		<span><?php echo $result['admin_name']; ?></span>
		<br>
		<span class="fixed">电子邮箱：</span>
		<span><?php echo $result['email']; ?></span>
		<br>
		<span class="fixed">电话：</span>
		<span><?php echo $result['phone']; ?></span>
		<br>
		<span class="fixed">权限等级：</span>
		<span><?php echo $result['privilage']; ?></span>
		<br>
		<span class="fixed">上次登录IP：</span>
		<span><?php echo $result['last_ip']; ?></span>
		<p></p>
	</div>
</div>
<div class="boxdiv">
	<span class="titlespan">修改密码</span>
	<form action="?page=personal&function=changepassword" method="post">
		<span class="fixed">原密码：</span>
		<input class="text" type="password" name="old">
		<br>
		<span class="fixed">新密码：</span>
		<input class="text" type="password" name="new">
		<br>
		<span class="fixed">重复新密码：</span>
		<input class="text" type="password" name="rep">
		<p class="psubmit">
			<input class="button" type="submit" value="提交">
			<input class="button" type="reset" value="重置">
		</p>
	</form>
</div>
