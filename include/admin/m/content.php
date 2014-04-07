<div id="content">
<?php
	if (!isset($page)) {
		$page = "default";
	}
	switch ($page) {
	case "shop":
		break;
	case "order":
		break;
	case "economic":
		break;
	case "ant":
		break;
	case "user":
		break;
	default:
		echo "<p>欢迎。</p>";
		echo "<p>这是cfm的管理界面。</p>";
		echo "<p>请从左边选择相应的管理项目。</p>";
	}
?>
</div>
