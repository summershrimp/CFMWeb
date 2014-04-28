<?php
if (! defined ( 'IN_CFM' ))
{
    die ( 'Hacking attempt' );
}

require_once './common.class.php';

class ants extends apicommon
{
    private $ant_id;

    public function user($accesscode = NULL)
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
    
    public function get_history($p_start, $p_end)
    {
        return $this->history($this->ant_id, Role_Ant, $p_start, $p_end);
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
        $sql = "Select `ant_id`, `order_status` From ".$GLOBALS['cfm']->table('order_info')." Where `order_id` = $order_id  for Update";
        $arr = $GLOBALS['db']->getRow($sql);
        if(isset($arr) && $arr['order_status']==1 && !isset($arr['ant_id']))
        {
            $sql = "Update ".$GLOBALS['cfm']->table('order_info')." Set `ant_id` = $this->ant_id and `ant_time` = '".time()."' and `ant_status` = 1 ";
            $GLOBALS['db']->query($sql);
            $succ=true;
        }
        else $succ=false;
        $GLOBALS['db']->query("COMMIT");
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
    
    public function add_feedback($content)
    {
        $this->feedback($this->ant_id,Role_Ant,$content);
    }
}