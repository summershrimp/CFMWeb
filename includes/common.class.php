<?php

// //////////////////////////
// this class is wrote by Summer
// 2014-03-27
//
//
// ////////////////////////////
if (! defined('IN_CFM'))
{
    die('Hacking attempt');
}


class apicommon
{
    
    public function login($username, $password, $role)
    {
        if ($role == Role_User)
        {
            $ans = $this->check_user_exist($username, $role);
            if ($ans)
            {
                $sql="UPDATE ".$GLOBALS['cfm']->table("customers")." SET `last_ip` = '".$this->get_IP()."' Where `user_id` = '$ans' LIMIT 1";
                $GLOBALS['db']->query($sql);
                return $this->access_code_gen($ans, $role);
            }
        }
        else
        {
            $user_id = $this->check_login($username, $password, $role);
            if (! $user_id)
                return false;
            $sql="UPDATE ".$GLOBALS['cfm']->table($db_table)." SET `last_ip` = '".$this->get_IP()."' Where `$db_uname_column` = '$username' LIMIT 1";
            $GLOBALS['db']->query($sql);
            return $this->access_code_gen($user_id, $role);
        }
    }

    public function get_info($id, $role)
    {
        if ($role === Role_Shop)
        {
            $db_table = 'providers';
            $db_id_column = 'provider_id';
        }
        elseif ($role === Role_Ant)
        {
            $db_table = 'ants';
            $db_id_column = 'ant_id';
        }
        elseif ($role === Role_User)
        {
            $db_table = 'customers';
            $db_id_column = 'user_id';
        }
        $sql = "Select * From " . $GLOBALS['cfm']->table($db_table) . " Where `$db_id_column` = $id LIMIT 1";
        $arr = $GLOBALS['db']->getRow($sql);
        unset($arr['password']);
        unset($arr['salt']);
        unset($arr[$db_id_column]);
        return $arr;
    }

    public function history($id, $role, $p_start, $p_end)
    {
        if ($role === Role_Ant)
            $db_id_column = 'ant_id';
        elseif ($role === Role_Shop)
            $db_id_column = 'shop_id';
        elseif ($role === Role_User)
            $db_id_column = 'user_id';
        $sql = "Select `order_id`, `order_sn`, `goods_amount`,`tips_amount`,`order_time`,`user_realname` From " . $GLOBALS['cfm']->table("order_info") . "Where `$db_id_column` = $id ";
        if (isset($p_start) && isset($p_end))
            $limit = "And add_date Between '$p_start' And '$p_end'";
        else
            $limit = "LIMIT 20";
        $sql = $sql . $limit;
        $arr = $GLOBALS['db']->getAll($sql);
        return $arr;
    }
    
    public function history_count($id, $role)
    {
        if ($role === Role_Ant)
            $db_id_column = 'ant_id';
        elseif ($role === Role_Shop)
            $db_id_column = 'shop_id';
        elseif ($role === Role_User)
            $db_id_column = 'user_id';
        $sql = "Select Count(*) From " . $GLOBALS['cfm']->table("order_info") . "Where `$db_id_column` = $id ";
        $arr = $GLOBALS['db']->getOne($sql);

        return arr;
    }

    public function order_details($order_id, $is_detail = false)
    {
        $sql = "Select * From " . $GLOBALS['cfm']->table('order_info') . " Where `order_id` = $order_id LIMIT 1";
        $arr = $GLOBALS['db']->getRow($sql);

        if (! $GLOBALS['db']->affected_rows())
            return false;

        $return = $arr;
        if ($is_detail)
        {
            $sql = "Select * From " . $GLOBALS['cfm']->table('order_details') . " Where `order_id` = $order_id";
            $arr = $GLOBALS['db']->getAll($sql);
            $return['goods'] = $arr;
        }
        return $return;
    }

    public function get_good_menu($shop_id, $limit_start = 0, $limit_end = 20)
    {
        $sql = "Select * From " . $GLOBALS['cfm']->table('shop_goods') . " Where `shop_id` = '$shop_id' LIMIT $limit_start , $limit_end";
        $arr = $GLOBALS['db']->getAll($sql);
        return $arr;
    }

    public function get_good_count($shop_id)
    {
        $sql = "Select Count(*) From " . $GLOBALS['cfm']->table('shop_goods') . " Where `shop_id` = '$shop_id' ";
        $arr = $GLOBALS['db']->getOne($sql);
        return intval($arr);
    }

    public function get_order_sn($order_id)
    {
        $sql = "Select `order_sn` From " . $GLOBALS['cfm']->table('order_info') . " Where `order_id` = $order_id";
        $arr = $GLOBALS['db']->getOne($sql);
        return $arr;
    }

    public function get_order_id($order_sn)
    {
        $sql = "Select `order_id` From " . $GLOBALS['cfm']->table('order_info') . " Where `order_sn` = '$order_sn'";
        $arr = $GLOBALS['db']->getOne($sql);
        return $arr;
    }

    public function check_access_code($token)
    {
        $sql = "Select * From " . $GLOBALS['cfm']->table('tokens') . " Where `token` = '$token' LIMIT 1";
        $arr = $GLOBALS['db']->getRow($sql);
        if (! isset($arr))
        {
            $arr['status'] = ILLIGAL_TOKEN;
        }
        else
        {
            $arr['status'] = STATUS_SUCCESS;
            if ($arr['gen_time'] > time() + 86400 * 2)
                $arr['status'] = TIMEOUT_ACCESS_TOKEN;
            unset($arr['gen_time']);
            unset($arr['token']);
        }
        return $arr;
    }
    
    private function feedback($id, $role, $content)
    {
        $sql = "Insert INTO ".$GLOBALS['cfm']->table("feedback")." (`id`,`role`,`content`,) VALUES ('$id', '$role', '$content') ";
        $GLOBALS['db']->query($sql);
        return true;
    }


    private function access_code_gen($user_id, $role)
    {
        $sql = "DELETE From " . $GLOBALS['cfm']->table('tokens') . "Where `id`='$user_id' AND `role`='$role' LIMIT 1";
        $GLOBALS['db']->query($sql);
        $access_code = $this->genToken();

        $sql = "Insert Into " . $GLOBALS['cfm']->table('tokens') . " (`token`,`id`, `role`, `gen_time`)VALUES('$access_code', '$user_id', '$role', '".time()."')";
		
        $GLOBALS['db']->query($sql);
        return $access_code;
    }

    private function genToken($len = 32, $md5 = true)
    {
        // Seed random number generator
        // Only needed for PHP versions prior to 4.2
        mt_srand((double) microtime() * 1000000);
        // Array of characters, adjust as desired
        $chars = array('Q','@','8','y','%','^','5','Z','(','G','_','O','`','S','-','N','<','D','{','}','[',']','h',';','W','.','/','|',':','1','E','L','4','&','6','7','#','9','a','A','b','B','~','C','d','>','e','2','f','P','g',')','?','H','i','X','U','J','k','r','l','3','t','M','n','=','o','+','p','F','q','!','K','R','s','c','m','T','v','j','u','V','w',',','x','I','$','Y','z','*'
        );
        // Array indice friendly number of chars;
        $numChars = count($chars) - 1;
        $token = '';
        // Create random token at the specified length
        for ($i = 0; $i < $len; $i ++)
            $token .= $chars[mt_rand(0, $numChars)];
            // Should token be run through md5?
        if ($md5)
        {
            // Number of 32 char chunks
            $chunks = ceil(strlen($token) / 32);
            $md5token = '';
            // Run each chunk through md5
            for ($i = 1; $i <= $chunks; $i ++)
                $md5token .= md5(substr($token, $i * 32 - 32, 32));
                // Trim the token
            $token = substr($md5token, 0, $len);
        }
        return $token;
    }

    private function check_user_exist($username, $role)
    {
        if ($role === Role_Shop)
        {
            $db_table = 'providers';
            $db_uname_column = 'provider_name';
            $db_id_column = 'provider_id';
        }
        elseif ($role === Role_Ant)
        {
            $db_table = 'ants';
            $db_uname_column = 'ant_name';
            $db_id_column = 'ant_id';
        }
        elseif ($role === Role_User)
        {
            $db_table = 'customers';
            $db_uname_column = 'openid';
            $db_id_column = 'user_id';
        }
        $sql = "Select `$db_id_column`  From " . $GLOBALS['cfm']->table($db_table) . " Where `$db_uname_column` = '$username' LIMIT 1";
        $arr = $GLOBALS['db']->getRow($sql);
        if (isset($arr[$db_id_column]))
           return $arr[$db_id_column];
        elseif($role == Role_User)
        {
            $sql="INSERT Into ".$GLOBALS['cfm']->table("customers")." (`last_ip`,`is_validated`,`openid`) VALUES ('".$this->get_IP()."','0','$username') "; 
            $GLOBALS['db']->query($sql);
            return $GLOBALS['db']->insert_id();
        }
        return false;
    }

    private function check_login($username, $password, $role)
    {
        if ($role === Role_Shop)
        {
            $db_table = 'providers';
            $db_uname_column = 'provider_name';
            $db_id_column = 'provider_id';
        }
        elseif ($role === Role_Ant)
        {
            $db_table = 'ants';
            $db_uname_column = 'ant_name';
            $db_id_column = 'ant_id';
        }
        elseif ($role === Role_User)
        {
            $db_table = 'customers    ';
            $db_uname_column = 'openid';
            $db_id_column = 'user_id';
        }
        $sql = "Select `password` ,`salt`, `$db_id_column` From " . $GLOBALS['cfm']->table($db_table) . " Where  `$db_uname_column`  = '$username' LIMIT 1";
        $arr = $GLOBALS['db']->getRow($sql);
        if (! isset($arr))
            return false;
        if (isset($arr['salt']))
            $password = md5($password . $arr['salt']);
        if ($password == $arr['password'])
        {
            $sql="UPDATE ".$GLOBALS['cfm']->table($db_table)." SET `last_ip` = '".$this->get_IP()."' Where `$db_uname_column` = '$username' LIMIT 1";
            $GLOBALS['db']->query($sql);
            return $arr[$db_id_column];
        }
        else
            return false;
    }
    private function get_IP() 
    { 
        if (@$_SERVER["HTTP_X_FORWARDED_FOR"]) 
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"]; 
        else if (@$_SERVER["HTTP_CLIENT_IP"]) 
            $ip = $_SERVER["HTTP_CLIENT_IP"]; 
        else if (@$_SERVER["REMOTE_ADDR"]) 
            $ip = $_SERVER["REMOTE_ADDR"]; 
        else if (@getenv("HTTP_X_FORWARDED_FOR"))
            $ip = getenv("HTTP_X_FORWARDED_FOR"); 
        else if (@getenv("HTTP_CLIENT_IP")) 
            $ip = getenv("HTTP_CLIENT_IP"); 
        else if (@getenv("REMOTE_ADDR")) 
            $ip = getenv("REMOTE_ADDR"); 
        else 
            $ip = "Unknown"; 
        return $ip; 
    }
    private function error_msg($str)
    {
        echo $str;
    }
}

?>
