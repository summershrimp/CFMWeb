<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$db = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
?>
<div class="boxdiv">
	<span class="titlespan">搜索商家</span>
	<form action="?page=shop" method="post">
		<span class="fixed">名称：</span>
		<input class="text" type="text" name="name" placeholder="依据商家名称过滤"><br>
		<span class="fixed">电话：</span>
		<input class="text" type="text" name="phone" placeholder="依据业主电话过滤"><br>
		<span class="fixed">位置：</span>
		<input class="text" type="text" name="pos" placeholder="依据商家位置过滤"><br>
		<span class="fixed">业主：</span>
		<input class="text" type="text" name="provider" placeholder="依据业主过滤"><br>
		<p class="psubmit">
			<input class="button" type="submit" value="搜索">
			<input class="button" type="reset">
		</p>
	</form>
</div>
<div class="boxdiv">
	<span class="titlespan">商家列表</span>
	<form action="?page=shop" method="post">
		<table class="table" style="margin-right:20px;">
			<tr class="trtitle">
				<td></td>
				<td style="width:20px;">#</td>
				<td>名称</td>
				<td>电话</td>
				<td>位置</td>
				<td>业主</td>
				<td>操作</td>
			</tr>
			<?php
				$condition = "";
				if (isset($_POST['name']) && $_POST['name'] != "") {
					$condition .= "`shop_name` LIKE '%" . $_POST['name'] . "%'";
				}
				if (isset($_POST['phone']) && $_POST['phone'] != "") {
					$condition .= "`shop_phone` LIKE '%" . $_POST['phone'] . "%'";
				}
				if (isset($_POST['pos']) && $_POST['pos'] != "") {
					$condition .= "`shop_pos` LIKE '%" . $_POST['pos'] . "%'";
				}
				if (isset($_POST['provider']) && $_POST['provider'] != "") {
					$condition .= "`provider_name` LIKE '%" . $_POST['provider'] . "%'";
				}
				if ($condition == "") {
					$condition = NULL;
				}
				$result = $db->select("*", "shop", $condition);
				if ($result == false) {
					echo "<span class='fixed'>结果为空。</span>";
				}
				else {
					$count = 0;
					while ($r = $db->fetch($result)) {
						$count++;
						$style = ($count - 1) % 2;
						echo "<tr class='tr$style'>";
						echo "<td><input type='checkbox' name='chk[]'></td>";
						echo "<td>$count</td>";
						$id = $r['owner_id'];
						$t = $db->select("provider_name", "providers", "`provider_id`='$id'", 1);
						$t = $db->fetch($t);
						echo "<td>" . $r['shop_name'] . "</td>";
						echo "<td>" . $r['shop_phone'] . "</td>";
						echo "<td>" . $r['shop_pos'] . "</td>";
						echo "<td>" . $t['provider_name'] . "</td>";
						echo "<td>";
						echo "&nbsp;<img src='images/icon_edit' alt='修改'>";
						echo "<span class='link'>修改</span>&nbsp;";
						echo "&nbsp;<img src='images/icon_del' alt='删除'>";
						echo "<span class='link'>删除</span>&nbsp;";
						echo "</td>";
						echo "</tr>";
					}
				}
			?>
		</table>
		<p class="psubmit">
			<input class="button" type="button" value="添加新商家">
			<input class="button" type="submit" value="删除已选">
			<input class="button" type="reset">
		</p>
	</form>
</div>
