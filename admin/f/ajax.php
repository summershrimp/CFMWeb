<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}

$db = new DataBase(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

$content = $_GET['content'];
switch ($_GET['page']) {
case 'shop':
	switch ($_GET['row']) {
	case 'shop_name':
		$result = $db->select("shop_name", "shop", "`shop_name`='$content'");
		$result = $db->fetch($result);
		if ($result == NULL) {
			echo "<span class='valid'>名称可以使用：$content</span>";
		}
		else {
			echo "<span class='invalid'>! 名称已存在：$content</span>";
		}
		break;
	case 'shop_owner_id':
		$result = $db->select("shop_id", "shop", "`owner_id`='$content'");
		$result = $db->fetch($result);
		if ($result == NULL) {
			$r = $db->select("provider_name", "providers", "`provider_id`='$content'");
			$r = $db->fetch($r);
			if ($r == NULL) {
				echo "<span class='invalid'>! 不存在的业主：ID=$content</span>";
			}
			else {
				echo "<span class='valid'>可以绑定业主：" . $r['provider_name'] . "</span>";
			}
		}
		else {
			$r = $db->select("provider_name", "providers", "`provider_id`='$content'");
			$r = $db->fetch($r);
			if ($result['shop_id'] == $_GET['ignore']) {
				echo "<span class='valid'>" . $r['provider_name'] . "是当前的业主</span>";
			}
			else {
				echo "<span class='invalid'>! 业主已被绑定：" . $r['provider_name'] . "</span>";
			}
		}
		break;
	case 'shop_phone':
		echo "<span class='valid'>可以使用：$content</span>";
		break;
	case 'shop_pos':
		$result = $db->select("shop_pos, shop_name", "shop", "`shop_pos`='$content'");
		$result = $db->fetch($result);
		if ($result == NULL) {
			echo "<span class='valid'>位置可以使用</span>";
		}
		else {
			echo "<span class='invalid'>! 位置与已知商家重复：" . $result['shop_name'] . "</span>";
		}
		break;
	}
	break;
}
?>
