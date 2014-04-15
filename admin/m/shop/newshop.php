<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
if (isset($_POST['name']) && isset($_POST['owner']) &&
	isset($_POST['phone']) && isset($_POST['pos']) && isset($_POST['desc']) &&
	$_POST['name'] != "" && $_POST['owner'] != "" &&
	$_POST['phone'] != "" && $_POST['pos'] != "" && $_POST['desc'] != "") {
	require "f/shop/newshop.php";
}
else if (isset($_POST['name']) && $_POST['name'] != "" ||
	isset($_POST['owner']) && $_POST['owner'] != "" ||
	isset($_POST['phone']) && $_POST['phone'] != "" ||
	isset($_POST['pos']) && $_POST['pos'] != "" ||
	isset($_POST['desc']) && $_POST['desc'] != "") {
	echo "<div class='returnerror'>表格中存在未填项！</div>";
}
?>
<div class="boxdiv">
	<span class="titlespan dep2">添加商家</span>
	<form action="?page=shop&function=newshop" method="post">
		<table>
			<tr class="trtitle">
				<td style="width:100px;">属性</td>
				<td style="width:200px;">值</td>
				<!--<td style="width:400px;">备注</td>-->
			</tr>
			<tr class="tr0">
				<td>* 名称</td>
				<td><input class="text" type="text" name="name" onblur="ajax('tablename', 'shop', 'shop_name', this.value);"></td>
				<!--<td id="tablename"></td>-->
			</tr>
			<tr class="tr1">
				<td>* 业主ID</td>
				<td><input class="text" type="text" name="owner" onblur="ajax('tableowner', 'shop', 'shop_owner_id', this.value);"></td>
				<!--<td id="tableowner"></td>-->
			</tr>
			<tr class="tr0">
				<td>* 电话</td>
				<td><input class="text" type="text" name="phone" onblur="ajax('tablephone', 'shop', 'shop_phone', this.value);"></td>
				<!--<td id="tablephone"></td>-->
			</tr>
			<tr class="tr1">
				<td>* 位置</td>
				<td><input class="text" type="text" name="pos" onblur="ajax('tablepos', 'shop', 'shop_pos', this.value);"></td>
				<!--<td id="tablepos"></td>-->
			</tr>
			<tr class="tr0">
				<td>* 描述</td>
				<td><textarea class="text" type="text" name="desc"></textarea></td>
				<!--<td id="tabledesc"><span class='valid'>商家描述建议不要太短</span></td>-->
			</tr>
		</table>
		<p class="psubmit">
			<input class="button" type="submit" value="添加">
			<input class="button" type="reset">
			<a href="?page=shop"><input class="button" type="button" value="返回"></a>
		</p>
	</form>
</div>
