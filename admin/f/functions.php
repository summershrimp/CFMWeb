<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
function check_and_open($db, $table, $alt, $page, $row, $exit, $str) {
	if (isset($_GET[$alt])) {
		$get = $_GET[$alt];
		$result = $db->select("*", "$table", "`$row`='$get'", 1);
		if ($result != false) {
			$r = $db->fetch($result);
			if (!empty($r)) {
				require $page;
				if ($exit == true) {
					exit();
				}
				return;
			}
		}
		echo "<div class=\"returnerror\">" . $str . "未找到！</div>";
	}
	else {
		echo "<div class=\"returnerror\">未指明" . $str . "！</div>";
	}
}
/* 连接sql查询条件 */
function contact_condition($str, $row, $full_match = true) {
	if (isset($_POST[$row]) && $_POST[$row] != NULL) {
		if ($str != "") {
			$str .= " AND ";
		}
		if ($full_match == true) {
			$str .= "`$row`='" . $_POST[$row] . "'";
		}
		else {
			$str .= "`$row` LIKE '%" . $_POST[$row] . "%'";
		}
	}
	return $str;
}
/* 递归方式的对变量中的特殊字符进行转义 */
function addslashes_deep($value) {
	if (empty($value)) {
		return $value;
	}
	else {
		return is_array($value) ? array_map('addslashes_deep', $value) : addslashes($value);
	}
}
/* 过滤html字符 */
function safe_html($str) {
	return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}
function html_special_chars($value) {
	if (empty($value)) {
		return $value;
	}
	else {
		return is_array($value) ? array_map('safe_html', $value) : safe_html($value);
	}
}
/* 对用户传入的变量进行转义操作 */
if (!empty($_GET)) {
	$_GET = html_special_chars($_GET);
}
if (!empty($_POST)) {
	$_POST = html_special_chars($_POST);
}
$_COOKIE = html_special_chars($_COOKIE);
$_REQUEST = html_special_chars($_REQUEST);
if (!get_magic_quotes_gpc()) {
	if (!empty($_GET)) {
		$_GET = addslashes_deep($_GET);
	}
	if (!empty($_POST)) {
		$_POST = addslashes_deep($_POST);
	}
	$_COOKIE = addslashes_deep($_COOKIE);
	$_REQUEST = addslashes_deep($_REQUEST);
}
?>
