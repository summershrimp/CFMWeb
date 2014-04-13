<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
?>
<div id="banner">
<?php
	$str = "<a href='?'>管理中心</a>";
	if (isset($_GET['page'])) {
		$page = $_GET['page'];
		$str .= " » ";
		switch ($page) {
		case "personal":
			$str .= "<a href='?page=$page'>个人信息</a>";
			break;
		case "shop":
			$str .= "<a href='?page=$page'>商家信息管理</a>";
			break;
		case "provider":
			$str .= "<a href='?page=$page'>业主信息管理</a>";
			break;
		case "order":
			$str .= "<a href='?page=$page'>订单信息管理</a>";
			break;
		case "economic":
			$str .= "<a href='?page=$page'>财务管理</a>";
			break;
		case "ant":
			$str .= "<a href='?page=$page'>Ants管理</a>";
			break;
		case "user":
			$str .= "<a href='?page=$page'>用户管理</a>";
			break;
		}
		if (isset($_GET['function'])) {
			$function = $_GET['function'];
			$str .= " » ";
			switch ($function) {
			case "editpersonal":
				$str .= "编辑个人信息";
				break;
			case "newshop":
				$str .= "<a href='?page=$page&function=$function'>添加商家</a>";
				break;
			case "editshop":
				$str .= "编辑商家信息";
				break;
			case "deleteshop": case "deleteshops":
				$str .= "删除商家";
				break;
			case "newant":
				$str .= "<a href='?page=$page&function=$function'>添加Ant</a>";
				break;
			case "editant":
				$str .= "编辑Ant信息";
				break;
			case "deleteant": case "deleteants":
				$str .= "删除Ant";
				break;
			case "filter":
				$str .= "条件过滤";
				break;
			}
		}
	}
	echo "<span>当前位置： $str</span>";
?>
</div>
