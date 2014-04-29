<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
if (isset($_POST['provider_name']) && isset($_POST['email']) &&
	isset($_POST['sex']) && isset($_POST['mobile_phone']) && isset($_POST['qq']) &&
	$_POST['provider_name'] != "" && $_POST['email'] != "" &&
	$_POST['sex'] != "" && $_POST['mobile_phone'] != "" && $_POST['qq'] != "") {
	require "f/provider/newprovider.php";
}
else if (isset($_POST['provider_name']) && $_POST['provider_name'] != "" ||
	isset($_POST['email']) && $_POST['email'] != "" ||
	isset($_POST['sex']) && $_POST['sex'] != "" ||
	isset($_POST['mobile_phone']) && $_POST['mobile_phone'] != "" ||
	isset($_POST['qq']) && $_POST['qq'] != "") {
	echo "<div class='return error'>表格中存在未填项！</div>";
}
?>
<div class="boxdiv">
	<span class="titlespan dep2">添加业主</span>
	<form action="?page=provider&function=newprovider" method="post">
		<table>
			<tr class="trtitle">
				<td style="width:100px;">属性</td>
				<td style="width:200px;">值</td>
			</tr>
			<tr class="tr0">
				<td>业主名</td>
				<td><input class="text" type="text" name="provider_name"></td>
			</tr>
			<tr class="tr1">
				<td>邮箱</td>
				<td><input class="text" type="text" name="email"></td>
			</tr>
			<tr class="tr0">
				<td>性别</td>
				<td>
					<span><input type="radio" name="sex" value="0" checked>男</span>
					<span><input type="radio" name="sex" value="1">女</span>
				</td>
			</tr>
			<tr class="tr1">
				<td>手机</td>
				<td><input class="text" type="text" name="mobile_phone"></td>
			</tr>
			<tr class="tr0">
				<td>QQ</td>
				<td><input class="text" type="text" name="qq"></td>
			</tr>
		</table>
		<p class="psubmit">
			<input class="button" type="submit" value="添加">
			<input class="button" type="reset">
			<a href="?page=provider"><input class="button" type="button" value="返回"></a>
		</p>
	</form>
</div>
