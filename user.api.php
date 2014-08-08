<?php
define('IN_CFM',true);
require_once './includes/init.inc.php';
require_once ROOT_PATH . 'includes/user.class.php';

header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type ");

if(!isset($GLOBALS["HTTP_RAW_POST_DATA"]))
{
    $return ['status'] = ERROR_CONTENT;
    echo json_encode($return);
    exit();
}

$content = json_decode($GLOBALS["HTTP_RAW_POST_DATA"],true);

$content = addslashes_deep($content);

// 构造返回数组
$return = Array();

// 登录操作
if (! isset($content['accesscode']))
{
    if ($content['act'] == 'user_login'&&isset($content['openid']))
    {
        $user = new user();
        $accesscode = $user->login($content['openid'], '', Role_User);
        if ($accesscode)
        {
            $return['accesscode'] = $accesscode;
            $user = new user($accesscode);
            $return['isverify'] = $user->check_verify();//TODO:返回手机号状态
            $return['status'] = STATUS_SUCCESS;
        }
        else $return['status'] = UNAVAIL_USER;
    }
    elseif(!isset($content['openid']))
        $return['status'] = NO_JSON_KEY;
    else
        $return['status'] = NO_TOKEN_PARA;
    echo json_encode($return);
    exit();
}//OK

$user = new user($content["accesscode"]);

// 验证用户手机号
if ($content['act'] == 'confirm_user_phone')
{
    if(!isset($content['phonenumber']))
        $return['status'] = NO_JSON_KEY;
    if (! isset($content['confirmcode']))
    {
        if($user->send_confirm($content['phonenumber']))
            $return['status'] = STATUS_SUCCESS;
        else $return['status'] = SYS_BUSY; 
    }
    else
    {
        if( !$user->confirm_phone($content['phonenumber'], $content['confirmcode']))
            $return['status'] = ILLEGAL_TICKET;
        else
        {
            $return['status'] = STATUS_SUCCESS;
            $return['phone_number'] =$content['phonenumber']; 
        } 
    }
}

// 验证是否有未完成订单
elseif ($content['act'] == 'check_unpaid')
{
    $ans = $user->check_unpaid();
    $return['status'] = STATUS_SUCCESS;
    $return['unpaid'] = $ans;
   
}
elseif ($content['act'] == 'get_shop_menu')
{
    if(!isset($content['getcount']))
        $content['getcount']=1;
    $get_c=($content['getcount']==1)?true:false;
    
    if (!$get_c)
    {
        $l_st=isset($content['limitstart'])?intval($content['limitstart']):0;
        $l_ed=isset($content['limitend'])?intval($content['limitend']):$user->get_shop_count();
        
        $ans = $user->get_shop_menu($l_st, $l_ed);
        $return['status'] = STATUS_SUCCESS;
        $return['shoplist'] = $ans;
    }
    else
    {
        $ans = $user->get_shop_count();
        $return['status'] = STATUS_SUCCESS;
        $return['count'] = $ans;
    }
}
elseif ($content['act'] == 'get_good_menu')
{
    if(!isset($content['getcount']))
        $content['getcount']=1;
    $get_c=($content['getcount']==1)?true:false;
    
    
    if (!$get_c)
    {   
        $l_st=isset($content['limitstart'])?intval($content['limitstart']):0;
        $l_ed=isset($content['limitend'])?intval($content['limitend']):$user->get_good_count($content['shop_id']);
        
        $ans = $user->get_good_menu($content['shop_id'],$l_st, $l_ed);
        $return['status'] = STATUS_SUCCESS;
        $return['goodlist'] = $ans;
    }
    else
    {   
        $ans = $user->get_good_count($content['shop_id']);
        $return['status'] = STATUS_SUCCESS;
        $return['count'] = $ans;
    }
}
elseif ($content['act'] == 'get_hot_menu')
{
    if(!isset($content['getcount']))
        $content['getcount']=1;
    $get_c=($content['getcount']==1)?true:false;
    if (!$get_c)
    {
        $l_st=isset($content['limitstart'])?intval($content['limitstart']):0;
        $l_ed=isset($content['limitend'])?intval($content['limitend']):$user->get_hot_count();
        
        $ans = $user->get_hot_menu($l_st, $l_ed);
        $return['status'] = STATUS_SUCCESS;
        $return['goodlist'] = $ans;
    }
    else
    {
        $ans = $user->get_hot_count();
        $return['status'] = STATUS_SUCCESS;
        $return['count'] = $ans;
    }
}
elseif ($content['act'] == 'get_address')
{
    $ans = $user->get_address();
    $return = $ans;
    $return['status'] = STATUS_SUCCESS;
}
elseif ($content['act'] == 'place_order')
{
    if(!$user->check_unpaid($content['nonce']))
    {
        $order_id = $user->place_order($content['cart'], $content['address'], $content['tips'],$content['nonce']);
        $order_sn = $user->get_order_sn($order_id);
        $return['status'] = STATUS_SUCCESS;
        $return['order_id'] = $order_id;
        $return['order_sn'] = $order_sn;
        $return['nonce'] = $content['nonce'];
    }
    else 
        $return['status'] = UNAVAIL_NEW_ORDER;
}
elseif ($content['act'] == 'cancel_order')
{
    if(!isset($content['order_id']))
        $return['status']=NO_JSON_KEY;
    else 
    {
        $arr = $user->cancel_order($content['order_id']);
        if ($arr)
            $return['status'] = STATUS_SUCCESS;
        else
            $return['status'] = ORDER_ERROR;
    }
}
elseif ($content['act'] == 'confirm_sent')
{
    if(!isset($content['order_id']))
        $return['status']=NO_JSON_KEY;
    else
    {
        $arr = $user->confirm_sent($content['order_id']);
        if ($arr)
            $return['status'] = STATUS_SUCCESS;
        else
            $return['status'] = NO_ORDER_ID;
    }
}
elseif ($content['act'] == 'order_details')
{
    if(!isset($content['is_detail']))
        $content['is_detail']=false;
    $arr = $user->get_order_details($content['order_id'], $content['is_detail']);
    $return = $arr;
    $return['status'] = STATUS_SUCCESS;
}
elseif ($content['act'] == 'check_status')
{
	if(!isset($content['order_id']))
		$return['status'] = ERROR_CONTENT;
	else
	{
		$arr = $user->check_status($content['order_id']);
		$return = $arr;
		$return['status'] = STATUS_SUCCESS;
	}
}
elseif ($content['act'] == 'get_history')
{
    $p_st=isset($content['periodstart'])?$content['periodstart']:date("Y-m-d",mktime(0,0,0,date("m"),date("d")-7,date("Y")));
    $p_ed=isset($content['periodend'])?$content['periodend']:date("Y-m-d");
    $arr=$user->get_history($p_st, $p_ed);
    $return['orders'] = $arr;
    $return["status"]=STATUS_SUCCESS;
}
elseif($content['act']=='feedback')
{
    if(isset($content['content']))
        $ant->add_feedback($content['content']);
    $return['status']=STATUS_SUCCESS;
}

else 
{
    $return["status"]=NO_JSON_KEY;
}

echo json_encode($return);
?>