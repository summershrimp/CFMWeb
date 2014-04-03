<?php
require_once './init.php';
require_once ROOT_PATH . 'include/user.class.php';

$content = json_decode($GLOBALS["HTTP_RAW_POST_DATA"]);
// 构造返回数组
$return = Array();

// 登录操作
if (! isset($content['accesscode']))
{
    if ($content['act'] == 'AntLogin')
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
if ($content['act'] == 'ConfirmUserPhone')
{
    if (! isset($content['confirmcode']))
        $return = $user->send_confirm($content['phonenumber']);
    else
        $return = $user->confirm_phone($content['phonenumber'], $content['confirmcode']);
}

//验证是否有未完成订单
elseif ($content['act'] == 'CheckUnpaid')
{
    ;
}
elseif ($content['act'] == '')
{
}
elseif ($content['act'] == '')
{
}
elseif ($content['act'] == '')
{
}
elseif ($content['act'] == '')
{
}
elseif ($content['act'] == '')
{
}
elseif ($content['act'] == '')
{
}
elseif ($content['act'] == '')
{
}
elseif ($content['act'] == '')
{
}
elseif ($content['act'] == '')
{
}
elseif ($content['act'] == '')
{
}
elseif ($content['act'] == '')
{
}
elseif ($content['act'] == '')
{
}

echo json_encode($return);
?>