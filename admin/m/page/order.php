<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$db = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$result = $db->select("*", "order_details");
$result = $db->fetch($result);
?>
<div class="boxdiv">
	<span class="titlespan">订单搜索</span>
	<form action="?page=order" method="post">
		<span class="fixed">商家：</span>
		<input class="text" type="text" name="name" placeholder="依据商家名称过滤"><br>
		<span class="fixed">Ant：</span>
		<input class="text" type="text" name="phone" placeholder="依据Ant过滤"><br>
		<span class="fixed">用户：</span>
		<input class="text" type="text" name="pos" placeholder="依据用户过滤"><br>
		<span class="fixed">下单时间：</span>
		<select style="width:180px;">
			<option>今天</option>
			<option>本周</option>
			<option>本月</option>
		</select><br>
		<span class="fixed">订单状态：</span>
		<select style="width:180px;">
			<option>1：已下单，未接单</option>
			<option>2：已接单，店家未确认</option>
			<option>3：已接单，已确认，未取</option>
			<option>4：已接单，已确认，已取</option>
			<option>5：已确认，已送达，未付款</option>
			<option>6：已确认，已送达，已付款</option>
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
			<td>用户</td>
			<td>订单状态</td>
		</tr>
		<?php
		if ($result != false) {
			$count = 0;
			while ($r = $db->fetch($result)) {
				$count++;
				$style = ($count - 1) % 2;
				echo "<tr class='tr$style'>";
				echo "<td>$count</td>";
				echo "<td>" . $r[''] . "</td>";
				echo "<td>" . $r[''] . "</td>";
				echo "<td>" . $r[''] . "</td>";
				echo "<td>" . $t[''] . "</td>";
				echo "<td>" . $r[''] . "</td>";
				echo "</tr>";
			}
		}
		?>
	</table>
</div>
