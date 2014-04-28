<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
if (!isset($_GET['pr'])) {
	$_GET['pr'] = 1;
}
$filter = false;
if (isset($_GET['function'])) {
	switch ($_GET['function']) {
	case 'editorder':
		check_and_open('order_info', 'detail', "m/order/editorder.php", 'order_id', true, "订单");
		break;
	case 'deleteorder':
		check_and_open('order_info', 'detail', "f/order/deleteorder.php", 'order_id', false, "订单");
		break;
	case 'deleteorders':
		require "f/order/deleteorders.php";
		break;
	case 'neworder':
		require "m/order/neworder.php";
		exit();
		break;
	case 'filter':
		$filter = true;
	}
}
$cond = "";
if ($filter == true) {
	$cond = contact_condition($cond, 'order_id');
	$cond = contact_condition($cond, 'user_id');
	$cond = contact_condition($cond, 'ant_id');
	$cond = contact_condition($cond, 'address', false);
	if (isset($_POST['order_status']) && $_POST['order_status'] != -1) $cond = contact_condition($cond, 'order_status');
	if (isset($_POST['ant_status']) && $_POST['ant_status'] != -1) $cond = contact_condition($cond, 'ant_status');
	if (isset($_POST['confirm_status']) && $_POST['confirm_status'] != -1) $cond = contact_condition($cond, 'confirm_status');
	if (isset($_POST['shipping_status']) && $_POST['shipping_status'] != -1) $cond = contact_condition($cond, 'shipping_status');
	if (isset($_POST['taking_status']) && $_POST['taking_status'] != -1) $cond = contact_condition($cond, 'taking_status');
	if (isset($_POST['pay_status']) && $_POST['pay_status'] != -1) $cond = contact_condition($cond, 'pay_status');
	$cond = contact_condition($cond, 'pay_id');
	if (isset($_POST['add_date'])) {
		switch ($_POST['add_date']) {
		case '一天之内':
			if ($cond != "") {
				$cond .= " AND ";
			}
			$cond .= "`add_date`>=NOW()-01000000 AND `add_date`<=NOW()";
			break;
		case '一周之内':
			if ($cond != "") {
				$cond .= " AND ";
			}
			$cond .= "`add_date`>=NOW()-07000000 AND `add_date`<=NOW()";
			break;
		case '一月之内':
			if ($cond != "") {
				$cond .= " AND ";
			}
			$cond .= "`add_date`>=NOW()-0100000000 AND `add_date`<=NOW()";
			break;
		}
	}
}
$_POST = safe_output($_POST);
?>
<div class="boxdiv">
	<span class="titlespan dep1">订单信息管理<span class="commit">» 用户的订单数量随着时间逐渐增加</span></span>
</div>
<div class="boxdiv">
	<span class="titlespan dep2">搜索订单</span>
	<form action="?page=order&function=filter" method="post">
		<span class="fixed">订单ID：</span>
		<input class="text" type="text" name="order_id" placeholder="依据订单ID过滤" value="<?php if (isset($_POST['order_id'])) echo $_POST['order_id']; ?>"><br>
		<span class="fixed">用户ID：</span>
		<input class="text" type="text" name="user_id" placeholder="依据用户ID过滤" value="<?php if (isset($_POST['user_id'])) echo $_POST['user_id']; ?>"><br>
		<span class="fixed">AntID：</span>
		<input class="text" type="text" name="ant_id" placeholder="依据AntID过滤" value="<?php if (isset($_POST['ant_id'])) echo $_POST['ant_id']; ?>"><br>
		<span class="fixed">地址：</span>
		<input class="text" type="text" name="address" placeholder="依据地址过滤" value="<?php if (isset($_POST['address'])) echo $_POST['address']; ?>">
		<span class="tooltip">支持模糊搜索</span><br>
		<span class="fixed">用户已下单：</span>
		<span><input type="radio" name="order_status" value="-1" <?php if (!isset($_POST['order_status']) || $_POST['order_status'] == -1) echo "checked"; ?>>全部</span>&nbsp;
		<span><input type="radio" name="order_status" value="1" <?php if (isset($_POST['order_status']) && $_POST['order_status'] == 1) echo "checked"; ?>>是</span>&nbsp;
		<span><input type="radio" name="order_status" value="0" <?php if (isset($_POST['order_status']) && $_POST['order_status'] == 0) echo "checked"; ?>>否</span><br>
		<span class="fixed">Ant已接单：</span>
		<span><input type="radio" name="ant_status" value="-1" <?php if (!isset($_POST['ant_status']) || $_POST['ant_status'] == -1) echo "checked"; ?>>全部</span>&nbsp;
		<span><input type="radio" name="ant_status" value="1" <?php if (isset($_POST['ant_status']) && $_POST['ant_status'] == 1) echo "checked"; ?>>是</span>&nbsp;
		<span><input type="radio" name="ant_status" value="0" <?php if (isset($_POST['ant_status']) && $_POST['ant_status'] == 0) echo "checked"; ?>>否</span><br>
		<span class="fixed">商家已确认：</span>
		<span><input type="radio" name="confirm_status" value="-1" <?php if (!isset($_POST['confirm_status']) || $_POST['confirm_status'] == -1) echo "checked"; ?>>全部</span>&nbsp;
		<span><input type="radio" name="confirm_status" value="1" <?php if (isset($_POST['confirm_status']) && $_POST['confirm_status'] == 1) echo "checked"; ?>>是</span>&nbsp;
		<span><input type="radio" name="confirm_status" value="0" <?php if (isset($_POST['confirm_status']) && $_POST['confirm_status'] == 0) echo "checked"; ?>>否</span><br>
		<span class="fixed">Ant已送货：</span>
		<span><input type="radio" name="shipping_status" value="-1" <?php if (!isset($_POST['shipping_status']) || $_POST['shipping_status'] == -1) echo "checked"; ?>>全部</span>&nbsp;
		<span><input type="radio" name="shipping_status" value="1" <?php if (isset($_POST['shipping_status']) && $_POST['shipping_status'] == 1) echo "checked"; ?>>是</span>&nbsp;
		<span><input type="radio" name="shipping_status" value="0" <?php if (isset($_POST['shipping_status']) && $_POST['shipping_status'] == 0) echo "checked"; ?>>否</span><br>
		<span class="fixed">用户已取货：</span>
		<span><input type="radio" name="taking_status" value="-1" <?php if (!isset($_POST['taking_status']) || $_POST['taking_status'] == -1) echo "checked"; ?>>全部</span>&nbsp;
		<span><input type="radio" name="taking_status" value="1" <?php if (isset($_POST['taking_status']) && $_POST['taking_status'] == 1) echo "checked"; ?>>是</span>&nbsp;
		<span><input type="radio" name="taking_status" value="0" <?php if (isset($_POST['taking_status']) && $_POST['taking_status'] == 0) echo "checked"; ?>>否</span><br>
		<span class="fixed">用户已付款：</span>
		<span><input type="radio" name="pay_status" value="-1" <?php if (!isset($_POST['pay_status']) || $_POST['pay_status'] == -1) echo "checked"; ?>>全部</span>&nbsp;
		<span><input type="radio" name="pay_status" value="1" <?php if (isset($_POST['pay_status']) && $_POST['pay_status'] == 1) echo "checked"; ?>>是</span>&nbsp;
		<span><input type="radio" name="pay_status" value="0" <?php if (isset($_POST['pay_status']) && $_POST['pay_status'] == 0) echo "checked"; ?>>否</span><br>
		<span class="fixed">支付记录ID：</span>
		<input class="text" type="text" name="pay_id" placeholder="依据支付记录ID过滤" value="<?php if (isset($_POST['pay_id'])) echo $_POST['pay_id']; ?>"><br>
		<span class="fixed">添加日期：</span>
		<select style="width:180px;" name="add_date">
			<option <?php if (isset($_POST['add_date']) && $_POST['add_date'] == "全部") echo 'selected="selected"'; ?>>全部</option>
			<option <?php if (isset($_POST['add_date']) && $_POST['add_date'] == "一天之内") echo 'selected="selected"'; ?>>一天之内</option>
			<option <?php if (isset($_POST['add_date']) && $_POST['add_date'] == "一周之内") echo 'selected="selected"'; ?>>一周之内</option>
			<option <?php if (isset($_POST['add_date']) && $_POST['add_date'] == "一月之内") echo 'selected="selected"'; ?>>一月之内</option>
		</select><br>
		<p class="psubmit">
			<input class="button" type="submit" value="搜索">
			<input class="button" type="reset">
		</p>
	</form>
</div>
<div class="boxdiv">
	<span class="titlespan dep2">订单列表</span>
	<?php $show = make_page_controller("order", "order_info", "order_id", $cond, $_GET['pr']); ?>
	<form id="del" action="?page=order&function=deleteorders" method="post">
		<table style="margin-right:20px;">
			<tr class="trtitle">
				<td></td>
				<td style="width:20px;">#</td>
				<td>操作</td>
				<td>ID</td>
				<td>用户ID</td>
				<td>AntID</td>
				<td>地址</td>
				<td>已下单</td>
				<td>已接单</td>
				<td>已确认</td>
				<td>已送货</td>
				<td>已取货</td>
				<td>已付款</td>
				<td>支付记录ID</td>
				<td>添加日期</td>
			</tr>
			<?php
			if ($show == true) {
				$result = $GLOBALS['db']->get_page_content("*", "order_info", $cond, $_GET['pr']);
				if ($result != false) {
					$count = 0;
					while ($order = $GLOBALS['db']->fetch($result)) {
						$order = safe_output($order);
						$count++;
						$style = ($count - 1) % 2;
						echo "<tr class='tr$style'>";
						echo "<td style='text-align:center;'><input type='checkbox' name='chk[]' value='" . $order['order_id'] . "'></td>";
						echo "<td>$count</td>";
						echo "<td>";
						echo "<a href='?page=order&function=editorder&detail=" . $order['order_id'] . "'>";
						echo "<img src='images/icon_edit.png' alt='修改'>";
						echo "<span class='link'>修改</span></a>&nbsp;";
						echo "<a href='javascript:del(\"?page=order&function=deleteorder&detail=" . $order['order_id'] . "\")'>";
						echo "<img src='images/icon_del.png' alt='删除'>";
						echo "<span class='link'>删除</span></a>";
						echo "</td>";
						echo "<td>" . $order['order_id'] . "</td>";
						echo "<td>" . $order['user_id'] . "</td>";
						echo "<td>" . $order['ant_id'] . "</td>";
						echo "<td class='tdclip'>" . $order['address'] . "</td>";
						echo "<td>" . ($order['order_status'] == 1 ? "是" : "否") . "</td>";
						echo "<td>" . ($order['ant_status'] == 1 ? "是" : "否") . "</td>";
						echo "<td>" . ($order['confirm_status'] == 1 ? "是" : "否") . "</td>";
						echo "<td>" . ($order['shipping_status'] == 1 ? "是" : "否") . "</td>";
						echo "<td>" . ($order['taking_status'] == 1 ? "是" : "否") . "</td>";
						echo "<td>" . ($order['pay_status'] == 1 ? "是" : "否") . "</td>";
						echo "<td>" . $order['pay_id'] . "</td>";
						echo "<td>" . $order['add_date'] . "</td>";
						echo "</tr>";
					}
				}
			}
			?>
		</table>
		<p class="psubmit">
			<a href="?page=order&function=neworder"><input class="button" style="float:left;" type="button" value="添加订单信息"></a>
			<a href="javascript:dels()"><input class="button dangerousbutton" type="button" value="批量删除"></a>
			<input class="button" type="reset" value="重新选择">
		</p>
	</form>
</div>
