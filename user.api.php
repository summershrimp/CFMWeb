<?php
define('IN_CFM','1');
require_once './includes/init.inc.php';
require_once ROOT_PATH . 'includes/user.class.php';

header('Content-Type: application/json; charset=utf-8');

$content = json_decode($GLOBALS["HTTP_RAW_POST_DATA"],true);
// 构造返回数组
$return = Array();

// 登录操作
if (! isset($content['accesscode']))
{
    if ($content['act'] == 'ant_login')
    {
        $user = new user();
        $accesscode = $user->login($content['username'], '', Role_Ant);
        if ($accesscode)
        {
            $return['accesscode'] = $accesscode;
            $return['status'] = STATUS_SUCCESS;
        }
    }
    else
        $return['status'] = ILLIGAL_ACCESSTOKEN;
    echo json_encode($return);
    exit();
}

$user = new user($content["accesscode"]);

// 验证用户手机号
if ($content['act'] == 'confirm_user_phone')
{
    if (! isset($content['confirmcode']))
        $return = $user->send_confirm($content['phonenumber']);
    else
        $return = $user->confirm_phone($content['phonenumber'], $content['confirmcode']);
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
    if ($content['getcount'] == 0)
    {
        $ans = $user->get_shop_menu($content['limitstart'], $content['limitend']);
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
    if ($content['getcount'] == 0)
    {
        $ans = $user->get_good_menu($content['limitstart'], $content['limitend']);
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
elseif ($content['act'] == 'get_address')
{
    $ans = $user->get_address();
    $return = $ans;
    $return['status'] = STATUS_SUCCESS;
}
elseif ($content['act'] == 'place_order')
{
    $order_id = $user->place_order($content['cart'], $content['address'], $content['tips']);
    $order_sn = $user->get_order_sn($order_id);
    $return['status'] = STATUS_SUCCESS;
    $return['order_id'] = $order_id;
    $return['order_sn'] = $order_sn;
}
elseif ($content['act'] == 'cancel_order')
{
    $arr = $user->cancel_order($content['order_id']);
    if ($arr)
        $return['status'] = STATUS_SUCCESS;
    else
        $return['status'] = NO_ORDER_ID;
}
elseif ($content['act'] == 'confirm_sent')
{
    $arr = $user->confirm_sent($content['order_id']);
    if ($arr)
        $return['status'] = STATUS_SUCCESS;
    else
        $return['status'] = NO_ORDER_ID;
}
elseif ($content['act'] == 'order_detail')
{
    $arr = $user->order_details($content['order_sn'], $content['is_detail']);
    $return = $arr;
    $return['status'] = STATUS_SUCCESS;
}

echo json_encode($return);
?>