<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
if (isset($_POST['user_id']) &&
	isset($_POST['ant_id']) && isset($_POST['address']) &&
	isset($_POST['order_status']) && isset($_POST['ant_status']) &&
	isset($_POST['confirm_status']) && isset($_POST['taking_status']) &&
	isset($_POST['shipping_status']) && isset($_POST['pay_status']) &&
	isset($_POST['pay_id']) && isset($_POST['add_date']) &&
	$_POST['user_id'] != "" &&
	$_POST['ant_id'] != "" && $_POST['address'] != "" &&
	$_POST['order_status'] != "" && $_POST['ant_status'] != "" &&
	$_POST['confirm_status'] != "" && $_POST['taking_status'] != "" &&
	$_POST['shipping_status'] != "" && $_POST['pay_status'] != "" &&
	$_POST['pay_id'] != "" && $_POST['add_date'] != "") {
	require "f/order/editorder.php";
}
else if (isset($_POST['user_id']) && $_POST['user_id'] != "" ||
	isset($_POST['ant_id']) && $_POST['ant_id'] != "" ||
	isset($_POST['address']) && $_POST['address'] != "" ||
	isset($_POST['order_status']) && $_POST['order_status'] != "" ||
	isset($_POST['ant_status']) && $_POST['ant_status'] != "" ||
	isset($_POST['confirm_status']) && $_POST['confirm_status'] != "" ||
	isset($_POST['taking_status']) && $_POST['taking_status'] != "" ||
	isset($_POST['shipping_status']) && $_POST['shipping_status'] != "" ||
	isset($_POST['pay_status']) && $_POST['pay_status'] != "" ||
	isset($_POST['pay_id']) && $_POST['pay_id'] != "" ||
	isset($_POST['add_date']) && $_POST['add_date'] != "") {
	echo "<div class='return error'>表格中存在未填项！</div>";
}
$result = $GLOBALS['db']->select("*", "order_info", "`$row`='$get'", 1);
$result = $GLOBALS['db']->fetch($result);
$result = safe_output($result);
?>
<div class="boxdiv">
	<span class="titlespan dep2">编辑订单信息（id=<?php echo $result['order_id']; ?>）</span>
	<form action="?page=order&function=editorder&detail=<?php echo $result['order_id']; ?>" method="post">
		<table>
			<tr class="trtitle">
				<td style="width:100px;">属性</td>
				<td style="width:200px;">值</td>
			</tr>
			<tr class="tr0">
				<td>用户ID</td>
				<td><input class="text" type="text" name="user_id" value="<?php echo $result['user_id']; ?>"></td>
			</tr>
			<tr class="tr1">
				<td>AntID</td>
				<td><input class="text" type="text" name="ant_id" value="<?php echo $result['ant_id']; ?>"></td>
			</tr>
			<tr class="tr0">
				<td>地址</td>
				<td><input class="text" type="text" name="address" value="<?php echo $result['address']; ?>"></td>
			</tr>
			<tr class="tr1">
				<td>用户已下单</td>
				<td>
					<span><input type="radio" name="order_status" value="1"<?php if ($result['order_status'] == 1) echo "checked"; ?>>是</span>
					<span><input type="radio" name="order_status" value="0"<?php if ($result['order_status'] == 0) echo "checked"; ?>>否</span>
				</td>
			</tr>
			<tr class="tr0">
				<td>Ant已接单</td>
				<td>
					<span><input type="radio" name="ant_status" value="1"<?php if ($result['ant_status'] == 1) echo "checked"; ?>>是</span>
					<span><input type="radio" name="ant_status" value="0"<?php if ($result['ant_status'] == 0) echo "checked"; ?>>否</span>
				</td>
			</tr>
			<tr class="tr1">
				<td>商家已确认</td>
				<td>
					<span><input type="radio" name="confirm_status" value="1"<?php if ($result['confirm_status'] == 1) echo "checked"; ?>>是</span>
					<span><input type="radio" name="confirm_status" value="0"<?php if ($result['confirm_status'] == 0) echo "checked"; ?>>否</span>
				</td>
			</tr>
			<tr class="tr0">
				<td>Ant已送货</td>
				<td>
					<span><input type="radio" name="shipping_status" value="1"<?php if ($result['shipping_status'] == 1) echo "checked"; ?>>是</span>
					<span><input type="radio" name="shipping_status" value="0"<?php if ($result['shipping_status'] == 0) echo "checked"; ?>>否</span>
				</td>
			</tr>
			<tr class="tr1">
				<td>用户已取货</td>
				<td>
					<span><input type="radio" name="taking_status" value="1"<?php if ($result['taking_status'] == 1) echo "checked"; ?>>是</span>
					<span><input type="radio" name="taking_status" value="0"<?php if ($result['taking_status'] == 0) echo "checked"; ?>>否</span>
				</td>
			</tr>
			<tr class="tr0">
				<td>用户已付款</td>
				<td>
					<span><input type="radio" name="pay_status" value="1"<?php if ($result['pay_status'] == 1) echo "checked"; ?>>是</span>
					<span><input type="radio" name="pay_status" value="0"<?php if ($result['pay_status'] == 0) echo "checked"; ?>>否</span>
				</td>
			</tr>
			<tr class="tr1">
				<td>支付记录ID</td>
				<td><input class="text" type="text" name="pay_id" value="<?php echo $result['pay_id']; ?>"></td>
			</tr>
			<tr class="tr0">
				<td>添加日期</td>
				<td><input class="text" type="text" name="add_date" value="<?php echo $result['add_date']; ?>"></td>
			</tr>
		</table>
		<p class="psubmit">
			<input class="button" type="submit" value="修改">
			<input class="button" type="reset">
			<a href="?page=order"><input class="button" type="button" value="返回"></a>
		</p>
	</form>
</div>
