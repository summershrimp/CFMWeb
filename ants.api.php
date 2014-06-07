<?php
define('IN_CFM',true);
require_once './includes/init.inc.php';
require_once ROOT_PATH . 'includes/ants.class.php';

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
    if ($content['act'] == 'ant_login'&&isset($content['ant_name'])&&isset($content['password']))
    {
        $ant = new ants();
        $accesscode = $ant->login($content['ant_name'], $content['password'], Role_Ant);
        if ($accesscode)
        {
            $return['accesscode'] = $accesscode;
            $return['status'] = STATUS_SUCCESS;
        }
        else 
            $return['status'] = UNAVAIL_USER;
    }
    else
        $return['status'] = NO_TOKEN_PARA;
    echo json_encode($return);
    exit();
}//OK

$ant = new ants($content["accesscode"]);

if($content['act']=='ant_static')
{
    $return = $ant->ant_static();
    $return["status"]=STATUS_SUCCESS;
}
elseif ($content['act'] == 'ant_history')
{
    $p_st=isset($content['periodstart'])?$content['periodstart']:date("Y-m-d",mktime(0,0,0,date("m"),date("d")-7,date("Y")));
    $p_ed=isset($content['periodend'])?$content['periodend']:date("Y-m-d");
    $arr=$ant->get_history($p_st, $p_ed);
    $return['orders'] = $arr;
    $return["status"]=STATUS_SUCCESS;
}
elseif ($content['act'] == 'order_details')
{
    if(!isset($content['is_detail']))
        $content['is_detail']=false;
    $arr = $ant->order_details($content['order_id'], $content['is_detail']);
    $return = $arr;
    $return['status'] = STATUS_SUCCESS;
}
elseif($content['act']=='ant_person_info')
{
    $return = $ant->get_ant_info();
    $return['status'] = STATUS_SUCCESS;
}
elseif($content['act']=='switch_status')
{
    if(!isset($content['ant_status']))
        $return['status']=NO_JSON_KEY;
    elseif($content['ant_status']!=1&&$content['ant_status']!=0)
    {
        $return['status']=ERROR_CONTENT;
    }
    else 
    {
        $return = $ant->switch_status($content['ant_status']);
        $return ['status']=STATUS_SUCCESS; 
    }
}
elseif($content['act']=='take_order')
{
    if(!isset($content['order_id']))
        $return['status']=NO_JSON_KEY;
    else 
    {
        $return['take_status']=$ant->take_order($content['order_id']);
        $return['status']=STATUS_SUCCESS;
    }
}
elseif($content['act']=='take_goods')
{
    if(!isset($content['order_id']))
        $return['status']=NO_JSON_KEY;
    else
    {
        $return['take_status']=$ant->take_goods($content['order_id']);
        $return['status']=STATUS_SUCCESS;
    }
}
elseif($content['act']=='change_password')
{
    if(!isset($content['old_pass'])||!isset($content['new_pass']))
        $return['status']=NO_JSON_KEY;
    else
    {
        if($ant->change_ant_password($content['old_pass'],$content['new_pass']))
            $return['status'] = STATUS_SUCCESS;
        else $return['status'] = SYS_BUSY;
    }
}
elseif($content['act']=='feedback')
{
    if(isset($content['content']))
        $ant->add_feedback($content['content']);
    $return['status']=STATUS_SUCCESS;
}

elseif ($content['act'] == 'reset_ant_pass')
{
    if(!isset($content['phonenumber']))
        $return['status'] = NO_JSON_KEY;
    if (! isset($content['confirmcode']))
    {
        if($ant->send_verify_code_ant($content['phonenumber']))
            $return['status'] = STATUS_SUCCESS;
        else $return['status'] = SYS_BUSY;
    }
    else
    {
        if(!$ant->reset_ant_pass($content['phonenumber'], $content['confirmcode'],$content['newpass']))
            $return['status'] = ILLIGAL_PARA;
        else
        {
            $return['status'] = STATUS_SUCCESS;
            $return['phone_number'] =$content['phonenumber'];
        }
    }
}
elseif ($content['act'] == 'reg_channel')
{
    if(isset($content['channel_id'])&&isset($content['channel_user_id']))
    {
        if( $ant->ant_reg_channel($content['channel_id'],$content['channel_user_id']))
            $result['status'] = STATUS_SUCCESS;
        else
            $result['status'] = SYS_BUSY;
    }
    else $result['status'] = NO_JSON_KEY;
}
else
{
    $return["status"]=NO_JSON_KEY;
}
echo json_encode($return);
?>