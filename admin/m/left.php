<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
?>
<div id="logo"><img src="images/logo.png" alt="logo"></div>
<div id="pager">
	<span class="pagerbutton"<?php if (isset($_GET['page']) && $_GET['page'] == "personal") echo "id='leftcheck'"; ?>><a href="?page=personal">个人信息</a></span>
	<span class="pagerbutton"<?php if (isset($_GET['page']) && $_GET['page'] == "shop") echo "id='leftcheck'"; ?>><a href="?page=shop">商家信息管理</a></span>
	<span class="pagerbutton"<?php if (isset($_GET['page']) && $_GET['page'] == "order") echo "id='leftcheck'"; ?>><a href="?page=order">订单信息管理</a></span>
	<span class="pagerbutton"<?php if (isset($_GET['page']) && $_GET['page'] == "economic") echo "id='leftcheck'"; ?>><a href="?page=economic">财务管理</a></span>
	<span class="pagerbutton"<?php if (isset($_GET['page']) && $_GET['page'] == "ant") echo "id='leftcheck'"; ?>><a href="?page=ant">Ants管理</a></span>
	<span class="pagerbutton"<?php if (isset($_GET['page']) && $_GET['page'] == "user") echo "id='leftcheck'"; ?>><a href="?page=user">用户管理</a></span>
	<span class="pagerbutton"><a href="?action=logout">退出登录</a></span>
</div>
