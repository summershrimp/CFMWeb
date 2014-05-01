<?php
if (! defined ( 'IN_CFM' ))
{
    die ( 'Hacking attempt' );
}

require_once ROOT_PATH . 'includes/common.class.php';

class ants extends apicommon
{
    private $ant_id;

    public function ants($accesscode = NULL)
    {
        if ($accesscode!=NULL)
        {
            $ans = $this->check_access_code($accesscode);
            if ($ans['status'] == STATUS_SUCCESS)
                $this->ant_id = intval($ans['id']);
            else die(json_encode($ans));
        }
    }
    
    public function ant_static()
    {
        $end=date("Y-m-d");
        $start = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-7,date("Y")));
        $sql="Select Count(*) as total ,Sum(tips_amount) as amount From".$GLOBALS['cfm']->table('order_info').
             " Where `ant_id` = '$this->ant_id' And `add_date` Between '$start' And '$end' ";
        $arr = $GLOBALS['db']->getRow($sql);
        $return["week_count"] = $arr['total'];
        $return["week_tips"] = $arr['amount'];
        
        $end=date("Y-m-d");
        $sql="Select Count(*) as total ,Sum(tips_amount) as amount From".$GLOBALS['cfm']->table('order_info').
             " Where `ant_id` = '$this->ant_id' And `add_date` = '$end' ";
        $arr = $GLOBALS['db']->getRow($sql);
        $return["day_count"] = $arr['total'];
        $return["day_tips"] = $arr['amount'];
        
        $end=date("Y-m-d");
        $start = date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y")));
        $sql="Select Count(*) as total ,Sum(tips_amount) as amount From".$GLOBALS['cfm']->table('order_info').
             " Where `ant_id` = '$this->ant_id' And `add_date` Between '$start' And '$end' ";
        $arr = $GLOBALS['db']->getRow($sql);
        $return["month_count"] = $arr['total'];
        $return["month_tips"] = $arr['amount'];
        
        return $return;
    }
    
    public function get_ant_info()
    {
        $sql = "Select `email`, `sex`, `ant_name`, `ant_real_name`, `sex`, `last_time`, `last_ip`, `mobile_phone`,`pic_url`  From "
               .$GLOBALS['cfm']->table('ants')." Where `ant_id` = $this->ant_id LIMIT 1";    
        return $GLOBALS['db']->getRow($sql); 
    }
    
    public function switch_status($status)
    {
        $sql = "Update ".$GLOBALS['cfm']->table('ant')." Set `ant_online` = $status";
        $GLOBALS['db']->query($sql);
    }
    
    public function take_order($order_id)
    {
        $GLOBALS['db']->query("START TRANSACTION");
        $sql = "Select `ant_id`, `order_status` , `ant_status` From ".$GLOBALS['cfm']->table('order_info')." Where `order_id` = $order_id  for Update";
        $arr = $GLOBALS['db']->getRow($sql);
        if(isset($arr) && $arr['order_status'] == 1 && $arr['ant_status'] == 0 && !isset($arr['ant_id']))
        {
            $sql = "Update ".$GLOBALS['cfm']->table('order_info')." Set `ant_id` = $this->ant_id and `ant_time` = '".time()."' and `ant_status` = 1 ";
            $GLOBALS['db']->query($sql);
            $succ=true;
        }
        else $succ=false;
        $GLOBALS['db']->query("COMMIT");
        if($succ)
        {
            $sql = "Select `isopen` From ".$GLOBALS['cfm']-table('shop')." LEFT JOIN ".
                    $GLOBALS['cfm']-table('order_details')." ON ".
                    $GLOBALS['cfm']-table('shop').".`shop_id` = ".$GLOBALS['cfm']-table('order_details')." `shop_id` Where ".
                    $GLOBALS['cfm']-table('order_details')." `order_id` = $order_id ";
            $result = $GLOBALS['db']->query($sql);
            while($arr = $GLOBALS['db']->fetch_array($result))
            {
                if($arr['isopen'] == 0)
                    $succ = false;
            }
        
            if($succ)
            {
                $sql = "Select `good_id` From ".$GLOBALS['cfm']-table('order_details')." Where `order_id` = $order_id";
                $result = $GLOBALS['db']->query($sql);
                while($arr = $GLOBALS['db']->fetch_array($result))
                {
                    $sql2 = "Select `unavail` From ".$GLOBALS['cfm']->table('shop_goods')." Where `good_id` = '".$arr['good_id']."' LIMIT 1";
                    $unavail = $GLOBALS['db']->getOne($sql2);
                    if($unavail == 1)
                        $succ = false;
                }
            }
            
            if(!$succ)
            {
                $sql3 = "Update ".$GLOBALS['cfm']->table('order_info')." SET `order_status` = 0 , `ant_status` = 0 , `ant_id` = NULL Where `order_id` = $order_id AND `order_status` = 1 AND `ant_status` = 1 LIMIT 1";
                $GLOBALS['db']->query($sql3);
                $succ=false;
            }
            else
            {
                $sql = "Select `shop_id` From ".$GLOBALS['cfm']->table('order_details')." Where `order_id` = $order_id GROUP BY `shop_id` ";
                $result = $GLOBALS['db']->query($sql);
                while($arr = $GLOBALS['db']->fetch_array($result))
                    $this->push_to_shop($shop_id, $order_id);
            }
        }
        return $succ;
    }
    
    public function take_goods($order_id)
    {
        $sql = "update ".$GLOBALS['cfm']->table('order_info')." Set `taking_status` = 1 Where `order_id` = '$order_id' AND `ant_id` = '$this->ant_id' AND `order_status` = 1 AND `ant_status` = 1";
        $GLOBALS['db']->query($sql);
        if($GLOBALS['db']->affected_rows()<1)
            return false;
        return true;
    }
    
    public function get_history($p_start, $p_end)
    {
        return $this->history($this->ant_id, Role_Ant, $p_start, $p_end);
    }
    public function change_ant_pass($old_pass,$new_pass)
    {
        return $this->change_password($this->id, $old_pass, $new_pass, Role_Ant);
    }
    public function send_verify_code_ant($phone)
    {
        $this->send_verify_code(Role_Ant,$phone);
    }
    public function reset_ant_pass($phone,$verify_code,$new_pass)
    {
        $this->reset_password($phone,$verify_code,$new_pass);
    }
    public function add_feedback($content)
    {
        $this->feedback($this->ant_id,Role_Ant,$content);
    }
}