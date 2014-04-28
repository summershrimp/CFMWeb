<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
if (isset($_POST['shop_name']) && isset($_POST['owner_id']) &&
	isset($_POST['shop_phone']) && isset($_POST['shop_pos']) &&
	isset($_POST['shop_desc']) && isset($_POST['isopen']) &&
	$_POST['shop_name'] != "" && $_POST['owner_id'] != "" &&
	$_POST['shop_phone'] != "" && $_POST['shop_pos'] != "" &&
	$_POST['shop_desc'] != "" && $_POST['isopen'] != "") {
	require "f/shop/editshop.php";
}
else if (isset($_POST['shop_name']) && $_POST['shop_name'] != "" ||
	isset($_POST['owner_id']) && $_POST['owner_id'] != "" ||
	isset($_POST['shop_phone']) && $_POST['shop_phone'] != "" ||
	isset($_POST['shop_pos']) && $_POST['shop_pos'] != "" ||
	isset($_POST['shop_desc']) && $_POST['shop_desc'] != "" ||
	isset($_POST['isopen']) && $_POST['isopen'] != "") {
	echo "<div class='return error'>表格中存在未填项！</div>";
}
$result = $GLOBALS['db']->select("*", "shop", "`$row`='$get'", 1);
$result = $GLOBALS['db']->fetch($result);
$id = $result['owner_id'];
$t = $GLOBALS['db']->select("provider_name", "providers", "`provider_id`='$id'", 1);
$t = $GLOBALS['db']->fetch($t);
$result = safe_output($result);
$t = safe_output($t);
?>
<div class="boxdiv">
	<span class="titlespan dep2">编辑商家信息（id=<?php echo $result['shop_id']; ?>）</span>
	<form action="?page=shop&function=editshop&detail=<?php echo $result['shop_id']; ?>" method="post">
		<table>
			<tr class="trtitle">
				<td style="width:100px;">属性</td>
				<td style="width:200px;">值</td>
			</tr>
			<tr class="tr0">
				<td>商家名称</td>
				<td><input class="text" type="text" name="shop_name" value="<?php echo $result['shop_name']; ?>"></td>
			</tr>
			<tr class="tr1">
				<td>电话</td>
				<td><input class="text" type="text" name="shop_phone" value="<?php echo $result['shop_phone']; ?>"></td>
			</tr>
			<tr class="tr0">
				<td>位置</td>
				<td><input class="text" type="text" name="shop_pos" value="<?php echo $result['shop_pos']; ?>"></td>
			</tr>
			<tr class="tr1">
				<td>业主ID：</td>
				<td>
					<input onblur="ajax('owner_id','shop','shop_owner_id',this.value,'<?php echo $_GET['detail']; ?>')" class="text" type="text" name="owner_id" value="<?php echo $result['owner_id']; ?>">
					<span id="owner_id" class="ajaxresult"></span>
				</td>
			</tr>
			<tr class="tr0">
				<td>描述</td>
				<td><textarea class="text" type="text" name="shop_desc"><?php echo $result['shop_desc']; ?></textarea></td>
			</tr>
			<tr class="tr1">
				<td>营业状况</td>
				<td>
					<span><input type="radio" name="isopen" value="1"<?php if ($result['isopen'] == 1) echo "checked"; ?>>正常营业</span>
					<span><input type="radio" name="isopen" value="0"<?php if ($result['isopen'] == 0) echo "checked"; ?>>全店关闭</span>
				</td>
			</tr>
		</table>
		<p class="psubmit">
			<input class="button" type="submit" value="修改">
			<input class="button" type="reset">
			<a href="?page=shop"><input class="button" type="button" value="返回"></a>
		</p>
	</form>
</div>
