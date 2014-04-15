<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$db = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$filter = false;
if (isset($_GET['function'])) {
	switch ($_GET['function']) {
	case 'editant':
		check_and_open($db, 'ants', 'detail', "m/ant/editant.php", 'ant_id', true, "Ant");
		break;
	case 'deleteant':
		check_and_open($db, 'ants', 'detail', "f/ant/deleteant.php", 'ant_id', false, "Ant");
		break;
	case 'deleteants':
		require "f/ant/deleteants.php";
		break;
	case 'newant':
		require "m/ant/newant.php";
		exit();
		break;
	case 'filter':
		$filter = true;
	}
}
$cond = "";
if ($filter == true) {
	$cond = contact_condition($cond, 'ant_id');
	$cond = contact_condition($cond, 'ant_name');
	$cond = contact_condition($cond, 'email', false);
	$cond = contact_condition($cond, 'ant_real_name');
	if (isset($_POST['sex']) && $_POST['sex'] != -1) $cond = contact_condition($cond, 'sex');
	$cond = contact_condition($cond, 'mobile_phone');
}
if ($cond == "") {
	$cond = NULL;
}
?>
<div class="boxdiv">
	<span class="titlespan dep1">Ant信息管理<span class="commit">» 商家和用户们的连接点，勤劳的Ants们</span></span>
</div>
<div class="boxdiv">
	<span class="titlespan dep2">搜索Ant</span>
	<form action="?page=ant&function=filter" method="post">
		<span class="fixed">AntID：</span>
		<input class="text" type="text" name="ant_id" placeholder="依据AntID过滤" value="<?php if (isset($_POST['ant_id'])) echo $_POST['ant_id']; ?>"><br>
		<span class="fixed">昵称：</span>
		<input class="text" type="text" name="ant_name" placeholder="依据Ant昵称过滤" value="<?php if (isset($_POST['ant_name'])) echo $_POST['ant_name']; ?>"><br>
		<span class="fixed">邮箱：</span>
		<input class="text" type="text" name="email" placeholder="依据Ant邮箱过滤" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
		<span class="tooltip">* 支持模糊搜索</span><br>
		<span class="fixed">真实姓名：</span>
		<input class="text" type="text" name="ant_real_name" placeholder="依据Ant真实姓名过滤" value="<?php if (isset($_POST['ant_real_name'])) echo $_POST['ant_real_name']; ?>"><br>
		<span class="fixed">性别：</span>
		<span><input type="radio" name="sex" value="-1" <?php if (!isset($_POST['sex']) || $_POST['sex'] == -1) echo "checked"; ?>>全部</span>&nbsp;
		<span><input type="radio" name="sex" value="0" <?php if (isset($_POST['sex']) && $_POST['sex'] == 0) echo "checked"; ?>>男</span>&nbsp;
		<span><input type="radio" name="sex" value="1" <?php if (isset($_POST['sex']) && $_POST['sex'] == 1) echo "checked"; ?>>女</span><br>
		<span class="fixed">手机：</span>
		<input class="text" type="text" name="mobile_phone" placeholder="依据Ant手机过滤" value="<?php if (isset($_POST['mobile_phone'])) echo $_POST['mobile_phone']; ?>"><br>
		<p class="psubmit">
			<input class="button" type="submit" value="搜索">
			<input class="button" type="reset">
		</p>
	</form>
</div>
<div class="boxdiv"><span class="titlespan dep2">Ant列表</span>
	<form action="#" method="post">
		<table style="margin-right:20px;">
			<tr class="trtitle">
				<td></td>
				<td style="width:20px;">#</td>
				<td>操作</td>
				<td>ID</td>
				<td>昵称</td>
				<td>邮箱</td>
				<td>真实姓名</td>
				<td>性别</td>
				<td>手机</td>
			</tr>
			<?php
			$result = $db->select("*", "ants", $cond);
			if ($result != false) {
				$count = 0;
				while ($ant = $db->fetch($result)) {
					$count++;
					$style = ($count - 1) % 2;
					echo "<tr class='tr$style'>";
					echo "<td style='text-align:center;'><input type='checkbox' name='chk[]' value='" . $ant['ant_id'] . "'></td>";
					echo "<td>$count</td>";
					echo "<td>&nbsp;";
					echo "<a href='?page=ant&function=editant&detail=" . $ant['ant_id'] . "'>";
					echo "<img src='images/icon_edit.png' alt='修改'>";
					echo "<span class='link'>修改</span></a>&nbsp;";
					echo "<a href='javascript:del(\"?page=ant&function=deleteant&detail=" . $ant['ant_id'] . "\")'>";
					echo "<img src='images/icon_del.png' alt='删除'>";
					echo "<span class='link'>删除</span></a>";
					echo "&nbsp;</td>";
					echo "<td>" . $ant['ant_id'] . "</td>";
					echo "<td>" . $ant['ant_name'] . "</td>";
					echo "<td>" . $ant['email'] . "</td>";
					echo "<td class='tdclip'>" . $ant['ant_real_name'] . "</td>";
					echo "<td>" . (($ant['sex'] == 0) ? "男" : "女") . "</td>";
					echo "<td>" . $ant['mobile_phone'] . "</td>";
					echo "</tr>";
				}
			}
			?>
		</table>
		<p class="psubmit">
			<a href="?page=ant&function=newant"><input class="button" style="float:left;" type="button" value="添加Ant"></a>
			<a href="javascript:del('?page=ant&function=deleteants')"><input class="button dangerousbutton" type="button" value="批量删除"></a>
			<input class="button" type="reset" value="重新选择">
		</p>
	</form>
</div>
