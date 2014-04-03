<?php

require_once './init.php';
require_once ROOT_PATH . 'include/user.class.php';

$content=json_decode($GLOBALS["HTTP_RAW_POST_DATA"]);

$user=new user();


?>