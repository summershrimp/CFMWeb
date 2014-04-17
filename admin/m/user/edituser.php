<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
if (isset($_POST['user_name']) &&
	isset($_POST['email']) && isset($_POST['sex']) &&
	isset($_POST['mobile_phone']) && isset($_POST['qq']) &&
	$_POST['user_name'] != "" &&
	$_POST['email'] != "" && $_POST['sex'] != "" &&
	$_POST['mobile_phone'] != "" && $_POST['qq'] != "") {
	require "f/user/edituser.php";
}
else if (isset($_POST['user_name']) && $_POST['user_name'] != "" ||
	isset($_POST['email']) && $_POST['email'] != "" ||
	isset($_POST['sex']) && $_POST['sex'] != "" ||
	isset($_POST['mobile_phone']) && $_POST['mobile_phone'] != "" ||
	isset($_POST['qq']) && $_POST['qq'] != "") {
	echo "<div class='return error'>表格中存在未填项！</div>";
}
$result = $db->select("*", "customers", "`$row`='$get'", 1);
$result = $db->fetch($result);
?>
<div class="boxdiv">
	<span class="titlespan dep2">编辑用户信息（id=<?php echo $result['user_id']; ?>）</span>
	<form action="?page=user&function=edituser&detail=<?php echo $result['user_id']; ?>" method="post">
		<table>
			<tr class="trtitle">
				<td style="width:100px;">属性</td>
				<td style="width:200px;">值</td>
			</tr>
			<tr class="tr0">
				<td>用户名</td>
				<td><input class="text" type="text" name="user_name" value="<?php echo $result['user_name']; ?>"></td>
			</tr>
			<tr class="tr1">
				<td>邮箱</td>
				<td><input class="text" type="text" name="email" value="<?php echo $result['email']; ?>"></td>
			</tr>
			<tr class="tr0">
				<td>性别</td>
				<td>
					<span><input type="radio" name="sex" value="0"<?php if ($result['sex'] == 0) echo "checked"; ?>>男</span>
					<span><input type="radio" name="sex" value="1"<?php if ($result['sex'] == 1) echo "checked"; ?>>女</span>
				</td>
			</tr>
			<tr class="tr1">
				<td>手机</td>
				<td><input class="text" type="text" name="mobile_phone" value="<?php echo $result['mobile_phone']; ?>"></td>
			</tr>
			<tr class="tr0">
				<td>QQ</td>
				<td><input class="text" type="text" name="qq" value="<?php echo $result['qq']; ?>"></td>
			</tr>
		</table>
		<p class="psubmit">
			<input class="button" type="submit" value="修改">
			<input class="button" type="reset">
			<a href="?page=user"><input class="button" type="button" value="返回"></a>
		</p>
	</form>
</div>
