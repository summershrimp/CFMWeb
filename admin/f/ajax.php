<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}

$content = $_GET['content'];
switch ($_GET['page']) {
case 'shop':
	switch ($_GET['row']) {
	case 'shop_name':
		$result = $GLOBALS['db']->select("shop_name", "shop", "`shop_name`='$content'");
		$result = $GLOBALS['db']->fetch($result);
		if ($result == NULL) {
			echo "<span class='valid'>名称可以使用：" . safe_output($content) . "</span>";
		}
		else {
			echo "<span class='invalid'>! 名称已存在：" . safe_output($content) . "</span>";
		}
		break;
	case 'shop_owner_id':
		$result = $GLOBALS['db']->select("shop_id", "shop", "`owner_id`='$content'");
		$result = $GLOBALS['db']->fetch($result);
		if ($result == NULL) {
			$r = $GLOBALS['db']->select("provider_name", "providers", "`provider_id`='$content'");
			$r = $GLOBALS['db']->fetch($r);
			if ($r == NULL) {
				echo "<span class='invalid'>! 不存在的业主：ID=" . safe_output($content) . "</span>";
			}
			else {
				echo "<span class='valid'>可以绑定业主：" . safe_output($r['provider_name']) . "</span>";
			}
		}
		else {
			$r = $GLOBALS['db']->select("provider_name", "providers", "`provider_id`='$content'");
			$r = $GLOBALS['db']->fetch($r);
			if ($result['shop_id'] == $_GET['ignore']) {
				echo "<span class='valid'>" . safe_output($r['provider_name']) . "是当前的业主</span>";
			}
			else {
				echo "<span class='invalid'>! 业主已被绑定：" . safe_output($r['provider_name']) . "</span>";
			}
		}
		break;
	case 'shop_phone':
		echo "<span class='valid'>可以使用：" . safe_output($content) . "</span>";
		break;
	case 'shop_pos':
		$result = $GLOBALS['db']->select("shop_pos, shop_name", "shop", "`shop_pos`='$content'");
		$result = $GLOBALS['db']->fetch($result);
		if ($result == NULL) {
			echo "<span class='valid'>位置可以使用</span>";
		}
		else {
			echo "<span class='invalid'>! 位置与已知商家重复：" . safe_output($result['shop_name']) . "</span>";
		}
		break;
	}
	break;
}
?>
