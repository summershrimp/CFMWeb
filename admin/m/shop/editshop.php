<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
if (isset($_POST['name']) && $_POST['name'] != "") {
	require "f/shop/editshop.php";
}
$result = $db->select("*", "shop", "`$row`='$get'", 1);
$result = $db->fetch($result);
$id = $result['owner_id'];
$t = $db->select("provider_name", "providers", "`provider_id`='$id'", 1);
$t = $db->fetch($t);
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
				<td><input class="text" type="text" name="name" value="<?php echo $result['shop_name']; ?>"></td>
			</tr>
			<tr class="tr1">
				<td>电话</td>
				<td><input class="text" type="text" name="phone" value="<?php echo $result['shop_phone']; ?>"></td>
			</tr>
			<tr class="tr0">
				<td>位置</td>
				<td><input class="text" type="text" name="pos" value="<?php echo $result['shop_pos']; ?>"></td>
			</tr>
			<tr class="tr1">
				<td>业主ID：</td>
				<td><input class="text" type="text" name="owner_id" value="<?php echo $result['owner_id']; ?>"></td>
			</tr>
			<tr class="tr0">
				<td>描述</td>
				<td><textarea class="text" type="text" name="desc"><?php echo $result['shop_desc']; ?></textarea></td>
			</tr>
		</table>
		<p class="psubmit">
			<input class="button" type="submit" value="修改">
			<input class="button" type="reset">
			<a href="?page=shop"><input class="button" type="button" value="返回"></a>
		</p>
	</form>
</div>
