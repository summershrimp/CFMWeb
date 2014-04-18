<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$db = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (!isset($_GET['pr'])) {
	$_GET['pr'] = 1;
}
$filter = false;
if (isset($_GET['function'])) {
	switch ($_GET['function']) {
	case 'editshop':
		check_and_open($db, 'shop', 'detail', "m/shop/editshop.php", 'shop_id', true, "商家");
		break;
	case 'deleteshop':
		check_and_open($db, 'shop', 'detail', "f/shop/deleteshop.php", 'shop_id', false, "商家");
		break;
	case 'deleteshops':
		require "f/shop/deleteshops.php";
		break;
	case 'newshop':
		require "m/shop/newshop.php";
		exit();
		break;
	case 'filter':
		$filter = true;
	}
}
$cond = "";
if ($filter == true) {
	$cond = contact_condition($cond, 'shop_id');
	$cond = contact_condition($cond, 'shop_name', false);
	$cond = contact_condition($cond, 'shop_phone');
	$cond = contact_condition($cond, 'shop_pos', false);
	$cond = contact_condition($cond, 'owner_id');
	$cond = contact_condition($cond, 'shop_desc', false);
}
if ($cond == "") {
	$cond = NULL;
}
?>
<div class="boxdiv">
	<span class="titlespan dep1">商家信息管理<span class="commit">» 他们作为源头，生产各种商品</span></span>
</div>
<div class="boxdiv">
	<span class="titlespan dep2">搜索商家</span>
	<form action="?page=shop&function=filter" method="post">
		<span class="fixed">商家ID：</span>
		<input class="text" type="text" name="shop_id" placeholder="依据商家ID过滤" value="<?php if (isset($_POST['shop_id'])) echo $_POST['shop_id']; ?>"><br>
		<span class="fixed">商家名称：</span>
		<input class="text" type="text" name="shop_name" placeholder="依据商家名称过滤" value="<?php if (isset($_POST['shop_name'])) echo $_POST['shop_name']; ?>">
		<span class="tooltip">支持模糊搜索</span><br>
		<span class="fixed">商家电话：</span>
		<input class="text" type="text" name="shop_phone" placeholder="依据商家电话过滤" value="<?php if (isset($_POST['shop_phone'])) echo $_POST['shop_phone']; ?>"><br>
		<span class="fixed">商家位置：</span>
		<input class="text" type="text" name="shop_pos" placeholder="依据商家位置过滤" value="<?php if (isset($_POST['shop_pos'])) echo $_POST['shop_pos']; ?>">
		<span class="tooltip">支持模糊搜索</span><br>
		<span class="fixed">业主ID：</span>
		<input class="text" type="text" name="owner_id" placeholder="依据业主ID过滤" value="<?php if (isset($_POST['owner_id'])) echo $_POST['owner_id']; ?>"><br>
		<span class="fixed">商家描述：</span>
		<input class="text" type="text" name="shop_desc" placeholder="依据商家描述过滤" value="<?php if (isset($_POST['shop_desc'])) echo $_POST['shop_desc']; ?>">
		<span class="tooltip">支持模糊搜索</span><br>
		<p class="psubmit">
			<input class="button" type="submit" value="搜索">
			<input class="button" type="reset">
		</p>
	</form>
</div>
<div class="boxdiv"><span class="titlespan dep2">商家列表</span>
	<?php $show = make_page_controller($db, "shop", "shop", "shop_id", $cond, $_GET['pr']); ?>
	<form id="del" action="?page=shop&function=deleteshops" method="post">
		<table style="margin-right:20px;">
			<tr class="trtitle">
				<td></td>
				<td style="width:20px;">#</td>
				<td>操作</td>
				<td>ID</td>
				<td>名称</td>
				<td>电话</td>
				<td>位置</td>
				<td>业主ID</td>
				<td>业主姓名</td>
				<td>描述</td>
			</tr>
			<?php
			if ($show == true) {
				$result = $db->get_page_content("*", "shop", $cond, $_GET['pr']);
				if ($result != false) {
					$count = 0;
					while ($shop = $db->fetch($result)) {
						$count++;
						$style = ($count - 1) % 2;
						echo "<tr class='tr$style'>";
						echo "<td style='text-align:center;'><input type='checkbox' name='chk[]' value='" . $shop['shop_id'] . "'></td>";
						echo "<td>$count</td>";
						echo "<td>";
						echo "<a href='?page=shop&function=editshop&detail=" . $shop['shop_id'] . "'>";
						echo "<img src='images/icon_edit.png' alt='修改'>";
						echo "<span class='link'>修改</span></a>&nbsp;";
						echo "<a href='javascript:del(\"?page=shop&function=deleteshop&detail=" . $shop['shop_id'] . "\")'>";
						echo "<img src='images/icon_del.png' alt='删除'>";
						echo "<span class='link'>删除</span></a></td>";
						$id = $shop['owner_id'];
						$t = $db->select("provider_name", "providers", "`provider_id`='$id'", 1);
						$t = $db->fetch($t);
						echo "<td>" . $shop['shop_id'] . "</td>";
						echo "<td>" . $shop['shop_name'] . "</td>";
						echo "<td>" . $shop['shop_phone'] . "</td>";
						echo "<td class='tdclip'>" . $shop['shop_pos'] . "</td>";
						echo "<td>$id</td>";
						echo "<td>" . $t['provider_name'] . "</td>";
						echo "<td class='tdclip'>" . $shop['shop_desc'] . "</td>";
						echo "</tr>";
					}
				}
			}
			?>
		</table>
		<p class="psubmit">
			<a href="?page=shop&function=newshop"><input class="button" style="float:left;" type="button" value="添加商家"></a>
			<input class="button dangerousbutton" type="button" onclick="javascript:dels()" value="批量删除"></a>
			<input class="button" type="reset" value="重新选择">
		</p>
	</form>
</div>
