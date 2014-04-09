<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
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
		<span class="fixed">订单状态：</span>
		<select style="width:180px;" name="status">
			<option <?php if (isset($_POST['status']) && substr($_POST['status'], 0, 1) == '1') echo 'selected="selected"'; ?>>1.已下单，未接单</option>
			<option <?php if (isset($_POST['status']) && substr($_POST['status'], 0, 1) == '2') echo 'selected="selected"'; ?>>2.已接单，店家未确认</option>
			<option <?php if (isset($_POST['status']) && substr($_POST['status'], 0, 1) == '3') echo 'selected="selected"'; ?>>3.已接单，已确认，未取</option>
			<option <?php if (isset($_POST['status']) && substr($_POST['status'], 0, 1) == '4') echo 'selected="selected"'; ?>>4.已接单，已确认，已取</option>
			<option <?php if (isset($_POST['status']) && substr($_POST['status'], 0, 1) == '5') echo 'selected="selected"'; ?>>5.已确认，已送达，未付款</option>
			<option <?php if (isset($_POST['status']) && substr($_POST['status'], 0, 1) == '6') echo 'selected="selected"'; ?>>6.已确认，已送达，已付款</option>
			<option <?php if (isset($_POST['status']) && substr($_POST['status'], 0, 1) == '7') echo 'selected="selected"'; ?>>7.数据错误</option>
		</select>
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
			<td>商家</td>
			<td>时间</td>
			<td>Ant</td>
			<td>用户ID</td>
			<td>订单状态</td>
		</tr>
		<?php
		$db = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
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
					if (isset($_POST['name']) && $_POST['name'] != "" && !strstr($shop['shop_name'], $_POST['name'])) {
						$match = false;
						echo "name";
					}
					if (isset($_POST['ant']) && $_POST['ant'] != "" && !strstr($ant['ant_name'], $_POST['ant'])) {
						$match = false;
						echo "ant";
					}
					if (isset($_POST['user']) && $_POST['user'] != "" && !strstr($order['user_id'], $_POST['user'])) {
						$match = false;
						echo "user";
					}
					if (isset($_POST['date'])) {
						switch ($_POST['date']) {
						case '今天':
							if (strtotime(date("Y-m-d")) != strtotime($order['add_date'])) {
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
					if (isset($_POST['status']) && $_POST['status'] != "" && $order['order_status'] != substr($_POST['status'], 0, 1)) {
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
				echo "<td>" . $shop['shop_name'] . "</td>";
				echo "<td>" . $order['add_date'] . "</td>";
				echo "<td>" . $ant['ant_name'] . "</td>";
				echo "<td>" . $order['user_id'] . "</td>";
				switch ($order['order_status']) {
				case '1':
					$str = "已下单，未接单";
					break;
				case '2':
					$str = "已接单，店家未确认";
					break;
				case '3':
					$str = "已接单，已确认，未取";
					break;
				case '4':
					$str = "已接单，已确认，已取";
					break;
				case '5':
					$str = "已确认，已送达，未付款";
					break;
				case '6':
					$str = "已确认，已送达，已付款";
					break;
				default:
					$str = "数据错误";
				}
				echo "<td>" . $str . "</td>";
				echo "</tr>";
			}
		}
		?>
	</table>
</div>
