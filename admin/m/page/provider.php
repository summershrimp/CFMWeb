<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$db = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$filter = false;
if (isset($_GET['function'])) {
	switch ($_GET['function']) {
	case 'editprovider':
		check_and_open($db, 'providers', 'detail', "m/provider/editprovider.php", 'provider_id', true, "业主");
		break;
	case 'deleteprovider':
		check_and_open($db, 'providers', 'detail', "f/provider/deleteprovider.php", 'provider_id', false, "业主");
		break;
	case 'deleteproviders':
		require "f/provider/deleteproviders.php";
		break;
	case 'newprovider':
		require "m/provider/newprovider.php";
		exit();
		break;
	case 'filter':
		$filter = true;
	}
}
$cond = "";
if ($filter == true) {
	$cond = contact_condition($cond, 'provider_id');
	$cond = contact_condition($cond, 'provider_name');
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
	<span class="titlespan dep1">业主信息管理<span class="commit">» 他们是各种商家的主人</span></span>
</div>
<div class="boxdiv">
	<span class="titlespan dep2">搜索业主</span>
	<form action="?page=provider&function=filter" method="post">
		<span class="fixed">业主ID：</span>
		<input class="text" type="text" name="provider_id" placeholder="依据业主ID过滤" value="<?php if (isset($_POST['provider_id'])) echo $_POST['provider_id']; ?>"><br>
		<span class="fixed">业主名：</span>
		<input class="text" type="text" name="provider_name" placeholder="依据业主昵称过滤" value="<?php if (isset($_POST['provider_name'])) echo $_POST['provider_name']; ?>"><br>
		<span class="fixed">邮箱：</span>
		<input class="text" type="text" name="email" placeholder="依据业主邮箱过滤" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
		<span class="tooltip">* 支持模糊搜索</span><br>
		<span class="fixed">性别：</span>
		<span><input type="radio" name="sex" value="-1" <?php if (!isset($_POST['sex']) || $_POST['sex'] == -1) echo "checked"; ?>>全部</span>&nbsp;
		<span><input type="radio" name="sex" value="0" <?php if (isset($_POST['sex']) && $_POST['sex'] == 0) echo "checked"; ?>>男</span>&nbsp;
		<span><input type="radio" name="sex" value="1" <?php if (isset($_POST['sex']) && $_POST['sex'] == 1) echo "checked"; ?>>女</span><br>
		<span class="fixed">手机：</span>
		<input class="text" type="text" name="mobile_phone" placeholder="依据业主手机过滤" value="<?php if (isset($_POST['mobile_phone'])) echo $_POST['mobile_phone']; ?>"><br>
		<span class="fixed">QQ：</span>
		<input class="text" type="text" name="qq" placeholder="依据业主QQ过滤" value="<?php if (isset($_POST['qq'])) echo $_POST['qq']; ?>"><br>
		<p class="psubmit">
			<input class="button" type="submit" value="搜索">
			<input class="button" type="reset">
		</p>
	</form>
</div>
<div class="boxdiv"><span class="titlespan dep2">业主列表</span>
	<form action="#" method="post">
		<table style="margin-right:20px;">
			<tr class="trtitle">
				<td></td>
				<td style="width:20px;">#</td>
				<td>操作</td>
				<td>ID</td>
				<td>业主名</td>
				<td>邮箱</td>
				<td>性别</td>
				<td>手机</td>
				<td>QQ</td>
			</tr>
			<?php
			$result = $db->select("*", "providers", $cond);
			if ($result != false) {
				$count = 0;
				while ($provider = $db->fetch($result)) {
					$count++;
					$style = ($count - 1) % 2;
					echo "<tr class='tr$style'>";
					echo "<td style='text-align:center;'><input type='checkbox' name='chk[]' value='" . $provider['provider_id'] . "'></td>";
					echo "<td>$count</td>";
					echo "<td>&nbsp;";
					echo "<a href='?page=provider&function=editprovider&detail=" . $provider['provider_id'] . "'>";
					echo "<img src='images/icon_edit' alt='修改'>";
					echo "<span class='link'>修改</span></a>&nbsp;";
					echo "<a href='javascript:del(\"?page=provider&function=deleteprovider&detail=" . $provider['provider_id'] . "\")'>";
					echo "<img src='images/icon_del' alt='删除'>";
					echo "<span class='link'>删除</span></a>";
					echo "&nbsp;</td>";
					echo "<td>" . $provider['provider_id'] . "</td>";
					echo "<td>" . $provider['provider_name'] . "</td>";
					echo "<td>" . $provider['email'] . "</td>";
					echo "<td>" . (($provider['sex'] == 0) ? "男" : "女") . "</td>";
					echo "<td>" . $provider['mobile_phone'] . "</td>";
					echo "<td>" . $provider['qq'] . "</td>";
					echo "</tr>";
				}
			}
			?>
		</table>
		<p class="psubmit">
			<a href="?page=provider&function=newprovider"><input class="button" style="float:left;" type="button" value="添加业主"></a>
			<a href="javascript:del('?page=provider&function=deleteproviders')"><input class="button dangerousbutton" type="button" value="批量删除"></a>
			<input class="button" type="reset" value="重新选择">
		</p>
	</form>
</div>
