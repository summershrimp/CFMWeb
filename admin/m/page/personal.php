<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$username = $_SESSION['username'];
if (isset($_GET['function'])) {
	switch ($_GET['function']) {
	case 'editpersonal':
		require "f/personal/editpersonal.php";
		break;
	}
}
$result = $GLOBALS['db']->select("*", "admin_users", "`admin_name`='$username'", 1);
$result = $GLOBALS['db']->fetch($result);
$result = safe_output($result);
?>
<div class="boxdiv">
	<span class="titlespan dep1">账户设置<span class="commit">» 在这里设置您的账户信息</span></span>
</div>
<div class="boxdiv">
	<span class="titlespan dep2">查看个人信息</span>
	<div>
		<span class="fixed">用户名：</span>
		<span><?php echo $result['admin_name']; ?></span><br>
		<span class="fixed">电子邮箱：</span>
		<span><?php echo $result['email']; ?></span><br>
		<span class="fixed">电话：</span>
		<span><?php echo $result['phone']; ?></span><br>
		<span class="fixed">权限等级：</span>
		<span><?php echo $result['privilage']; ?></span><br>
		<span class="fixed">上次登录IP：</span>
		<span><?php echo $result['last_ip']; ?></span>
		<p></p>
	</div>
</div>
<div class="boxdiv">
	<span class="titlespan dep2">修改个人信息</span>
	<form action="?page=personal&function=editpersonal" method="post">
		<span class="fixed" style="width:auto;">若想修改信息，请先输入旧密码。</span><br>
		<span class="fixed" style="width:auto;">若不想修改某条信息，则留空相应的输入框。</span><br><br>
		<span class="fixed">旧密码：</span>
		<input class="text" type="password" name="old"><br>
		<span class="fixed">新密码：</span>
		<input class="text" type="password" name="new"><br>
		<span class="fixed">重复新密码：</span>
		<input class="text" type="password" name="rep"><br>
		<span class="fixed">电子邮箱：</span>
		<input class="text" type="text" name="email"><br>
		<span class="fixed">电话：</span>
		<input class="text" type="text" name="phone">
		<p class="psubmit">
			<input class="button" type="submit" value="更新">
			<input class="button" type="reset" value="重置">
		</p>
	</form>
</div>
