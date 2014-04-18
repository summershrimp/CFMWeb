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
	case 'editgood':
		check_and_open('shop_goods', 'detail', "m/good/editgood.php", 'good_id', true, "商品");
		break;
	case 'deletegood':
		check_and_open('shop_goods', 'detail', "f/good/deletegood.php", 'good_id', false, "商品");
		break;
	case 'deletegoods':
		require "f/good/deletegoods.php";
		break;
	case 'newgood':
		require "m/good/newgood.php";
		exit();
		break;
	case 'filter':
		$filter = true;
	}
}
$cond = "";
if ($filter == true) {
	$cond = contact_condition($cond, 'good_id');
	$cond = contact_condition($cond, 'shop_id');
	if (isset($_POST['price']) && $_POST['price'] != "") {
		if ($cond != "") {
			$cond .= " AND ";
		}
		$low = 0;
		$high = 0;
		sscanf($_POST['price'], "%d-%d", $low, $high);
		if ($low <= $high) {
			$cond .= "`price` BETWEEN '$low' AND '$high'";
		}
		else {
			$cond .= "`price`='$low'";
		}
	}
	if (isset($_POST['onsale']) && $_POST['onsale'] != -1) $cond = contact_condition($cond, 'onsale');
	$cond = contact_condition($cond, 'good_name', false);
	$cond = contact_condition($cond, 'good_desc', false);
	if (isset($_POST['unavail']) && $_POST['unavail'] != -1) $cond = contact_condition($cond, 'unavail');
}
if ($cond == "") {
	$cond = NULL;
}
?>
<div class="boxdiv">
	<span class="titlespan dep1">商品管理<span class="commit">» 一份煎饺，一杯粥，所有的商品信息都在这里</span></span>
</div>
<div class="boxdiv">
	<span class="titlespan dep2">搜索商品</span>
	<form action="?page=good&function=filter" method="post">
		<span class="fixed">商品ID：</span>
		<input class="text" type="text" name="good_id" placeholder="依据商品ID过滤" value="<?php if (isset($_POST['good_id'])) echo $_POST['good_id']; ?>"><br>
		<span class="fixed">商家ID：</span>
		<input class="text" type="text" name="shop_id" placeholder="依据提供商品的商家ID过滤" value="<?php if (isset($_POST['shop_id'])) echo $_POST['shop_id']; ?>"><br>
		<span class="fixed">价格：</span>
		<input class="text" type="text" name="price" placeholder="格式：A或A~B，单位：元" value="<?php if (isset($_POST['price'])) echo $_POST['price']; ?>"><br>
		<span class="fixed">人气美食：</span>
		<span><input type="radio" name="onsale" value="-1" <?php if (!isset($_POST['onsale']) || $_POST['onsale'] == -1) echo "checked"; ?>>全部</span>&nbsp;
		<span><input type="radio" name="onsale" value="1" <?php if (isset($_POST['onsale']) && $_POST['onsale'] == 1) echo "checked"; ?>>是</span>&nbsp;
		<span><input type="radio" name="onsale" value="0" <?php if (isset($_POST['onsale']) && $_POST['onsale'] == 0) echo "checked"; ?>>否</span><br>
		<span class="fixed">商品名称：</span>
		<input class="text" type="text" name="good_name" placeholder="依据商品名称过滤" value="<?php if (isset($_POST['good_name'])) echo $_POST['good_name']; ?>">
		<span class="tooltip">支持模糊搜索</span><br>
		<span class="fixed">商品描述：</span>
		<input class="text" type="text" name="good_desc" placeholder="依据商品描述过滤" value="<?php if (isset($_POST['good_desc'])) echo $_POST['good_desc']; ?>">
		<span class="tooltip">支持模糊搜索</span><br>
		<span class="fixed">销售状态：</span>
		<span><input type="radio" name="unavail" value="-1" <?php if (!isset($_POST['unavail']) || $_POST['unavail'] == -1) echo "checked"; ?>>全部</span>&nbsp;
		<span><input type="radio" name="unavail" value="0" <?php if (isset($_POST['unavail']) && $_POST['unavail'] == 0) echo "checked"; ?>>在售</span>&nbsp;
		<span><input type="radio" name="unavail" value="1" <?php if (isset($_POST['unavail']) && $_POST['unavail'] == 1) echo "checked"; ?>>脱销</span><br>
		<p class="psubmit">
			<input class="button" type="submit" value="搜索">
			<input class="button" type="reset">
		</p>
	</form>
</div>
<div class="boxdiv"><span class="titlespan dep2">商品列表</span>
	<?php $show = make_page_controller("good", "shop_goods", "good_id", $cond, $_GET['pr']); ?>
	<form id="del" action="?page=good&function=deletegoods" method="post">
		<table style="margin-right:20px;">
			<tr class="trtitle">
				<td></td>
				<td style="width:20px;">#</td>
				<td>操作</td>
				<td>商品ID</td>
				<td>商家ID</td>
				<td>价格</td>
				<td>人气美食</td>
				<td>商品名称</td>
				<td>商品描述</td>
				<td>销售状态</td>
			</tr>
			<?php
			if ($show == true) {
				$result = $GLOBALS['db']->get_page_content("*", "shop_goods", $cond, $_GET['pr']);
				if ($result != false) {
					$count = 0;
					while ($good = $GLOBALS['db']->fetch($result)) {
						$count++;
						$style = ($count - 1) % 2;
						echo "<tr class='tr$style'>";
						echo "<td style='text-align:center;'><input type='checkbox' name='chk[]' value='" . $good['good_id'] . "'></td>";
						echo "<td>$count</td>";
						echo "<td>";
						echo "<a href='?page=good&function=editgood&detail=" . $good['good_id'] . "'>";
						echo "<img src='images/icon_edit.png' alt='修改'>";
						echo "<span class='link'>修改</span></a>&nbsp;";
						echo "<a href='javascript:del(\"?page=good&function=deletegood&detail=" . $good['good_id'] . "\")'>";
						echo "<img src='images/icon_del.png' alt='删除'>";
						echo "<span class='link'>删除</span></a></td>";
						echo "<td>" . $good['good_id'] . "</td>";
						echo "<td>" . $good['shop_id'] . "</td>";
						echo "<td>￥" . $good['price'] . "</td>";
						echo "<td>" . (($good['onsale'] == 0) ? "" : "√") . "</td>";
						echo "<td>" . $good['good_name'] . "</td>";
						echo "<td>" . $good['good_desc'] . "</td>";
						echo "<td>" . (($good['unavail'] == 0) ? "在售" : "脱销") . "</td>";
						echo "</tr>";
					}
				}
			}
			?>
		</table>
		<p class="psubmit">
			<a href="?page=good&function=newgood"><input class="button" style="float:left;" type="button" value="添加商品"></a>
			<a href="javascript:dels()"><input class="button dangerousbutton" type="button" value="批量删除"></a>
			<input class="button" type="reset" value="重新选择">
		</p>
	</form>
</div>
