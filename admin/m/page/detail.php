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
	case 'editdetail':
		check_and_open('order_details', 'detail', "m/detail/editdetail.php", 'rec_id', true, "订单详情");
		break;
	case 'deletedetail':
		check_and_open('order_details', 'detail', "f/detail/deletedetail.php", 'rec_id', false, "订单详情");
		break;
	case 'deletedetails':
		require "f/detail/deletedetails.php";
		break;
	case 'newdetail':
		require "m/detail/newdetail.php";
		exit();
		break;
	case 'filter':
		$filter = true;
	}
}
$cond = "";
if ($filter == true) {
	$cond = contact_condition($cond, 'rec_id');
	$cond = contact_condition($cond, 'order_id');
	$cond = contact_condition($cond, 'good_id');
	$cond = contact_condition($cond, 'good_name', false);
	$cond = contact_condition($cond, 'good_number');
	$cond = contact_condition($cond, 'good_price');
}
if ($cond == "") {
	$cond = NULL;
}
$_POST = safe_output($_POST);
?>
<div class="boxdiv">
	<span class="titlespan dep1">订单详情管理<span class="commit">» 每一笔订单的详情都在这里</span></span>
</div>
<div class="boxdiv">
	<span class="titlespan dep2">搜索订单</span>
	<form action="?page=detail&function=filter" method="post">
		<span class="fixed">记录ID：</span>
		<input class="text" type="text" name="rec_id" placeholder="依据记录ID过滤" value="<?php if (isset($_POST['rec_id'])) echo $_POST['rec_id']; ?>"><br>
		<span class="fixed">订单ID：</span>
		<input class="text" type="text" name="order_id" placeholder="依据订单ID过滤" value="<?php if (isset($_POST['order_id'])) echo $_POST['order_id']; ?>"><br>
		<span class="fixed">商品ID：</span>
		<input class="text" type="text" name="good_id" placeholder="依据商品ID过滤" value="<?php if (isset($_POST['good_id'])) echo $_POST['good_id']; ?>"><br>
		<span class="fixed">商品名称：</span>
		<input class="text" type="text" name="good_name" placeholder="依据商品名称过滤" value="<?php if (isset($_POST['good_name'])) echo $_POST['good_name']; ?>">
		<span class="tooltip">支持模糊搜索</span><br>
		<span class="fixed">商品数量：</span>
		<input class="text" type="text" name="good_number" placeholder="依据商品数量过滤" value="<?php if (isset($_POST['good_number'])) echo $_POST['good_number']; ?>"><br>
		<span class="fixed">商品价格：</span>
		<input class="text" type="text" name="good_price" placeholder="单位：元" value="<?php if (isset($_POST['good_price'])) echo $_POST['good_price']; ?>"><br>
		<p class="psubmit">
			<input class="button" type="submit" value="搜索">
			<input class="button" type="reset">
		</p>
	</form>
</div>
<div class="boxdiv"><span class="titlespan dep2">订单列表</span>
	<?php $show = make_page_controller("detail", "order_details", "rec_id", $cond, $_GET['pr']); ?>
	<form id="del" action="?page=detail&function=deletedetails" method="post">
		<table style="margin-right:20px;">
			<tr class="trtitle">
				<td></td>
				<td style="width:20px;">#</td>
				<td>操作</td>
				<td>ID</td>
				<td>订单ID</td>
				<td>商品ID</td>
				<td>商品名称</td>
				<td>商品数量</td>
				<td>商品价格</td>
			</tr>
			<?php
			if ($show == true) {
				$result = $GLOBALS['db']->get_page_content("*", "order_details", $cond, $_GET['pr']);
				if ($result != false) {
					$count = 0;
					while ($detail = $GLOBALS['db']->fetch($result)) {
						$detail = safe_output($detail);
						$count++;
						$style = ($count - 1) % 2;
						echo "<tr class='tr$style'>";
						echo "<td style='text-align:center;'><input type='checkbox' name='chk[]' value='" . $detail['rec_id'] . "'></td>";
						echo "<td>$count</td>";
						echo "<td>";
						echo "<a href='?page=detail&function=editdetail&detail=" . $detail['rec_id'] . "'>";
						echo "<img src='images/icon_edit.png' alt='修改'>";
						echo "<span class='link'>修改</span></a>&nbsp;";
						echo "<a href='javascript:del(\"?page=detail&function=deletedetail&detail=" . $detail['rec_id'] . "\")'>";
						echo "<img src='images/icon_del.png' alt='删除'>";
						echo "<span class='link'>删除</span></a></td>";
						echo "<td>" . $detail['rec_id'] . "</td>";
						echo "<td>" . $detail['order_id'] . "</td>";
						echo "<td>" . $detail['good_id'] . "</td>";
						echo "<td>" . $detail['good_name'] . "</td>";
						echo "<td>" . $detail['good_number'] . "</td>";
						echo "<td>" . $detail['good_price'] . "</td>";
						echo "</tr>";
					}
				}
			}
			?>
		</table>
		<p class="psubmit">
			<a href="?page=detail&function=newdetail"><input class="button" style="float:left;" type="button" value="添加订单"></a>
			<a href="javascript:dels()"><input class="button dangerousbutton" type="button" value="批量删除"></a>
			<input class="button" type="reset" value="重新选择">
		</p>
	</form>
</div>
