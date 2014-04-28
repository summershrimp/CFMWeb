<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
if (isset($_POST['shop_name']) && isset($_POST['owner_id']) &&
	isset($_POST['shop_phone']) && isset($_POST['shop_pos']) && isset($_POST['shop_desc']) &&
	$_POST['shop_name'] != "" && $_POST['owner_id'] != "" &&
	$_POST['shop_phone'] != "" && $_POST['shop_pos'] != "" && $_POST['shop_desc'] != "") {
	require "f/shop/newshop.php";
}
else if (isset($_POST['shop_name']) && $_POST['shop_name'] != "" ||
	isset($_POST['owner_id']) && $_POST['owner_id'] != "" ||
	isset($_POST['shop_phone']) && $_POST['shop_phone'] != "" ||
	isset($_POST['shop_pos']) && $_POST['shop_pos'] != "" ||
	isset($_POST['shop_desc']) && $_POST['shop_desc'] != "") {
	echo "<div class='return error'>表格中存在未填项！</div>";
}
?>
<div class="boxdiv">
	<span class="titlespan dep2">添加商家</span>
	<form action="?page=shop&function=newshop" method="post">
		<table>
			<tr class="trtitle">
				<td style="width:100px;">属性</td>
				<td style="width:200px;">值</td>
			</tr>
			<tr class="tr0">
				<td>商家名称</td>
				<td><input class="text" type="text" name="shop_name"></td>
			</tr>
			<tr class="tr1">
				<td>电话</td>
				<td><input class="text" type="text" name="shop_phone"></td>
			</tr>
			<tr class="tr0">
				<td>位置</td>
				<td><input class="text" type="text" name="shop_pos"></td>
			</tr>
			<tr class="tr1">
				<td>业主ID</td>
				<td>
					<input onblur="ajax('owner_id','shop','shop_owner_id',this.value,'0')" class="text" type="text" name="owner_id">
					<span id="owner_id" class="ajaxresult"></span>
				</td>
			</tr>
			<tr class="tr0">
				<td>描述</td>
				<td><textarea class="text" type="text" name="shop_desc"></textarea></td>
			</tr>
		</table>
		<p class="psubmit">
			<input class="button" type="submit" value="添加">
			<input class="button" type="reset">
			<a href="?page=shop"><input class="button" type="button" value="返回"></a>
		</p>
	</form>
</div>
