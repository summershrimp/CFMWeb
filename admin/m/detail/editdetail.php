<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
if (isset($_POST['name']) && $_POST['name'] != "") {
	require "f/detail/editdetail.php";
}
$result = $db->select("*", "order_details", "`$row`='$get'", 1);
$result = $db->fetch($result);
?>
<div class="boxdiv">
	<span class="titlespan dep2">编辑订单细节信息（id=<?php echo $result['rec_id']; ?>）</span>
	<form action="?page=detail&function=editdetail&detail=<?php echo $result['rec_id']; ?>" method="post">
		<table>
			<tr class="trtitle">
				<td style="width:100px;">属性</td>
				<td style="width:200px;">值</td>
			</tr>
			<tr class="tr0">
				<td>订单ID</td>
				<td><input class="text" type="text" name="order_id" value="<?php echo $result['order_id']; ?>"></td>
			</tr>
			<tr class="tr1">
				<td>商品ID</td>
				<td><input class="text" type="text" name="good_id" value="<?php echo $result['good_id']; ?>"></td>
			</tr>
			<tr class="tr0">
				<td>商品名称</td>
				<td><input class="text" type="text" name="good_name" value="<?php echo $result['good_name']; ?>"></td>
			</tr>
			<tr class="tr1">
				<td>商品数量</td>
				<td><input class="text" type="text" name="good_number" value="<?php echo $result['good_number']; ?>"></td>
			</tr>
			<tr class="tr0">
				<td>商品价格</td>
				<td><input class="text" type="text" name="good_price" value="<?php echo $result['good_price']; ?>"></td>
			</tr>
		</table>
		<p class="psubmit">
			<input class="button" type="submit" value="修改">
			<input class="button" type="reset">
			<a href="?page=detail"><input class="button" type="button" value="返回"></a>
		</p>
	</form>
</div>
