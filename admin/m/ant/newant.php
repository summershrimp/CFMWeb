<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
if (isset($_POST['name']) && isset($_POST['email']) &&
	isset($_POST['real_name']) && isset($_POST['sex']) && isset($_POST['mobile']) &&
	$_POST['name'] != "" && $_POST['email'] != "" &&
	$_POST['real_name'] != "" && $_POST['sex'] != "" && $_POST['mobile'] != "") {
	require "f/ant/newant.php";
}
else if (isset($_POST['name']) && $_POST['name'] != "" ||
	isset($_POST['email']) && $_POST['email'] != "" ||
	isset($_POST['real_name']) && $_POST['real_name'] != "" ||
	isset($_POST['sex']) && $_POST['sex'] != "" ||
	isset($_POST['mobile']) && $_POST['mobile'] != "") {
	echo "<div class='returnerror'>表格中存在未填项！</div>";
}
?>
<div class="boxdiv">
	<span class="titlespan">添加Ant</span>
	<form action="?page=ant&function=newant" method="post">
		<table class="table">
			<tr class="trtitle">
				<td style="width:100px;">属性</td>
				<td style="width:200px;">值</td>
				<td style="width:200px;">备注</td>
			</tr>
			<tr class="tr0">
				<td>名称</td>
				<td><input class="text" type="text" name="name"></td>
				<td id="tablename"></td>
			</tr>
			<tr class="tr1">
				<td>邮箱</td>
				<td><input class="text" type="text" name="email"></td>
				<td id="tableemail"></td>
			</tr>
			<tr class="tr0">
				<td>真实姓名</td>
				<td><input class="text" type="text" name="real_name"></td>
				<td id="tablerealname"></td>
			</tr>
			<tr class="tr1">
				<td>性别</td>
				<td>
					<span><input type="radio" name="sex" value="0" ckecked>男</span>
					<span><input type="radio" name="sex" value="1" ckecked>女</span>
				</td>
				<td id="tablesex"></td>
			</tr>
			<tr class="tr0">
				<td>手机</td>
				<td><input class="text" type="text" name="mobile"></td>
				<td id="tablemobile"></td>
			</tr>
		</table>
		<p class="psubmit">
			<input class="button" type="submit" value="添加">
			<input class="button" type="reset">
		</p>
	</form>
</div>
