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

require_once './modules/channel/Channel.class.php' ;

class apicommon
{
    
    public function login($username, $password, $role)
    {
        if ($role == Role_User)
            $ans = $this->check_user($username, $role);
        if ($ans)
            return $this->access_code_gen($username, $role);
        else
        {
            $user_id = check_login($username, $password, $role);
            if (! user_id)
                return false;
            return access_code_gen($user_id, $role);
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
        unset($arr[$db_id_column]);
        return $arr;
    }

    public function history($id, $role, $p_start, $p_end)
    {
        if ($role === Role_Ant)
            $db_id_column = 'ant_id';
        elseif ($role === Role_Shop)
            $db_id_column = 'shop_id';
        $sql = "Select * From " . $GLOBALS['cfm']->table("order_info") . "Where `$db_id_column` = $id ";
        if (isset($p_start) && isset($p_end))
            $limit = "And add_date Between '$p_start' And '$p_end'";
        else
            $limit = "LIMIT 20";
        $sql = $sql . $limit;
        $arr = $GLOBALS['db']->getAll($sql);
        return arr;
    }

    public function order_details($order_id, $is_detail = false)
    {
        $sql = "Select * From " . $GLOBALS['cfm']->table('order_info') . " Where `order_id` = $order_id LIMIT 1";
        $arr = $GLOBALS['db']->getRow($sql);
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
        return $arr;
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
        $sql = "Select * From " . $GLOBALS['cfm']->table('tokens') . " Where `token` = '$access_code' LIMIT 1";
        $arr = $GLOBALS['db']->getRow($sql);
        if (! isset($arr))
        {
            $arr['status'] = ILLIGAL_TOKEN;
        }
        
        else
        {
            if ($arr['gen_time'] > time() + 86400 * 2)
                $arr['status'] = TIMEOUT_ACCESS_TOKEN;
            
            unset($arr['gen_time']);
            unset($arr['token']);
        }
        return $arr;
    }

    private function access_code_gen($user_id, $role)
    {
        $access_code = $this->genToken();
        $sql = "Insert Into " . $GLOBALS['cfm']->table('tokens') . " (`token`,`id`,`role`)VALUES('$access_code',$user_id,$role)";
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

    private function check_user($username, $role)
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
        if (! isset($arr))
            return $arr[$db_id_column];
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
            $password = md5($password + $arr['salt']);
        if ($password == $arr['password'])
            return $arr[$db_id_column];
        else
            return false;
    }

    private function error_msg($str)
    {
        echo $str;
    }
}

?>