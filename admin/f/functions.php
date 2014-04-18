<?php
/*
	Describe: 一些实用的小功能
	Author: Rex
*/
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
		echo "<div class=\"return error\">" . $str . "未找到！</div>";
	}
	else {
		echo "<div class=\"return error\">未指明" . $str . "！</div>";
	}
}
function quot($arr, $char) {
	$result = array();
	foreach ($arr as $e) {
		$result[] = $char . $e . $char;
	}
	return $result;
}
function get_post($arr) {
	$result = array();
	foreach ($arr as $e) {
		$result[] = $_POST[$e];
	}
	return $result;
}
function make_page_controller($db, $page, $table_name, $row, $cond, $pr) {
	$result = $db->count($row, $table_name, $cond);
	echo "<div id=\"pagecontroller\">";
	if ($pr > $result) {
		echo "<span class='pageerror'>不正确的页！</span>";
		echo "</div>";
		return false;
	}
	echo "共有记录";
	echo "<span class='pagemark'>$result</span>";
	echo "条，当前为第";
	echo "<span class='pagemark'>$pr</span>";
	echo "页 / 共";
	$result = ceil($result / PAGE_LENGTH);
	echo "<span class='pagemark'>$result</span>";
	echo "页";
	if ($pr < $result) {
		echo "<a href='?page=" . $page . "&pr=" . $result . "'>尾页</a>";
		echo "<a href='?page=" . $page . "&pr=" . ($pr + 1) . "'>下一页</a>";
	}
	else {
		echo "<a class='disabled'>尾页</a>";
		echo "<a class='disabled'>下一页</a>";
	}
	if ($pr > 1) {
		echo "<a href='?page=" . $page . "&pr=" . ($pr - 1) . "'>上一页</a>";
		echo "<a href='?page=" . $page . "&pr=1'>首页</a>";
	}
	else {
		echo "<a class='disabled'>上一页</a>";
		echo "<a class='disabled'>首页</a>";
	}
	echo "</div>";
	return true;
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
		return is_array($value) ? array_map('html_special_chars', $value) : safe_html($value);
	}
}
/* 对用户传入的变量进行转义操作 */
$_GET = html_special_chars($_GET);
$_POST = html_special_chars($_POST);
$_COOKIE = html_special_chars($_COOKIE);
$_REQUEST = html_special_chars($_REQUEST);
if (!get_magic_quotes_gpc()) {
	$_GET = addslashes_deep($_GET);
	$_POST = addslashes_deep($_POST);
	$_COOKIE = addslashes_deep($_COOKIE);
	$_REQUEST = addslashes_deep($_REQUEST);
}
?>
