<?php
if (! defined('IN_CFM')) {
    die('Hacking attempt');
}

class apicommon
{

    public function login($username, $password, $role)
    {
        if ($role == Role_User) $ans = $this -> check_user($username, $role);
        if ($ans)
            return $this -> access_code_gen($username, $role);
        else {
        }
    }

    private function access_code_gen($username, $role)
    {
    }

    private function check_user($username, $role)
    {
        if ($role === Role_Shop) {
            $db_table = 'providers';
            $db_uname_column = 'provider_name';
            $db_id_column = 'provider_id';
        }
        elseif ($role === Role_Ant) {
            $db_table = 'ants';
            $db_uname_column = 'ant_name';
            $db_id_column = 'ant_id';
        }
        elseif ($role === Role_User) {
            $db_table = 'customers    ';
            $db_uname_column = 'openid';
            $db_id_column = 'user_id';
        }
        $sql = "Select `$db_uname_column`  From " . $GLOBALS['cfm'] -> table($db_table) . " Where `$db_uname_column` = '$username' LIMIT 1";
        $arr = $GLOBALS['db'] -> getRow($sql);
        if (! isset($arr)) return $arr["$db_id_column"];
        return false;
    }

    private function check_login($username, $password, $role)
    {
        if ($role === Role_Shop) {
            $db_table = 'providers';
            $db_uname_column = 'provider_name';
            $db_id_column = 'provider_id';
        }
        elseif ($role === Role_Ant) {
            $db_table = 'ants';
            $db_uname_column = 'ant_name';
            $db_id_column = 'ant_id';
        }
        elseif ($role === Role_User) {
            $db_table = 'customers    ';
            $db_uname_column = 'openid';
            $db_id_column = 'user_id';
        }
        $sql = "Select `password` ,`salt`, `$db_id_column` From " . $GLOBALS['cfm'] -> table($db_table) . " Where  `$db_uname_column`  = '$username' LIMIT 1";
        $arr = $GLOBALS['db'] -> getRow($sql);
        if (! isset($arr)) return false;
        if (isset($arr['salt'])) $password = md5($password + $arr['salt']);
        if ($password == $arr['password'])
            return true;
        else return false;
    }
}

?>