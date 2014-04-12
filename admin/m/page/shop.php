<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
function check($db, $alt, $page, $shopow, $exit) {
	if (isset($_GET[$alt])) {
		$get = $_GET[$alt];
		$result = $db->select("*", "shop", "`$shopow`='$get'", 1);
		if ($result != false) {
			$shop = $db->fetch($result);
			if (!empty($shop)) {
				require $page;
				if ($exit == true) {
					exit;
				}
				return;
			}
		}
		echo "<div class=\"returnerror\">商家未找到！</div>";
	}
	else {
		echo "<div class=\"returnerror\">未指明商家！</div>";
	}
}
$db = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$filter = false;
if (isset($_GET['function'])) {
	switch ($_GET['function']) {
	case 'editshop':
		check($db, 'detail', "m/shop/editshop.php", 'shop_id', true);
		break;
	case 'deleteshop':
		check($db, 'detail', "f/shop/deleteshop.php", 'shop_id', false);
		break;
	case 'deleteshops':
		require "f/shop/deleteshops.php";
		break;
	case 'newshop':
		require "m/shop/newshop.php";
		exit;
		break;
	case 'filter':
		$filter = true;
	}
}
?>
<div class="boxdiv">
	<span class="titlespan">搜索商家</span>
	<form action="?page=shop" method="post">
		<span class="fixed">商家ID：</span>
		<input class="text" type="text" name="shop_id" placeholder="依据商家ID过滤" value="<?php if (isset($_POST['shop_id'])) echo $_POST['shop_id']; ?>"><br>
		<span class="fixed">名称：</span>
		<input class="text" type="text" name="name" placeholder="依据商家名称过滤" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>"><br>
		<span class="fixed">电话：</span>
		<input class="text" type="text" name="phone" placeholder="依据业主电话过滤" value="<?php if (isset($_POST['phone'])) echo $_POST['phone']; ?>"><br>
		<span class="fixed">位置：</span>
		<input class="text" type="text" name="pos" placeholder="依据商家位置过滤" value="<?php if (isset($_POST['pos'])) echo $_POST['pos']; ?>"><br>
		<p class="psubmit">
			<input class="button" type="submit" value="搜索">
			<input class="button" type="reset">
		</p>
	</form>
</div>
<div class="boxdiv">
	<span class="titlespan">商家列表</span>
	<form action="?page=shop&function=deleteshops" method="post">
		<table class="table" style="margin-right:20px;">
			<tr class="trtitle">
				<td></td>
				<td style="width:20px;">#</td>
				<td>商家ID</td>
				<td>名称</td>
				<td>电话</td>
				<td>位置</td>
				<td>业主</td>
				<td>描述</td>
				<td>操作</td>
			</tr>
			<?php
			$result = $db->select("*", "shop");
			if ($result != false) {
				$count = 0;
				while ($shop = $db->fetch($result)) {
					$provider = $db->select("provider_name", "providers", "`provider_id`='" . $shop['owner_id'] . "'", 1);
					$provider = $db->fetch($provider);
					$match = true;
					if ($filter == true) {
						if (isset($_POST['shop_id']) && $_POST['shop_id'] != "" && $shop['shop_id'] != $_POST['shop_id']) {
							$match = false;
						}
						if (isset($_POST['shop_name']) && $_POST['shop_name'] != "" && !strstr($shop['shop_name'], $_POST['shop_name'])) {
							$match = false;
						}
						if (isset($_POST['shop_phone']) && $_POST['shop_phone'] != "" && !strstr($shop['shop_phone'], $_POST['shop_phone'])) {
							$match = false;
						}
						if (isset($_POST['shop_pos']) && $_POST['shop_pos'] != "-1" && $shop['shop_pos'] != $_POST['shop_pos']) {
							$match = false;
						}
						if (isset($_POST['name']) && $_POST['name'] != "" && !strstr($provider['provider_name'], $_POST['name'])) {
							$match = false;
						}
						if (isset($_POST['shop_desc']) && $_POST['shop_desc'] != "" && !strstr($shop['shop_desc'], $_POST['shop_desc'])) {
							$match = false;
						}
					}
					if ($match == false) {
						continue;
					}
					$count++;
					$style = ($count - 1) % 2;
					echo "<tr class='tr$style'>";
					echo "<td><input type='checkbox' name='chk[]' value='" . $shop['shop_id'] . "'></td>";
					echo "<td>$count</td>";
					$id = $shop['owner_id'];
					$t = $db->select("provider_name", "providers", "`provider_id`='$id'", 1);
					$t = $db->fetch($t);
					echo "<td>" . $shop['shop_id'] . "</td>";
					echo "<td>" . $shop['shop_name'] . "</td>";
					echo "<td>" . $shop['shop_phone'] . "</td>";
					echo "<td>" . $shop['shop_pos'] . "</td>";
					echo "<td>" . $provider['provider_name'] . "</td>";
					echo "<td>" . $shop['shop_desc'] . "</td>";
					echo "<td>&nbsp;";
					echo "<a href='?page=shop&function=edit&detail=" . $shop['shop_id'] . "'>";
					echo "<img src='images/icon_edit' alt='修改'>";
					echo "<span class='link'>修改</span></a>&nbsp;";
					echo "<a href='?page=shop&function=deleteshop&detail=" . $shop['shop_id'] . "'>";
					echo "<img src='images/icon_del' alt='删除'>";
					echo "<span class='link'>删除</span></a>";
					echo "&nbsp;</td>";
					echo "</tr>";
				}
			}
			?>
		</table>
		<p class="psubmit">
			<a href="?page=shop&function=newshop"><input class="button" type="button" value="添加商家"></a>
			<input class="button" type="submit" value="删除已选">
			<input class="button" type="reset">
		</p>
	</form>
</div>
