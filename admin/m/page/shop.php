<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
function check($db, $alt, $page, $row, $exit) {
	if (isset($_GET[$alt])) {
		$get = $_GET[$alt];
		$result = $db->select("*", "shop", "`$row`='$get'", 1);
		if ($result != false) {
			$r = $db->fetch($result);
			if (!empty($r)) {
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
	}
}
$condition = "";
if (isset($_POST['shop_id']) && $_POST['shop_id'] != "") {
	if ($condition != "") {
		$condition .= " AND ";
	}
	$condition .= "`shop_id`='" . $_POST['shop_id'] . "'";
}
if (isset($_POST['name']) && $_POST['name'] != "") {
	if ($condition != "") {
		$condition .= " AND ";
	}
	$condition .= "`shop_name` LIKE '%" . $_POST['name'] . "%'";
}
if (isset($_POST['phone']) && $_POST['phone'] != "") {
	if ($condition != "") {
		$condition .= " AND ";
	}
	$condition .= "`shop_phone` LIKE '%" . $_POST['phone'] . "%'";
}
if (isset($_POST['pos']) && $_POST['pos'] != "") {
	if ($condition != "") {
		$condition .= " AND ";
	}
	$condition .= "`shop_pos` LIKE '%" . $_POST['pos'] . "%'";
}
if ($condition == "") {
	$condition = NULL;
}
$result = $db->select("*", "shop", $condition);
if ($result == false) {
	echo "<div class='returnsuccess'>结果为空！</div>";
}
else if ($condition != NULL) {
	echo "<div class='returnsuccess'>查询成功！</div>";	
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
			if ($result != false) {
				$count = 0;
				while ($r = $db->fetch($result)) {
					$count++;
					$style = ($count - 1) % 2;
					echo "<tr class='tr$style'>";
					echo "<td><input type='checkbox' name='chk[]' value='" . $r['shop_id'] . "'></td>";
					echo "<td>$count</td>";
					$id = $r['owner_id'];
					$t = $db->select("provider_name", "providers", "`provider_id`='$id'", 1);
					$t = $db->fetch($t);
					echo "<td>" . $r['shop_id'] . "</td>";
					echo "<td>" . $r['shop_name'] . "</td>";
					echo "<td>" . $r['shop_phone'] . "</td>";
					echo "<td>" . $r['shop_pos'] . "</td>";
					echo "<td>" . $t['provider_name'] . "</td>";
					echo "<td>" . $r['shop_desc'] . "</td>";
					echo "<td>&nbsp;";
					echo "<a href='?page=shop&function=edit&detail=" . $r['shop_id'] . "'>";
					echo "<img src='images/icon_edit' alt='修改'>";
					echo "<span class='link'>修改</span></a>&nbsp;";
					echo "<a href='?page=shop&function=deleteshop&detail=" . $r['shop_id'] . "'>";
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
