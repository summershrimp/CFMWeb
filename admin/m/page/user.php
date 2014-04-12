<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$db = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$filter = false;
if (isset($_GET['function'])) {
	switch ($_GET['function']) {
	case 'filter':
		$filter = true;
		break;
	}
}
?>
<div class="boxdiv">
	<span class="titlespan">用户搜索</span>
	<form action="?page=user&function=filter" method="post">
		<span class="fixed">用户ID：</span>
		<input class="text" type="text" name="user_id" placeholder="依据用户ID过滤" value="<?php if (isset($_POST['user_id'])) echo $_POST['user_id']; ?>"><br>
		<span class="fixed">用户名：</span>
		<input class="text" type="text" name="user_name" placeholder="依据用户名过滤" value="<?php if (isset($_POST['user_name'])) echo $_POST['user_name']; ?>"><br>
		<span class="fixed">邮箱：</span>
		<input class="text" type="text" name="email" placeholder="依据邮箱过滤" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"><br>
		<span class="fixed">性别：</span>
		<span><input type="radio" name="sex" value="-1" <?php if (!isset($_POST['sex']) || $_POST['sex'] == -1) echo "checked"; ?>>全部</span>&nbsp;
		<span><input type="radio" name="sex" value="0" <?php if (isset($_POST['sex']) && $_POST['sex'] == 0) echo "checked"; ?>>男</span>&nbsp;
		<span><input type="radio" name="sex" value="1" <?php if (isset($_POST['sex']) && $_POST['sex'] == 1) echo "checked"; ?>>女</span><br>
		<span class="fixed">上次登录IP：</span>
		<input class="text" type="text" name="last_ip" placeholder="依据上次登录IP过滤" value="<?php if (isset($_POST['last_ip'])) echo $_POST['last_ip']; ?>"><br>
		<p class="psubmit">
			<input class="button" type="submit" value="搜索">
			<input class="button" type="reset">
		</p>
	</form>
</div>
<div class="boxdiv">
	<span class="titlespan">用户列表</span>
	<table class="table" style="margin-right:20px;">
		<tr class="trtitle">
			<td style="width:20px;">#</td>
			<td>用户ID</td>
			<td>用户名</td>
			<td>邮箱</td>
			<td>性别</td>
			<td>上次登录IP</td>
		</tr>
		<?php
		$result = $db->select("*", "customers");
		if ($result != false) {
			$count = 0;
			while ($user = $db->fetch($result)) {
				$match = true;
				if ($filter == true) {
					if (isset($_POST['user_id']) && $_POST['user_id'] != "" && $user['user_id'] != $_POST['user_id']) {
						$match = false;
					}
					if (isset($_POST['user_name']) && $_POST['user_name'] != "" && !strstr($user['user_name'], $_POST['user_name'])) {
						$match = false;
					}
					if (isset($_POST['email']) && $_POST['email'] != "" && !strstr($user['email'], $_POST['email'])) {
						$match = false;
					}
					if (isset($_POST['sex']) && $_POST['sex'] != "-1" && $user['sex'] != $_POST['sex']) {
						$match = false;
					}
					if (isset($_POST['last_ip']) && $_POST['last_ip'] != "" && !strstr($user['last_ip'], $_POST['last_ip'])) {
						$match = false;
					}
				}
				if ($match == false) {
					continue;
				}
				$count++;
				$style = ($count - 1) % 2;
				echo "<tr class='tr$style'>";
				echo "<td>$count</td>";
				echo "<td>" . $user['user_id'] . "</td>";
				echo "<td>" . $user['user_name'] . "</td>";
				echo "<td>" . $user['email'] . "</td>";
				echo "<td>" . ($user['sex'] == "0" ? "男" : "女") . "</td>";
				echo "<td>" . $user['last_ip'] . "</td>";
				echo "</tr>";
			}
		}
		?>
	</table>
</div>
