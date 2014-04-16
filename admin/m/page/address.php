<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$db = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$filter = false;
if (isset($_GET['function'])) {
	switch ($_GET['function']) {
	case 'editaddress':
		check_and_open($db, 'user_address', 'address', "m/address/editaddress.php", 'address_id', true, "用户详情");
		break;
	case 'deleteaddress':
		check_and_open($db, 'user_address', 'address', "f/address/deleteaddress.php", 'address_id', false, "用户详情");
		break;
	case 'deleteaddresses':
		require "f/address/deleteaddresses.php";
		break;
	case 'newaddress':
		require "m/address/newaddress.php";
		exit();
		break;
	case 'filter':
		$filter = true;
	}
}
$cond = "";
if ($filter == true) {
	$cond = contact_condition($cond, 'addr_id');
	$cond = contact_condition($cond, 'user_id');
	$cond = contact_condition($cond, 'user_realname', false);
	$cond = contact_condition($cond, 'user_phone');
	$cond = contact_condition($cond, 'address', false);
}
if ($cond == "") {
	$cond = NULL;
}
?>
<div class="boxdiv">
	<span class="titlespan dep1">用户信息<span class="commit">» 这里存了每一个用户的真实信息</span></span>
</div>
<div class="boxdiv">
	<span class="titlespan dep2">搜索用户信息</span>
	<form action="?page=address&function=filter" method="post">
		<span class="fixed">记录ID：</span>
		<input class="text" type="text" name="addr_id" placeholder="依据地址ID过滤" value="<?php if (isset($_POST['addr_id'])) echo $_POST['addr_id']; ?>"><br>
		<span class="fixed">用户ID：</span>
		<input class="text" type="text" name="user_id" placeholder="依据用户ID过滤" value="<?php if (isset($_POST['user_id'])) echo $_POST['user_id']; ?>"><br>
		<span class="fixed">真实姓名：</span>
		<input class="text" type="text" name="user_realname" placeholder="依据用户真实姓名过滤" value="<?php if (isset($_POST['user_realname'])) echo $_POST['user_realname']; ?>">
		<span class="tooltip">* 支持模糊搜索</span><br>
		<span class="fixed">用户手机：</span>
		<input class="text" type="text" name="user_phone" placeholder="依据用户手机过滤" value="<?php if (isset($_POST['user_phone'])) echo $_POST['user_phone']; ?>"><br>
		<span class="fixed">用户地址：</span>
		<input class="text" type="text" name="address" placeholder="依据用户地址过滤" value="<?php if (isset($_POST['address'])) echo $_POST['address']; ?>">
		<span class="tooltip">* 支持模糊搜索</span><br>
		<p class="psubmit">
			<input class="button" type="submit" value="搜索">
			<input class="button" type="reset">
		</p>
	</form>
</div>
<div class="boxdiv"><span class="titlespan dep2">用户列表</span>
	<form action="#" method="post">
		<table style="margin-right:20px;">
			<tr class="trtitle">
				<td></td>
				<td style="width:20px;">#</td>
				<td>操作</td>
				<td>ID</td>
				<td>用户ID</td>
				<td>真实姓名</td>
				<td>手机</td>
				<td>地址</td>
			</tr>
			<?php
			$result = $db->select("*", "user_address", $cond);
			if ($result != false) {
				$count = 0;
				while ($address = $db->fetch($result)) {
					$count++;
					$style = ($count - 1) % 2;
					echo "<tr class='tr$style'>";
					echo "<td style='text-align:center;'><input type='checkbox' name='chk[]' value='" . $address['addr_id'] . "'></td>";
					echo "<td>$count</td>";
					echo "<td>";
					echo "<a href='?page=address&function=editaddress&address=" . $address['addr_id'] . "'>";
					echo "<img src='images/icon_edit.png' alt='修改'>";
					echo "<span class='link'>修改</span></a>&nbsp;";
					echo "<a href='javascript:del(\"?page=address&function=deleteaddress&address=" . $address['addr_id'] . "\")'>";
					echo "<img src='images/icon_del.png' alt='删除'>";
					echo "<span class='link'>删除</span></a></td>";
					echo "<td>" . $address['addr_id'] . "</td>";
					echo "<td>" . $address['user_id'] . "</td>";
					echo "<td>" . $address['user_realname'] . "</td>";
					echo "<td>" . $address['user_phone'] . "</td>";
					echo "<td class='tdclip'>" . $address['address'] . "</td>";
					echo "</tr>";
				}
			}
			?>
		</table>
		<p class="psubmit">
			<a href="?page=address&function=newaddress"><input class="button" style="float:left;" type="button" value="添加用户"></a>
			<a href="javascript:del('?page=address&function=deleteaddresses')"><input class="button dangerousbutton" type="button" value="批量删除"></a>
			<input class="button" type="reset" value="重新选择">
		</p>
	</form>
</div>
