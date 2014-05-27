<?php
/*
	Author: Rex Zeng
	Describtion: Shop API
*/
define('IN_CFM', true);
require_once "includes/init.inc.php";
require_once "includes/shop.class.php";

header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type ");

if (!isset($GLOBALS["HTTP_RAW_POST_DATA"])) {
    $return ['status'] = ERROR_CONTENT;
    echo json_encode($return);
    exit();
}

//$fp=fopen("post.log","at");
//fwrite($fp,$GLOBALS["HTTP_RAW_POST_DATA"]."\n");

$content = json_decode($GLOBALS['HTTP_RAW_POST_DATA'], true);

$content = addslashes_deep($content);

$return = array();
$shop = new shop();


$t ;
// Check if action is login
if ($content['act'] == "shop_login") {
	$t = $shop->login($content['shop_name'], $content['password'], Role_Shop);
	if ($t == false) {
		$result['status'] = UNAVAIL_USER;
	}
	else {
		$result['accesscode'] = $t;
		$result['status'] = STATUS_SUCCESS;
	}
	echo json_encode($result);
	exit ;
}


// Check the accesscode
if (!isset($content['accesscode'])) {
	$result['status'] = ILLIGAL_ACCESSTOKEN;
}
$shop = new shop($content['accesscode']);

switch ($content['act']) {

case "shop_static":
	$result = $shop->shop_static();
	$result['status'] = STATUS_SUCCESS;
	break;
case "shop_history":
    $p_st=isset($content['periodstart'])?$content['periodstart']:date("Y-m-d",mktime(0,0,0,date("m"),date("d")-7,date("Y")));
    $p_ed=isset($content['periodend'])?$content['periodend']:date("Y-m-d");
	$result['orders'] = $shop->shop_history($p_st, $p_ed);
	$result['status'] = STATUS_SUCCESS;
	break;
case "order_details":
	$result = $shop->order_details($content['order_id'], $content['is_detail']);
	$result['status'] = STATUS_SUCCESS;
	break;
case "shop_info":
	$result = $shop->get_shop_info();
	$result['status'] = STATUS_SUCCESS;
	break;
case "switch_good_status":
    $result['good_id'] = $content['good_id'];
	$result['good_status'] = $shop->switch_good_status($content['good_id'], $content['good_status']);
	$result['status'] = STATUS_SUCCESS;
	break;
case "switch_shop_status":
    $result['shop_status'] = $shop->switch_shop_status($content['shop_status']);
    $result['status'] = STATUS_SUCCESS;
   
    break;
case "accept_order":
	$result['confirm_status'] = $shop->accept_order($content['order_id']);
	$result['status'] = STATUS_SUCCESS;
	break;
case "cancel_order":
    $result['confirm_status'] = $shop->cancel_order($content['order_id']);
    $result['status'] = STATUS_SUCCESS;
    break;
case "get_good_menu":
    isset($content['limitstart'])?$lst=intval($content['limitstart']):$lst = 0;
    isset($content['limitend'])?$led=intval($content['limitend']):$led = 20;
	$result = $shop->shop_good_menu($lst,$led);
	$result['status'] = STATUS_SUCCESS;
	break;
case "change_password":
	if(!isset($content['old_pass'])||!isset($content['new_pass']))
	    $return['status']=NO_JSON_KEY;
	else
	{
	    if($shop->change_shop_password($content['old_pass'],$content['new_pass']))
	        $return['status'] = STATUS_SUCCESS;
	    else $return['status'] = SYS_BUSY;
	}

case 'reset_shop_pass':
    if(!isset($content['phonenumber']))
        $return['status'] = NO_JSON_KEY;
    if (! isset($content['confirmcode']))
    {
        if($ant->send_verify_code_shop($content['phonenumber']))
            $return['status'] = STATUS_SUCCESS;
        else $return['status'] = SYS_BUSY;
    }
    else
    {
        if(!$ant->reset_shop_pass($content['phonenumber'], $content['confirmcode'],$content['newpass']))
            $return['status'] = ILLIGAL_PARA;
        else
        {
            $return['status'] = STATUS_SUCCESS;
            $return['phone_number'] =$content['phonenumber'];
        }
    }
case "reg_channel":
    if(isset($content['channel_id'])&&isset($content['channel_user_id']))
    {
        if( $shop->shop_reg_channel($content['channel_id'],$content['channel_user_id']))
            $result['status'] = STATUS_SUCCESS;
        else 
            $result['status'] = SYS_BUSY;
    }
    else $result['status'] = NO_JSON_KEY;
    break;
case "feedback":
    if(isset($content['content']))
        $shop->add_feedback($content['content']);
    $return['status']=STATUS_SUCCESS;
    break;
default:
	$result['status'] = ERROR_CONTENT;
	break;
}

echo json_encode($result);
?>
