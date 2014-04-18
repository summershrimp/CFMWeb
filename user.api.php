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
            $return['status'] = STATUS_SUCCESS;
        }
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
    if ($ans)
    {
        $return['status'] = STATUS_SUCCESS;
        $return['unpaid'] = $ans;
    }
    else
    {
        $return['status'] = STATUS_SUCCESS;
        $return['unpaid'] = STATUS_SUCCESS;
    }
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
        $ans = $user->get_hot_count($content['shopid']);
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
    if(!$user->check_unpaid())
    {
        $order_id = $user->place_order($content['cart'], $content['address'], $content['tips']);
        $order_sn = $user->get_order_sn($order_id);
        $return['status'] = STATUS_SUCCESS;
        $return['order_id'] = $order_id;
        $return['order_sn'] = $order_sn;
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
elseif ($content['act'] == 'order_detail')
{
    if(!isset($content['is_detail']))
        $content['is_detail']=false;
    $arr = $user->order_details($content['order_id'], $content['is_detail']);
    $return = $arr;
    $return['status'] = STATUS_SUCCESS;
}
elseif ($content['act'] == 'get_history')
{
    if(!isset($content['user_id']))
        $content['user_id'] = 0;
    if(!isset($content['getcount']))
        $content['getcount']=1;
    $get_c=($content['getcount']==1)?true:false;
    if (!$get_c)
    {
        $l_st=isset($content['limitstart'])?intval($content['limitstart']):0;
        $l_ed=isset($content['limitend'])?intval($content['limitend']):$user->history_count($content['user_id'],Role_User);
       
        $ans = $user->get_hot_menu($l_st, $l_ed);
        $return['status'] = STATUS_SUCCESS;
        $return['goodlist'] = $ans;
    }
    else
    {
        $ans = $user->get_hot_count($content['shopid']);
        $return['status'] = STATUS_SUCCESS;
        $return['count'] = $ans;
    }
}

echo json_encode($return);
?>