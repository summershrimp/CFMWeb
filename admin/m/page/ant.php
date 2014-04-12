<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
function check($db, $alt, $page, $row, $exit) {
	if (isset($_GET[$alt])) {
		$get = $_GET[$alt];
		$result = $db->select("*", "ants", "`$row`='$get'", 1);
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
		echo "<div class=\"returnerror\">Ant未找到！</div>";
	}
	else {
		echo "<div class=\"returnerror\">未指明Ant！</div>";
	}
}
$db = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$filter = false;
if (isset($_GET['function'])) {
	switch ($_GET['function']) {
	case 'editant':
		check($db, 'detail', "m/ant/editant.php", 'ant_id', true);
		break;
	case 'deleteant':
		check($db, 'detail', "f/ant/deleteant.php", 'ant_id', false);
		break;
	case 'deleteants':
		require "f/ant/deleteants.php";
		break;
	case 'newant':
		require "m/ant/newant.php";
		exit;
		break;
	case 'filter':
		$filter = true;
	}
}
?>
<div class="boxdiv">
	<span class="titlespan">搜索Ant</span>
	<form action="?page=ant" method="post">
		<span class="fixed">AntID：</span>
		<input class="text" type="text" name="ant_id" placeholder="依据AntID过滤" value="<?php if (isset($_POST['ant_id'])) echo $_POST['ant_id']; ?>"><br>
		<span class="fixed">名称：</span>
		<input class="text" type="text" name="name" placeholder="依据昵称过滤" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>"><br>
		<span class="fixed">邮箱：</span>
		<input class="text" type="text" name="email" placeholder="依据邮箱过滤" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"><br>
		<span class="fixed">真实姓名：</span>
		<input class="text" type="text" name="real_name" placeholder="依据真实姓名过滤" value="<?php if (isset($_POST['real_name'])) echo $_POST['real_name']; ?>"><br>
		<span class="fixed">性别：</span>
		<span><input type="radio" name="sex" value="-1" <?php if (!isset($_POST['sex']) || $_POST['sex'] == -1) echo "checked"; ?>>全部</span>&nbsp;
		<span><input type="radio" name="sex" value="0" <?php if (isset($_POST['sex']) && $_POST['sex'] == 0) echo "checked"; ?>>男</span>&nbsp;
		<span><input type="radio" name="sex" value="1" <?php if (isset($_POST['sex']) && $_POST['sex'] == 1) echo "checked"; ?>>女</span><br>
		<span class="fixed">手机：</span>
		<input class="text" type="text" name="mobile" placeholder="依据手机过滤" value="<?php if (isset($_POST['mobile'])) echo $_POST['mobile']; ?>"><br>
		<p class="psubmit">
			<input class="button" type="submit" value="搜索">
			<input class="button" type="reset">
		</p>
	</form>
</div>
<div class="boxdiv">
	<span class="titlespan">Ant列表</span>
	<form action="?page=ant&function=deleteants" method="post">
		<table class="table" style="margin-right:20px;">
			<tr class="trtitle">
				<td></td>
				<td style="width:20px;">#</td>
				<td>AntID</td>
				<td>名称</td>
				<td>邮箱</td>
				<td>真实姓名</td>
				<td>性别</td>
				<td>手机</td>
				<td>操作</td>
			</tr>
			<?php
			$result = $db->select("*", "ants");
			if ($result != false) {
				$count = 0;
				while ($r = $db->fetch($result)) {
					$count++;
					$style = ($count - 1) % 2;
					echo "<tr class='tr$style'>";
					echo "<td><input type='checkbox' name='chk[]' value='" . $r['ant_id'] . "'></td>";
					echo "<td>$count</td>";
					echo "<td>" . $r['ant_id'] . "</td>";
					echo "<td>" . $r['ant_name'] . "</td>";
					echo "<td>" . $r['email'] . "</td>";
					echo "<td>" . $r['ant_real_name'] . "</td>";
					echo "<td>" . ($r['sex'] == "0" ? "男" : "女") . "</td>";
					echo "<td>" . $r['mobile_phone'] . "</td>";
					echo "<td>&nbsp;";
					echo "<a href='?page=ant&function=editant&detail=" . $r['ant_id'] . "'>";
					echo "<img src='images/icon_edit' alt='修改'>";
					echo "<span class='link'>修改</span></a>&nbsp;";
					echo "<a href='?page=ant&function=deleteant&detail=" . $r['ant_id'] . "'>";
					echo "<img src='images/icon_del' alt='删除'>";
					echo "<span class='link'>删除</span></a>";
					echo "&nbsp;</td>";
					echo "</tr>";
				}
			}
			?>
		</table>
		<p class="psubmit">
			<a href="?page=ant&function=newant"><input class="button" type="button" value="添加Ant"></a>
			<input class="button" type="submit" value="删除已选">
			<input class="button" type="reset">
		</p>
	</form>
</div>
