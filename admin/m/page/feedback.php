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
	case 'filter':
		$filter = true;
	}
}
$cond = "";
if ($filter == true) {
	$cond = contact_condition($cond, 'fback_id');
	$cond = contact_condition($cond, 'id');
	$cond = contact_condition($cond, 'role');
	$cond = contact_condition($cond, 'content', false);
}
if ($cond == "") {
	$cond = NULL;
}
$_POST = safe_output($_POST);
?>
<div class="boxdiv">
	<span class="titlespan dep1">用户反馈列表<span class="commit">» 集结了各个用户群的反馈信息</span></span>
</div>
<div class="boxdiv">
	<span class="titlespan dep2">搜索记录</span>
	<form action="?page=feedback&function=filter" method="post">
		<span class="fixed">记录ID：</span>
		<input class="text" type="text" name="fback_id" placeholder="依据记录ID过滤" value="<?php if (isset($_POST['fback_id'])) echo $_POST['fback_id']; ?>"><br>
		<span class="fixed">用户ID：</span>
		<input class="text" type="text" name="id" placeholder="依据用户ID过滤" value="<?php if (isset($_POST['id'])) echo $_POST['id']; ?>"><br>
		<span class="fixed">用户群：</span>
		<input class="text" type="text" name="role" placeholder="依据用户群过滤" value="<?php if (isset($_POST['role'])) echo $_POST['role']; ?>"><br>
		<span class="fixed">反馈内容：</span>
		<input class="text" type="text" name="content" placeholder="依据反馈内容过滤" value="<?php if (isset($_POST['content'])) echo $_POST['content']; ?>">
		<span class="tooltip">支持模糊搜索</span><br>
		<p class="psubmit">
			<input class="button" type="submit" value="搜索">
			<input class="button" type="reset">
		</p>
	</form>
</div>
<div class="boxdiv"><span class="titlespan dep2">反馈信息列表</span>
	<?php $show = make_page_controller("feedback", "feedback", "fback_id", $cond, $_GET['pr']); ?>
	<table style="margin-right:20px;">
		<tr class="trtitle">
			<td>#</td>
			<td>ID</td>
			<td>用户ID</td>
			<td>用户群</td>
			<td>反馈信息</td>
		</tr>
		<?php
		if ($show == true) {
			$result = $GLOBALS['db']->get_page_content("*", "feedback", $cond, $_GET['pr']);
			if ($result != false) {
				$count = 0;
				while ($feedback = $GLOBALS['db']->fetch($result)) {
					$feedback = safe_output($feedback);
					$count++;
					$style = ($count - 1) % 2;
					echo "<tr class='tr$style'>";
					echo "<td style='width:30px;'>$count</td>";
					echo "<td style='width:60px;'>" . $feedback['fback_id'] . "</td>";
					echo "<td style='width:60px;'>" . $feedback['id'] . "</td>";
					switch ($feedback['role']) {
					case '101':
						$role = "商家";
						break;
					case '102':
						$role = "用户";
						break;
					case '103':
						$role = "Ant";
						break;
					default:
						$role = "";
						break;
					}
					echo "<td style='width:60px;'>" . $role . "</td>";
					echo "<td class='tdclip'>" . $feedback['content'] . "</td>";
					echo "</tr>";
				}
			}
		}
		?>
	</table>
</div>
