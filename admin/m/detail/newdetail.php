<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
if (isset($_POST['name']) && isset($_POST['owner']) &&
	isset($_POST['phone']) && isset($_POST['pos']) && isset($_POST['desc']) &&
	$_POST['name'] != "" && $_POST['owner'] != "" &&
	$_POST['phone'] != "" && $_POST['pos'] != "" && $_POST['desc'] != "") {
	require "f/detail/newdetail.php";
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
	<span class="titlespan dep2">添加订单细节</span>
	<form action="?page=detail&function=newdetail" method="post">
		<table>
			<tr class="trtitle">
				<td style="width:100px;">属性</td>
				<td style="width:200px;">值</td>
			</tr>
			<tr class="tr0">
				<td>* 订单ID</td>
				<td><input class="text" type="text" name="order_id"></td>
			</tr>
			<tr class="tr1">
				<td>* 商品ID</td>
				<td><input class="text" type="text" name="good_id"></td>
			</tr>
			<tr class="tr0">
				<td>* 商品名称</td>
				<td><input class="text" type="text" name="good_name"></td>
			</tr>
			<tr class="tr1">
				<td>* 商品数量</td>
				<td><input class="text" type="text" name="good_number"></td>
			</tr>
			<tr class="tr0">
				<td>* 商品价格</td>
				<td><input class="text" type="text" name="good_price"></td>
			</tr>
		</table>
		<p class="psubmit">
			<input class="button" type="submit" value="添加">
			<input class="button" type="reset">
			<a href="?page=detail"><input class="button" type="button" value="返回"></a>
		</p>
	</form>
</div>
