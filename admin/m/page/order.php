<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$db = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$filter = false;
if (isset($_GET['function'])) {
	switch ($_GET['function']) {
	case 'filter':
		$filter = true;
		break;
	}
}
?>
<div class="boxdiv">
	<span class="titlespan">订单搜索</span>
	<form action="?page=order&function=filter" method="post">
		<span class="fixed">订单ID：</span>
		<input class="text" type="text" name="order_id" placeholder="依据订单ID过滤" value="<?php if (isset($_POST['order_id'])) echo $_POST['order_id']; ?>"><br>
		<span class="fixed">商家：</span>
		<input class="text" type="text" name="name" placeholder="依据商家名称过滤" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>"><br>
		<span class="fixed">Ant：</span>
		<input class="text" type="text" name="ant" placeholder="依据Ant过滤" value="<?php if (isset($_POST['ant'])) echo $_POST['ant']; ?>"><br>
		<span class="fixed">用户ID：</span>
		<input class="text" type="text" name="user" placeholder="依据用户ID过滤" value="<?php if (isset($_POST['user'])) echo $_POST['user']; ?>"><br>
		<span class="fixed">下单时间：</span>
		<select style="width:180px;" name="date">
			<option <?php if (isset($_POST['date']) && $_POST['date'] == "全部") echo 'selected="selected"'; ?>>全部</option>
			<option <?php if (isset($_POST['date']) && $_POST['date'] == "今天") echo 'selected="selected"'; ?>>今天</option>
			<option <?php if (isset($_POST['date']) && $_POST['date'] == "本周") echo 'selected="selected"'; ?>>本周</option>
			<option <?php if (isset($_POST['date']) && $_POST['date'] == "本月") echo 'selected="selected"'; ?>>本月</option>
		</select><br>
		<span class="fixed">已下单：</span>
		<span><input type="radio" name="ordered" value="-1" <?php if (!isset($_POST['ordered']) || $_POST['ordered'] == -1) echo "checked"; ?>>全部</span>&nbsp;
		<span><input type="radio" name="ordered" value="1" <?php if (isset($_POST['ordered']) && $_POST['ordered'] == 1) echo "checked"; ?>>是</span>&nbsp;
		<span><input type="radio" name="ordered" value="0" <?php if (isset($_POST['ordered']) && $_POST['ordered'] == 0) echo "checked"; ?>>否</span><br>
		<span class="fixed">已接单：</span>
		<span><input type="radio" name="shipped" value="-1" <?php if (!isset($_POST['shipped']) || $_POST['shipped'] == -1) echo "checked"; ?>>全部</span>&nbsp;
		<span><input type="radio" name="shipped" value="1" <?php if (isset($_POST['shipped']) && $_POST['shipped'] == 1) echo "checked"; ?>>是</span>&nbsp;
		<span><input type="radio" name="shipped" value="0" <?php if (isset($_POST['shipped']) && $_POST['shipped'] == 0) echo "checked"; ?>>否</span><br>
		<span class="fixed">已取货：</span>
		<span><input type="radio" name="taken" value="-1" <?php if (!isset($_POST['taken']) || $_POST['taken'] == -1) echo "checked"; ?>>全部</span>&nbsp;
		<span><input type="radio" name="taken" value="1" <?php if (isset($_POST['taken']) && $_POST['taken'] == 1) echo "checked"; ?>>是</span>&nbsp;
		<span><input type="radio" name="taken" value="0" <?php if (isset($_POST['taken']) && $_POST['taken'] == 0) echo "checked"; ?>>否</span><br>
		<span class="fixed">已付款：</span>
		<span><input type="radio" name="paid" value="-1" <?php if (!isset($_POST['paid']) || $_POST['paid'] == -1) echo "checked"; ?>>全部</span>&nbsp;
		<span><input type="radio" name="paid" value="1" <?php if (isset($_POST['paid']) && $_POST['paid'] == 1) echo "checked"; ?>>是</span>&nbsp;
		<span><input type="radio" name="paid" value="0" <?php if (isset($_POST['paid']) && $_POST['paid'] == 0) echo "checked"; ?>>否</span><br>
		<p class="psubmit">
			<input class="button" type="submit" value="搜索">
			<input class="button" type="reset">
		</p>
	</form>
</div>
<div class="boxdiv">
	<span class="titlespan">订单列表</span>
	<table class="table" style="margin-right:20px;">
		<tr class="trtitle">
			<td style="width:20px;">#</td>
			<td>订单ID</td>
			<td>商家</td>
			<td>时间</td>
			<td>Ant</td>
			<td>用户ID</td>
			<td>已下单</td>
			<td>已接单</td>
			<td>已取货</td>
			<td>已付款</td>
		</tr>
		<?php
		$result = $db->select("*", "order_info");
		if ($result != false) {
			$count = 0;
			while ($order = $db->fetch($result)) {
				$details = $db->select("product_id", "order_details", "`order_id`='" . $order['order_id'] . "'");
				$details = $db->fetch($details);
				$shop = $db->select("shop_name", "shop", "`shop_id`='" . $details['product_id'] . "'");
				$shop = $db->fetch($shop);
				$ant = $db->select("ant_name", "ants", "`ant_id`='" . $order['ant_id'] . "'");
				$ant = $db->fetch($ant);
				$match = true;
				if ($filter == true) {
					if (isset($_POST['order_id']) && $_POST['order_id'] != "" && $order['order_id'] != $_POST['order_id']) {
						$match = false;
					}
					if (isset($_POST['name']) && $_POST['name'] != "" && !strstr($shop['shop_name'], $_POST['name'])) {
						$match = false;
					}
					if (isset($_POST['ant']) && $_POST['ant'] != "" && !strstr($ant['ant_name'], $_POST['ant'])) {
						$match = false;
					}
					if (isset($_POST['user']) && $_POST['user'] != "" && !strstr($order['user_id'], $_POST['user'])) {
						$match = false;
					}
					if (isset($_POST['date'])) {
						switch ($_POST['date']) {
						case '今天':
							if (date("Y-m-d") != $order['add_date']) {
								$match = false;
							}
							break;
						case '本周':
							$date = date("Y-m-d");
							$w = date("w", strtotime($date));
							$d = ($w) ? ($w - 1) : (6);
							$first = "$date - " . $d . " days";
							if (strtotime($order['add_date']) < strtotime($first)) {
								$match = false;
							}
							break;
						case '本月':
							$first = date("Y") . "-" . date("m") . "-1";
							if (strtotime($order['add_date']) < strtotime($first)) {
								$match = false;
							}
						}
					}
					if (isset($_POST['ordered']) && $_POST['ordered'] >= 0 && $_POST['ordered'] != $order['order_status']) {
						$match = false;
					}
					if (isset($_POST['shipped']) && $_POST['shipped'] >= 0 && $_POST['shipped'] != $order['shipping_status']) {
						$match = false;
					}
					if (isset($_POST['taken']) && $_POST['taken'] >= 0 && $_POST['taken'] != $order['taking_status']) {
						$match = false;
					}
					if (isset($_POST['paid']) && $_POST['paid'] >= 0 && $_POST['paid'] != $order['pay_status']) {
						$match = false;
					}
				}
				if ($match == false) {
					continue;
				}
				$count++;
				$style = ($count - 1) % 2;
				echo "<tr class='tr$style'>";
				echo "<td>$count</td>";
				echo "<td>" . $order['order_id'] . "</td>";
				echo "<td>" . $shop['shop_name'] . "</td>";
				echo "<td>" . $order['add_date'] . "</td>";
				echo "<td>" . $ant['ant_name'] . "</td>";
				echo "<td>" . $order['user_id'] . "</td>";
				echo "<td>" . ($order['order_status'] == 1 ? "是" : "否") . "</td>";
				echo "<td>" . ($order['shipping_status'] == 1 ? "是" : "否") . "</td>";
				echo "<td>" . ($order['taking_status'] == 1 ? "是" : "否") . "</td>";
				echo "<td>" . ($order['pay_status'] == 1 ? "是" : "否") . "</td>";
				echo "</tr>";
			}
		}
		?>
	</table>
</div>
