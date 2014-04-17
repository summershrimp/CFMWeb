<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
if (isset($_POST['shop_id']) && isset($_POST['unavail']) &&
	isset($_POST['price']) && isset($_POST['onsale']) &&
	isset($_POST['good_name']) && isset($_POST['good_desc']) &&
	$_POST['shop_id'] != "" && $_POST['unavail'] != "" &&
	$_POST['price'] != "" && $_POST['onsale'] != "" &&
	$_POST['good_name'] != "" && $_POST['good_desc'] != "") {
	require "f/good/newgood.php";
}
else if (isset($_POST['shop_id']) && $_POST['shop_id'] != "" ||
	isset($_POST['price']) && $_POST['price'] != "" ||
	isset($_POST['onsale']) && $_POST['onsale'] != "" ||
	isset($_POST['good_name']) && $_POST['good_name'] != "" ||
	isset($_POST['good_desc']) && $_POST['good_desc'] != "" ||
	isset($_POST['unavail']) && $_POST['unavail'] != "") {
	echo "<div class='return error'>表格中存在未填项！</div>";
}
?>
<div class="boxdiv">
	<span class="titlespan dep2">添加商品</span>
	<form action="?page=good&function=newgood" method="post">
		<table>
			<tr class="trtitle">
				<td style="width:100px;">属性</td>
				<td style="width:200px;">值</td>
			</tr>
			<tr class="tr0">
				<td>商家ID</td>
				<td><input class="text" type="text" name="shop_id"></td>
			</tr>
			<tr class="tr1">
				<td>价格</td>
				<td><input class="text" type="text" name="price"></td>
			</tr>
			<tr class="tr0">
				<td>人气美食</td>
				<td>
					<span><input type="checkbox" name="onsale" value="1"></span>
				</td>
			</tr>
			<tr class="tr1">
				<td>商品名称</td>
				<td><input class="text" type="text" name="good_name"></td>
			</tr>
			<tr class="tr0">
				<td>商品描述</td>
				<td><textarea class="text" type="text" name="good_desc"></textarea></td>
			</tr>
			<tr class="tr1">
				<td>在售状态</td>
				<td>
					<span><input type="radio" name="unavail" value="0" checked>在售</span>
					<span><input type="radio" name="unavail" value="1">脱销</span>
				</td>
			</tr>
		</table>
		<p class="psubmit">
			<input class="button" type="submit" value="添加">
			<input class="button" type="reset">
			<a href="?page=good"><input class="button" type="button" value="返回"></a>
		</p>
	</form>
</div>
