<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
if (isset($_POST['user_id']) && isset($_POST['user_realname']) &&
	isset($_POST['user_phone']) && isset($_POST['address']) &&
	$_POST['user_id'] != "" && $_POST['user_realname'] != "" &&
	$_POST['user_phone'] != "" && $_POST['address'] != "") {
	require "f/address/editaddress.php";
}
else if (isset($_POST['user_id']) && $_POST['user_id'] != "" ||
	isset($_POST['user_realname']) && $_POST['user_realname'] != "" ||
	isset($_POST['user_phone']) && $_POST['user_phone'] != "" ||
	isset($_POST['address']) && $_POST['address'] != "") {
	echo "<div class='return error'>表格中存在未填项！</div>";
}
$result = $GLOBALS['db']->select("*", "user_address", "`$row`='$get'", 1);
$result = $GLOBALS['db']->fetch($result);
$result = safe_output($result);
?>
<div class="boxdiv">
	<span class="titlespan dep2">编辑用户真实信息（id=<?php echo $result['addr_id']; ?>）</span>
	<form action="?page=address&function=editaddress&detail=<?php echo $result['addr_id']; ?>" method="post">
		<table>
			<tr class="trtitle">
				<td style="width:100px;">属性</td>
				<td style="width:200px;">值</td>
			</tr>
			<tr class="tr0">
				<td>用户ID</td>
				<td><input class="text" type="text" name="user_id" value="<?php echo $result['user_id']; ?>"></td>
			</tr>
			<tr class="tr1">
				<td>真实姓名</td>
				<td><input class="text" type="text" name="user_realname" value="<?php echo $result['user_realname']; ?>"></td>
			</tr>
			<tr class="tr0">
				<td>手机</td>
				<td><input class="text" type="text" name="user_phone" value="<?php echo $result['user_phone']; ?>"></td>
			</tr>
			<tr class="tr1">
				<td>住址</td>
				<td><textarea class="text" type="text" name="address"><?php echo $result['address']; ?></textarea></td>
			</tr>
		</table>
		<p class="psubmit">
			<input class="button" type="submit" value="修改">
			<input class="button" type="reset">
			<a href="?page=address"><input class="button" type="button" value="返回"></a>
		</p>
	</form>
</div>
