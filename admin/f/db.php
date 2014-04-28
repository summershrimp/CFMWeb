<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
class Database {
	function Database($host, $username, $password, $name) {
		$GLOBALS['db'] = mysql_connect($host, $username, $password);
		mysql_select_db(DB_NAME);
		mysql_query("SET NAMES UTF8");
		mysql_query("SET time_zone='+8:00'");
	}
	function query($sql) {
		$result = mysql_query($sql);
		return $result;
	}
	function select($content, $table_name, $condition = NULL, $limit = -1, $limit2 = -1) {
		$sql = "SELECT $content FROM `" . DB_TABLE_PRE . "$table_name`";
		if ($condition != NULL) {
			$sql .= " WHERE $condition";
		}
		if ($limit >= 0) {
			$sql .= " LIMIT $limit";
			if ($limit2 >= 0) {
				$sql .= ", " . $limit2;
			}
		}
		$result = mysql_query($sql);
		return $result;
	}
	function count($content, $table_name, $condition) {
		$sql = "SELECT count($content) FROM " . DB_TABLE_PRE . "$table_name";
		if ($condition != NULL) {
			$sql .= " WHERE $condition";
		}
		$result = mysql_query($sql);
		$result = mysql_fetch_array($result);
		return $result[0];
	}
	function get_page_content($content, $table_name, $condition, $page) {
		//
		// 可以优化
		//
		return $this->select($content, $table_name, $condition, ($page - 1) * PAGE_LENGTH, PAGE_LENGTH);
	}
	function fetch($resource) {
		return mysql_fetch_array($resource);
	}
	function update($table_name, $content, $condition = NULL, $limit = 0) {
		$sql = "UPDATE `" . DB_TABLE_PRE . "$table_name` SET $content";
		if ($condition != NULL) {
			$sql .= " WHERE $condition";
		}
		if ($limit > 0) {
			$sql .= " LIMIT $limit";
		}
		$result = mysql_query($sql);
		return $result;
	}
	function insert($table_name, $keys, $values) {
		$sql = "INSERT INTO `" . DB_TABLE_PRE . "$table_name` (" .
			join(", ", quot($keys, "`")) . ") VALUES(" .
			join(", ", quot($values, "'")) . ")";
		$result = mysql_query($sql);
		return $result;
	}
	function delete($table_name, $condition, $limit) {
		$sql = "DELETE FROM `" . DB_TABLE_PRE . "$table_name` WHERE $condition";
		if ($limit > 0) {
			$sql .= " LIMIT $limit";
		}
		$result = mysql_query($sql);
		return $result;
	}
}
?>
