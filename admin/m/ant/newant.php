<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
if (isset($_POST['ant_name']) && isset($_POST['email']) &&
	isset($_POST['ant_real_name']) && isset($_POST['sex']) && isset($_POST['mobile_phone']) &&
	$_POST['ant_name'] != "" && $_POST['email'] != "" &&
	$_POST['ant_real_name'] != "" && $_POST['sex'] != "" && $_POST['mobile_phone'] != "") {
	require "f/ant/newant.php";
}
else if (isset($_POST['ant_name']) && $_POST['ant_name'] != "" ||
	isset($_POST['email']) && $_POST['email'] != "" ||
	isset($_POST['ant_real_name']) && $_POST['ant_real_name'] != "" ||
	isset($_POST['sex']) && $_POST['sex'] != "" ||
	isset($_POST['mobile_phone']) && $_POST['mobile_phone'] != "") {
	echo "<div class='return error'>表格中存在未填项！</div>";
}
?>
<div class="boxdiv">
	<span class="titlespan dep2">添加Ant</span>
	<form action="?page=ant&function=newant" method="post">
		<table>
			<tr class="trtitle">
				<td style="width:100px;">属性</td>
				<td style="width:200px;">值</td>
			</tr>
			<tr class="tr0">
				<td>昵称</td>
				<td><input class="text" type="text" name="ant_name"></td>
			</tr>
			<tr class="tr1">
				<td>邮箱</td>
				<td><input class="text" type="text" name="email"></td>
			</tr>
			<tr class="tr0">
				<td>真实姓名</td>
				<td><input class="text" type="text" name="ant_real_name"></td>
			</tr>
			<tr class="tr1">
				<td>性别</td>
				<td>
					<span><input type="radio" name="sex" value="0" checked>男</span>
					<span><input type="radio" name="sex" value="1">女</span>
				</td>
			</tr>
			<tr class="tr0">
				<td>手机</td>
				<td><input class="text" type="text" name="mobile_phone"></td>
			</tr>
		</table>
		<p class="psubmit">
			<input class="button" type="submit" value="添加">
			<input class="button" type="reset">
			<a href="?page=ant"><input class="button" type="button" value="返回"></a>
		</p>
	</form>
</div>
