<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
function check($db, $alt, $page, $row, $exit) {
	if (isset($_GET[$alt])) {
		$get = $_GET[$alt];
		$result = $db->select("*", "providers", "`$row`='$get'", 1);
		if ($result != false) {
			$provider = $db->fetch($result);
			if (!empty($provider)) {
				require $page;
				if ($exit == true) {
					exit;
				}
				return;
			}
		}
		echo "<div class=\"returnerror\">业主未找到！</div>";
	}
	else {
		echo "<div class=\"returnerror\">未指明业主！</div>";
	}
}
$db = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$filter = false;
if (isset($_GET['function'])) {
	switch ($_GET['function']) {
	case 'editprovider':
		check($db, 'detail', "m/provider/editprovider.php", 'provider_id', true);
		break;
	case 'deleteprovider':
		check($db, 'detail', "f/provider/deleteprovider.php", 'provider_id', false);
		break;
	case 'deleteproviders':
		require "f/provider/deleteproviders.php";
		break;
	case 'newprovider':
		require "m/provider/newprovider.php";
		exit;
		break;
	case 'filter':
		$filter = true;
	}
}
?>
<div class="boxdiv">
	<span class="titlespan">搜索业主</span>
	<form action="?page=provider&function=filter" method="post">
		<span class="fixed">业主ID：</span>
		<input class="text" type="text" name="provider_id" placeholder="依据业主ID过滤" value="<?php if (isset($_POST['provider_id'])) echo $_POST['provider_id']; ?>"><br>
		<span class="fixed">业主姓名：</span>
		<input class="text" type="text" name="provider_name" placeholder="依据业主名称过滤" value="<?php if (isset($_POST['provider_name'])) echo $_POST['provider_name']; ?>"><br>
		<span class="fixed">业主电话：</span>
		<input class="text" type="text" name="mobile_phone" placeholder="依据业主电话过滤" value="<?php if (isset($_POST['mobile_phone'])) echo $_POST['mobile_phone']; ?>"><br>
		<p class="psubmit">
			<input class="button" type="submit" value="搜索">
			<input class="button" type="reset">
		</p>
	</form>
</div>
<div class="boxdiv">
	<span class="titlespan">业主列表</span>
	<form action="#" method="post">
		<table class="table" style="margin-right:20px;">
			<tr class="trtitle">
				<td></td>
				<td style="width:20px;">#</td>
				<td>操作</td>
				<td>ID</td>
				<td>姓名</td>
				<td>电话</td>
			</tr>
			<?php
			$result = $db->select("*", "providers");
			if ($result != false) {
				$count = 0;
				while ($provider = $db->fetch($result)) {
					$match = true;
					if ($filter == true) {
						if (isset($_POST['provider_id']) && $_POST['provider_id'] != "" && $provider['provider_id'] != $_POST['provider_id']) {
							$match = false;
						}
						if (isset($_POST['provider_name']) && $_POST['provider_name'] != "" && !strstr($provider['provider_name'], $_POST['provider_name'])) {
							$match = false;
						}
						if (isset($_POST['mobile_phone']) && $_POST['mobile_phone'] != "" && !strstr($provider['mobile_phone'], $_POST['mobile_phone'])) {
							$match = false;
						}
					}
					if ($match == false) {
						continue;
					}
					$count++;
					$style = ($count - 1) % 2;
					echo "<tr class='tr$style'>";
					echo "<td><input type='checkbox' name='chk[]' value='" . $provider['provider_id'] . "'></td>";
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
					echo "<td>" . $provider['mobile_phone'] . "</td>";
					echo "</tr>";
				}
			}
			?>
		</table>
		<p class="psubmit">
			<a href="?page=provider&function=newprovider"><input class="button" type="button" value="添加业主"></a>
			<a href="javascript:del('?page=provider&function=deleteproviders')"><input class="button" type="button" value="删除已选"></a>
			<input class="button" type="reset">
		</p>
	</form>
</div>
