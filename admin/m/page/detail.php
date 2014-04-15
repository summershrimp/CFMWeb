<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$db = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$filter = false;
if (isset($_GET['function'])) {
	switch ($_GET['function']) {
	case 'editdetail':
		check_and_open($db, 'order_details', 'detail', "m/detail/editdetail.php", 'detail_id', true, "订单详情");
		break;
	case 'deletedetail':
		check_and_open($db, 'order_details', 'detail', "f/detail/deletedetail.php", 'detail_id', false, "订单详情");
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
	$cond = contact_condition($cond, 'detail_id');
	$cond = contact_condition($cond, 'detail_name');
	$cond = contact_condition($cond, 'email', false);
	if (isset($_POST['sex']) && $_POST['sex'] != -1) $cond = contact_condition($cond, 'sex');
	$cond = contact_condition($cond, 'mobile_phone');
	$cond = contact_condition($cond, 'qq');
}
if ($cond == "") {
	$cond = NULL;
}
?>
<div class="boxdiv">
	<span class="titlespan dep1">订单详情管理<span class="commit">» 每一笔订单的详情都在这里</span></span>
</div>
<div class="boxdiv">
	<span class="titlespan dep2">搜索订单</span>
	<form action="?page=detail&function=filter" method="post">
		<span class="fixed">订单ID：</span>
		<input class="text" type="text" name="detail_id" placeholder="依据订单ID过滤" value="<?php if (isset($_POST['detail_id'])) echo $_POST['detail_id']; ?>"><br>
		<span class="fixed">订单名：</span>
		<input class="text" type="text" name="detail_name" placeholder="依据订单名过滤" value="<?php if (isset($_POST['detail_name'])) echo $_POST['detail_name']; ?>"><br>
		<span class="fixed">邮箱：</span>
		<input class="text" type="text" name="email" placeholder="依据订单邮箱过滤" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
		<span class="tooltip">* 支持模糊搜索</span><br>
		<span class="fixed">性别：</span>
		<span><input type="radio" name="sex" value="-1" <?php if (!isset($_POST['sex']) || $_POST['sex'] == -1) echo "checked"; ?>>全部</span>&nbsp;
		<span><input type="radio" name="sex" value="0" <?php if (isset($_POST['sex']) && $_POST['sex'] == 0) echo "checked"; ?>>男</span>&nbsp;
		<span><input type="radio" name="sex" value="1" <?php if (isset($_POST['sex']) && $_POST['sex'] == 1) echo "checked"; ?>>女</span><br>
		<span class="fixed">手机：</span>
		<input class="text" type="text" name="mobile_phone" placeholder="依据订单手机过滤" value="<?php if (isset($_POST['mobile_phone'])) echo $_POST['mobile_phone']; ?>"><br>
		<span class="fixed">QQ：</span>
		<input class="text" type="text" name="qq" placeholder="依据订单QQ过滤" value="<?php if (isset($_POST['qq'])) echo $_POST['qq']; ?>"><br>
		<p class="psubmit">
			<input class="button" type="submit" value="搜索">
			<input class="button" type="reset">
		</p>
	</form>
</div>
<div class="boxdiv"><span class="titlespan dep2">订单列表</span>
	<form action="#" method="post">
		<table style="margin-right:20px;">
			<tr class="trtitle">
				<td></td>
				<td style="width:20px;">#</td>
				<td>操作</td>
				<td>ID</td>
				<td>订单名</td>
				<td>邮箱</td>
				<td>性别</td>
				<td>手机</td>
				<td>QQ</td>
			</tr>
			<?php
			$result = $db->select("*", "details", $cond);
			if ($result != false) {
				$count = 0;
				while ($detail = $db->fetch($result)) {
					$count++;
					$style = ($count - 1) % 2;
					echo "<tr class='tr$style'>";
					echo "<td style='text-align:center;'><input type='checkbox' name='chk[]' value='" . $detail['detail_id'] . "'></td>";
					echo "<td>$count</td>";
					echo "<td>&nbsp;";
					echo "<a href='?page=detail&function=editdetail&detail=" . $detail['detail_id'] . "'>";
					echo "<img src='images/icon_edit' alt='修改'>";
					echo "<span class='link'>修改</span></a>&nbsp;";
					echo "<a href='javascript:del(\"?page=detail&function=deletedetail&detail=" . $detail['detail_id'] . "\")'>";
					echo "<img src='images/icon_del' alt='删除'>";
					echo "<span class='link'>删除</span></a>";
					echo "&nbsp;</td>";
					echo "<td>" . $detail['detail_id'] . "</td>";
					echo "<td>" . $detail['detail_name'] . "</td>";
					echo "<td>" . $detail['email'] . "</td>";
					echo "<td>" . (($detail['sex'] == 0) ? "男" : "女") . "</td>";
					echo "<td>" . $detail['mobile_phone'] . "</td>";
					echo "<td>" . $detail['qq'] . "</td>";
					echo "</tr>";
				}
			}
			?>
		</table>
		<p class="psubmit">
			<a href="?page=detail&function=newdetail"><input class="button" style="float:left;" type="button" value="添加订单"></a>
			<a href="javascript:del('?page=detail&function=deletedetails')"><input class="button dangerousbutton" type="button" value="批量删除"></a>
			<input class="button" type="reset" value="重新选择">
		</p>
	</form>
</div>
