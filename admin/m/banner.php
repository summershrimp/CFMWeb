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
		$str .= " <span>·</span> ";
		switch ($page) {
		case "personal":
			$str .= "<a href='?page=$page'>账户设置</a>";
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
		case "detail":
			$str .= "<a href='?page=$page'>订单详情管理</a>";
			break;
		case "economic":
			$str .= "<a href='?page=$page'>财务管理</a>";
			break;
		case "ant":
			$str .= "<a href='?page=$page'>Ant信息管理</a>";
			break;
		case "good":
			$str .= "<a href='?page=$page'>商品管理</a>";
			break;
		case "user":
			$str .= "<a href='?page=$page'>用户管理</a>";
			break;
		}
		if (isset($_GET['function'])) {
			$function = $_GET['function'];
			$str .= " <span>·</span> ";
			if (strstr($function, "new")) {
				$str .= "<a href='?page=$page&function=$function'>添加新信息</a>";
			}
			else if (strstr($function, "edit")) {
				$str .= "<a href='?page=$page&function=$function'>编辑信息</a>";
			}
			else if (strstr($function, "delete")) {
				$str .= "删除条目";
			}
			else if ($function == "filter") {
				$str .= "条件过滤";
			}
		}
	}
	echo "<span>当前位置： $str</span>";
?>
</div>
