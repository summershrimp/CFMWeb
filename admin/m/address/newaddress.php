<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
if (isset($_POST['user_id']) && isset($_POST['user_realname']) &&
	isset($_POST['user_phone']) && isset($_POST['address']) &&
	$_POST['user_id'] != "" && $_POST['user_realname'] != "" &&
	$_POST['user_phone'] != "" && $_POST['address'] != "") {
	require "f/address/newaddress.php";
}
else if (isset($_POST['user_id']) && $_POST['user_id'] != "" ||
	isset($_POST['user_realname']) && $_POST['user_realname'] != "" ||
	isset($_POST['user_phone']) && $_POST['user_phone'] != "" ||
	isset($_POST['address']) && $_POST['address'] != "") {
	echo "<div class='return error'>表格中存在未填项！</div>";
}
?>
<div class="boxdiv">
	<span class="titlespan dep2">添加用户真实信息</span>
	<form action="?page=address&function=newaddress" method="post">
		<table>
			<tr class="trtitle">
				<td style="width:100px;">属性</td>
				<td style="width:200px;">值</td>
			</tr>
			<tr class="tr0">
				<td>用户ID</td>
				<td><input class="text" type="text" name="user_id"></td>
			</tr>
			<tr class="tr1">
				<td>真实姓名</td>
				<td><input class="text" type="text" name="user_realname"></td>
			</tr>
			<tr class="tr0">
				<td>手机</td>
				<td><input class="text" type="text" name="user_phone"></td>
			</tr>
			<tr class="tr1">
				<td>住址</td>
				<td><textarea class="text" type="text" name="address"></textarea></td>
			</tr>
		</table>
		<p class="psubmit">
			<input class="button" type="submit" value="添加">
			<input class="button" type="reset">
			<a href="?page=address"><input class="button" type="button" value="返回"></a>
		</p>
	</form>
</div>
