<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
if (isset($_POST['name']) && $_POST['name'] != "") {
	require "f/ant/editant.php";
}
$result = $db->select("*", "ants", "`$row`='$get'", 1);
$result = $db->fetch($result);
$id = $result['ant_id'];
?>
<div class="boxdiv">
	<span class="titlespan">编辑Ant信息（id=<?php echo $result['ant_id']; ?>）</span>
	<form action="?page=ant&function=editant&detail=<?php echo $result['ant_id']; ?>" method="post">
		<table class="table">
			<tr class="trtitle">
				<td style="width:100px;">属性</td>
				<td style="width:200px;">值</td>
			</tr>
			<tr class="tr0">
				<td>名称</td>
				<td><input class="text" type="text" name="name" value="<?php echo $result['ant_name']; ?>"></td>
			</tr>
			<tr class="tr1">
				<td>邮箱</td>
				<td><input class="text" type="text" name="email" value="<?php echo $result['email']; ?>"></td>
			</tr>
			<tr class="tr0">
				<td>真实姓名</td>
				<td><input class="text" type="text" name="real_name" value="<?php echo $result['ant_real_name']; ?>"></td>
			</tr>
			<tr class="tr1">
				<td>性别</td>
				<td>
					<span><input type="radio" name="sex" value="0" <?php if ($result['sex'] == 0) echo "checked"; ?>>男</span>
					<span><input type="radio" name="sex" value="1" <?php if ($result['sex'] == 1) echo "checked"; ?>>女</span>
				</td>
			</tr>
			<tr class="tr0">
				<td>手机</td>
				<td><input class="text" type="text" name="mobile" value="<?php echo $result['mobile_phone']; ?>"></td>
			</tr>
		</table>
		<p class="psubmit">
			<input class="button" type="submit" value="修改">
			<input class="button" type="reset">
		</p>
	</form>
</div>
