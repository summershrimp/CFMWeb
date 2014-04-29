<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
session_destroy();
echo "<meta http-equiv=\"refresh\" content=\"0; url=?\">";
?>
