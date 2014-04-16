<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$db = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$filter = false;
if (isset($_GET['function'])) {
	switch ($_GET['function']) {
	case 'edituser':
		check_and_open($db, 'customers', 'detail', "m/user/edituser.php", 'user_id', true, "用户");
		break;
	case 'deleteuser':
		check_and_open($db, 'customers', 'detail', "f/user/deleteuser.php", 'user_id', false, "用户");
		break;
	case 'deleteusers':
		require "f/user/deleteusers.php";
		break;
	case 'newuser':
		require "m/user/newuser.php";
		exit();
		break;
	case 'filter':
		$filter = true;
	}
}
$cond = "";
if ($filter == true) {
	$cond = contact_condition($cond, 'user_id');
	$cond = contact_condition($cond, 'user_name', false);
	$cond = contact_condition($cond, 'email', false);
	if (isset($_POST['sex']) && $_POST['sex'] != -1) $cond = contact_condition($cond, 'sex');
	$cond = contact_condition($cond, 'mobile_phone');
	$cond = contact_condition($cond, 'qq');
	$cond = contact_condition($cond, 'openid');
}
if ($cond == "") {
	$cond = NULL;
}
?>
<div class="boxdiv">
	<span class="titlespan dep1">用户列表<span class="commit">» 为用户做最好的服务</span></span>
</div>
<div class="boxdiv">
	<span class="titlespan dep2">搜索用户</span>
	<form action="?page=user&function=filter" method="post">
		<span class="fixed">用户ID：</span>
		<input class="text" type="text" name="user_id" placeholder="依据用户ID过滤" value="<?php if (isset($_POST['user_id'])) echo $_POST['user_id']; ?>"><br>
		<span class="fixed">用户名：</span>
		<input class="text" type="text" name="user_name" placeholder="依据用户昵称过滤" value="<?php if (isset($_POST['user_name'])) echo $_POST['user_name']; ?>">
		<span class="tooltip">* 支持模糊搜索</span><br>
		<span class="fixed">邮箱：</span>
		<input class="text" type="text" name="email" placeholder="依据用户邮箱过滤" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
		<span class="tooltip">* 支持模糊搜索</span><br>
		<span class="fixed">性别：</span>
		<span><input type="radio" name="sex" value="-1" <?php if (!isset($_POST['sex']) || $_POST['sex'] == -1) echo "checked"; ?>>全部</span>&nbsp;
		<span><input type="radio" name="sex" value="0" <?php if (isset($_POST['sex']) && $_POST['sex'] == 0) echo "checked"; ?>>男</span>&nbsp;
		<span><input type="radio" name="sex" value="1" <?php if (isset($_POST['sex']) && $_POST['sex'] == 1) echo "checked"; ?>>女</span><br>
		<span class="fixed">手机：</span>
		<input class="text" type="text" name="mobile_phone" placeholder="依据用户手机过滤" value="<?php if (isset($_POST['mobile_phone'])) echo $_POST['mobile_phone']; ?>"><br>
		<span class="fixed">QQ：</span>
		<input class="text" type="text" name="qq" placeholder="依据用户QQ过滤" value="<?php if (isset($_POST['qq'])) echo $_POST['qq']; ?>"><br>
		<span class="fixed">OpenID：</span>
		<input class="text" type="text" name="openid" placeholder="依据用户OpenID过滤" value="<?php if (isset($_POST['openid'])) echo $_POST['openid']; ?>"><br>
		<p class="psubmit">
			<input class="button" type="submit" value="搜索">
			<input class="button" type="reset">
		</p>
	</form>
</div>
<div class="boxdiv"><span class="titlespan dep2">用户列表</span>
	<form action="#" method="post">
		<table style="margin-right:20px;">
			<tr class="trtitle">
				<td></td>
				<td style="width:20px;">#</td>
				<td>操作</td>
				<td>ID</td>
				<td>用户名</td>
				<td>邮箱</td>
				<td>性别</td>
				<td>手机</td>
				<td>QQ</td>
				<td>OpenID</td>
			</tr>
			<?php
			$result = $db->select("*", "customers", $cond);
			if ($result != false) {
				$count = 0;
				while ($user = $db->fetch($result)) {
					$count++;
					$style = ($count - 1) % 2;
					echo "<tr class='tr$style'>";
					echo "<td style='text-align:center;'><input type='checkbox' name='chk[]' value='" . $user['user_id'] . "'></td>";
					echo "<td>$count</td>";
					echo "<td>";
					echo "<a href='?page=user&function=edituser&detail=" . $user['user_id'] . "'>";
					echo "<img src='images/icon_edit.png' alt='修改'>";
					echo "<span class='link'>修改</span></a>&nbsp;";
					echo "<a href='javascript:del(\"?page=user&function=deleteuser&detail=" . $user['user_id'] . "\")'>";
					echo "<img src='images/icon_del.png' alt='删除'>";
					echo "<span class='link'>删除</span></a></td>";
					echo "<td>" . $user['user_id'] . "</td>";
					echo "<td>" . $user['user_name'] . "</td>";
					echo "<td>" . $user['email'] . "</td>";
					echo "<td>" . (($user['sex'] == 0) ? "男" : "女") . "</td>";
					echo "<td>" . $user['mobile_phone'] . "</td>";
					echo "<td>" . $user['qq'] . "</td>";
					echo "<td>" . $user['openid'] . "</td>";
					echo "</tr>";
				}
			}
			?>
		</table>
		<p class="psubmit">
			<a href="?page=user&function=newuser"><input class="button" style="float:left;" type="button" value="添加用户"></a>
			<a href="javascript:del('?page=user&function=deleteusers')"><input class="button dangerousbutton" type="button" value="批量删除"></a>
			<input class="button" type="reset" value="重新选择">
		</p>
	</form>
</div>

