<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
if (isset($_GET['page'])) {
	$page = $_GET['page'];
}
else {
	$page = "";
}
?>
<div id="logo">管理中心</div>
<div id="pager">
	<a href="?page=personal"><span class="pagerbutton"<?php if ($page == "personal") echo "id='leftcheck'"; ?>>个人信息</span></a>
	<a href="?page=shop"><span class="pagerbutton"<?php if ($page == "shop") echo "id='leftcheck'"; ?>>商家信息管理</span></a>
	<a href="?page=order"><span class="pagerbutton"<?php if ($page == "order") echo "id='leftcheck'"; ?>>订单信息管理</span></a>
	<a href="?page=economic"><span class="pagerbutton"<?php if ($page == "economic") echo "id='leftcheck'"; ?>>财务管理</span></a>
	<a href="?page=ant"><span class="pagerbutton"<?php if ($page == "ant") echo "id='leftcheck'"; ?>>Ants管理</span></a>
	<a href="?page=user"><span class="pagerbutton"<?php if ($page == "user") echo "id='leftcheck'"; ?>>用户管理</span></a>
	<a href="?action=logout"><span class="pagerbutton">退出登录</span></a>
</div>
