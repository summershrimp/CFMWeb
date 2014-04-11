<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
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
		</tr>
		<?php
		$db = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$result = $db->select("*", "user_info");
		if ($result != false) {
			$count = 0;
			while ($user = $db->fetch($result)) {
				$match = true;
				if ($filter == true) {
					if (isset($_POST['user_id']) && $_POST['user_id'] != "" && !strstr($user['user_id'], $_POST['user_id'])) {
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
				echo "</tr>";
			}
		}
		?>
	</table>
</div>
