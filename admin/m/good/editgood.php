<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
if (isset($_POST['shop_id']) &&
	isset($_POST['price']) && isset($_POST['onsales']) &&
	isset($_POST['good_name']) && isset($_POST['good_desc']) &&
	$_POST['shop_id'] != "" &&
	$_POST['price'] != "" && $_POST['onsales'] != "" &&
	$_POST['good_name'] != "" && $_POST['good_desc'] != "") {
	require "f/good/editgood.php";
}
else if (isset($_POST['shop_id']) && $_POST['shop_id'] != "" ||
	isset($_POST['price']) && $_POST['price'] != "" ||
	isset($_POST['onsales']) && $_POST['onsales'] != "" ||
	isset($_POST['good_name']) && $_POST['good_name'] != "" ||
	isset($_POST['good_desc']) && $_POST['good_desc'] != "") {
	echo "<div class='return error'>表格中存在未填项！</div>";
}
$result = $db->select("*", "shop_goods", "`$row`='$get'", 1);
$result = $db->fetch($result);
?>
<div class="boxdiv">
	<span class="titlespan dep2">编辑商品信息（id=<?php echo $result['good_id']; ?>）</span>
	<form action="?page=good&function=editgood&detail=<?php echo $result['good_id']; ?>" method="post">
		<table>
			<tr class="trtitle">
				<td style="width:100px;">属性</td>
				<td style="width:200px;">值</td>
			</tr>
			<tr class="tr0">
				<td>商家ID</td>
				<td><input class="text" type="text" name="shop_id" value="<?php echo $result['shop_id']; ?>"></td>
			</tr>
			<tr class="tr1">
				<td>价格</td>
				<td><input class="text" type="text" name="price" value="<?php echo $result['price']; ?>"></td>
			</tr>
			<tr class="tr0">
				<td>在售状态</td>
				<td>
					<span><input type="radio" name="onsales" value="0"<?php if ($result['onsales'] == 0) echo "checked"; ?>>在售</span>
					<span><input type="radio" name="onsales" value="1"<?php if ($result['onsales'] == 1) echo "checked"; ?>>脱销</span>
				</td>
			</tr>
			<tr class="tr1">
				<td>商品名称</td>
				<td><input class="text" type="text" name="good_name" value="<?php echo $result['good_name']; ?>"></td>
			</tr>
			<tr class="tr0">
				<td>商品描述</td>
				<td><textarea class="text" type="text" name="good_desc"><?php echo $result['good_desc']; ?></textarea></td>
			</tr>
		</table>
		<p class="psubmit">
			<input class="button" type="submit" value="修改">
			<input class="button" type="reset">
			<a href="?page=good"><input class="button" type="button" value="返回"></a>
		</p>
	</form>
</div>
