<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$db = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
?>
<div class="boxdiv">
	<span class="titlespan">商家信息维护</span>
	<div>
		<table class="table">
			<tr class="trtitle">
				<td style="width:150px;">名称</td>
				<td style="width:150px;">电话</td>
				<td style="width:250px;">位置</td>
				<td style="width:100px;">业主</td>
			</tr>
			<?php
				$result = $db->select("*", "shop");
				$count = 0;
				while ($r = $db->fetch($result)) {
					echo "<tr class='tr$count'>";
					$id = $r['owner_id'];
					$t = $db->select("provider_name", "providers", "`provider_id`='$id'", 1);
					$t = $db->fetch($t);
					echo "<td>" . $r['shop_name'] . "</td>";
					echo "<td>" . $r['shop_phone'] . "</td>";
					echo "<td>" . $r['shop_pos'] . "</td>";
					echo "<td>" . $t['provider_name'] . "</td>";
					echo "</tr>";
					$count = 1 - $count;
				}
			?>
		</table>
		<p></p>
	</div>
</div>
