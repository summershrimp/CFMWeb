<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
class Database {
	function Database($host, $username, $password, $name) {
		$db = mysql_connect($host, $username, $password);
		mysql_select_db(DB_NAME);
		mysql_query("SET NAMES UTF8");
	}
	function select($content, $table_name, $condition = NULL, $limit = 0, $desc = false) {
		$sql = "SELECT $content FROM `" . DB_TABLE_PRE . "$table_name`";
		if ($condition != NULL) {
			$sql .= " WHERE $condition";
		}
		if ($limit > 0) {
			$sql .= " LIMIT $limit";
		}
		if ($desc == true) {
			$sql .= " DESC";
		}
		$result = mysql_query($sql);
		return $result;
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
	function insert($table_name, $values) {
		$sql = "INSERT INTO `" . DB_TABLE_PRE . "$table_name` VALUES($values)";
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
