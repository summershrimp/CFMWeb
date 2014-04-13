<?php
if (! defined ( 'IN_CFM' ))
{
    die ( 'Hacking attempt' );
}
class database
{
    private $con = NULL;
    public $prefix;
    private $db_config = Array ();
    function database ($db_host, $db_name, $db_user, $db_pass, $prefix)
    {
        $this -> db_config = array (
                "db_host" => $db_host,
                "db_name" => $db_name,
                "db_user" => $db_user,
                "db_pass" => $db_pass,
                "prefix" => $prefix 
        );
        $this->connect ( $this -> db_config );
    }
    function connect ($config)
    {  
        
        $this -> con = mysql_connect ( $config ['db_host'], $config ['db_user'], $config ['db_pass'] );
        if (! $this -> con)
            die ( "Cannot Connect To mysql" );
        mysql_select_db ( $config ['db_name'], $this -> con );
        mysql_query ( "SET NAMES 'utf8'" );
        $this -> prefix = $config ['prefix'];
        $this -> db_config = Array ();
    }
    function query ($sql)
    {
        $result = @mysql_query ( $sql, $this -> con );
        if (! $result)
            return false;
        return $result;
    }
    function affected_rows ( )
    {
        return mysql_affected_rows ( $this -> con );
    }
    function error ( )
    {
        return mysql_error ( $this -> con );
    }
    function errno ( )
    {
        return mysql_errno ( $this -> con );
    }
    function result ($query, $row)
    {
        return @mysql_result ( $query, $row );
    }
    function num_rows ($query)
    {
        return mysql_num_rows ( $query );
    }
    function num_fields ($query)
    {
        return mysql_num_fields ( $query );
    }
    function free_result ($query)
    {
        return mysql_free_result ( $query );
    }
    function insert_id ( )
    {
        return mysql_insert_id ( $this -> con );
    }
    function fetchRow ($query)
    {
        return mysql_fetch_assoc ( $query );
    }
    function fetch_fields ($query)
    {
        return mysql_fetch_field ( $query );
    }
    function version ( )
    {
        return $this -> version;
    }
    function ping ( )
    {
        if (PHP_VERSION >= '4.3')
        {
            return mysql_ping ( $this -> con );
        }
        else
        {
            return false;
        }
    }
    function escape_string ($unescaped_string)
    {
        if (PHP_VERSION >= '4.3')
        {
            return mysql_real_escape_string ( $unescaped_string );
        }
        else
        {
            return mysql_escape_string ( $unescaped_string );
        }
    }
    function close ( )
    {
        return mysql_close ( $this -> con );
    }
    function selectLimit ($sql, $num, $start = 0)
    {
        if ($start == 0)
        {
            $sql .= ' LIMIT ' . $num;
        }
        else
        {
            $sql .= ' LIMIT ' . $start . ', ' . $num;
        }
        
        return $this->query ( $sql );
    }
    function getOne ($sql, $limited = false)
    {
        if ($limited == true)
        {
            $sql = trim ( $sql . ' LIMIT 1' );
        }
        
        $res = $this->query ( $sql );
        if ($res !== false)
        {
            $row = mysql_fetch_row ( $res );
            
            if ($row !== false)
            {
                return $row [0];
            }
            else
            {
                return '';
            }
        }
        else
        {
            return false;
        }
    }
    function getAll ($sql)
    {
        $res = $this->query ( $sql );
        if ($res !== false)
        {
            $arr = array ();
            while ( $row = mysql_fetch_assoc ( $res ) )
            {
                $arr [] = $row;
            }
            
            return $arr;
        }
        else
        {
            return false;
        }
    }
    function getRow ($sql, $limited = false)
    {
        if ($limited == true)
        {
            $sql = trim ( $sql . ' LIMIT 1' );
        }
        
        $res = $this->query ( $sql );
        if ($res !== false)
        {
            return mysql_fetch_assoc ( $res );
        }
        else
        {
            return false;
        }
    }
    function getCol ($sql)
    {
        $res = $this->query ( $sql );
        if ($res !== false)
        {
            $arr = array ();
            while ( $row = mysql_fetch_row ( $res ) )
            {
                $arr [] = $row [0];
            }
            
            return $arr;
        }
        else
        {
            return false;
        }
    }
    function autoExecute ($table, $field_values, $mode = 'INSERT', $where = '', $querymode = '')
    {
        $field_names = $this->getCol ( 'DESC ' . $table );
        
        $sql = '';
        if ($mode == 'INSERT')
        {
            $fields = $values = array ();
            foreach ( $field_names as $value )
            {
                if (array_key_exists ( $value, $field_values ) == true)
                {
                    $fields [] = $value;
                    $values [] = "'" . $field_values [$value] . "'";
                }
            }
            
            if (! empty ( $fields ))
            {
                $sql = 'INSERT INTO ' . $table . ' (' . implode ( ', ', $fields ) . ') VALUES (' . implode ( ', ', $values ) . ')';
            }
        }
        else
        {
            $sets = array ();
            foreach ( $field_names as $value )
            {
                if (array_key_exists ( $value, $field_values ) == true)
                {
                    $sets [] = $value . " = '" . $field_values [$value] . "'";
                }
            }
            
            if (! empty ( $sets ))
            {
                $sql = 'UPDATE ' . $table . ' SET ' . implode ( ', ', $sets ) . ' WHERE ' . $where;
            }
        }
        
        if ($sql)
        {
            return $this->query ( $sql, $querymode );
        }
        else
        {
            return false;
        }
    }
    function autoReplace ($table, $field_values, $update_values, $where = '', $querymode = '')
    {
        $field_descs = $this->getAll ( 'DESC ' . $table );
        
        $primary_keys = array ();
        foreach ( $field_descs as $value )
        {
            $field_names [] = $value ['Field'];
            if ($value ['Key'] == 'PRI')
            {
                $primary_keys [] = $value ['Field'];
            }
        }
        
        $fields = $values = array ();
        foreach ( $field_names as $value )
        {
            if (array_key_exists ( $value, $field_values ) == true)
            {
                $fields [] = $value;
                $values [] = "'" . $field_values [$value] . "'";
            }
        }
        
        $sets = array ();
        foreach ( $update_values as $key => $value )
        {
            if (array_key_exists ( $key, $field_values ) == true)
            {
                if (is_int ( $value ) || is_float ( $value ))
                {
                    $sets [] = $key . ' = ' . $key . ' + ' . $value;
                }
                else
                {
                    $sets [] = $key . " = '" . $value . "'";
                }
            }
        }
        
        $sql = '';
        if (empty ( $primary_keys ))
        {
            if (! empty ( $fields ))
            {
                $sql = 'INSERT INTO ' . $table . ' (' . implode ( ', ', $fields ) . ') VALUES (' . implode ( ', ', $values ) . ')';
            }
        }
        else
        {
            if ($this->version ( ) >= '4.1')
            {
                if (! empty ( $fields ))
                {
                    $sql = 'INSERT INTO ' . $table . ' (' . implode ( ', ', $fields ) . ') VALUES (' . implode ( ', ', $values ) . ')';
                    if (! empty ( $sets ))
                    {
                        $sql .= 'ON DUPLICATE KEY UPDATE ' . implode ( ', ', $sets );
                    }
                }
            }
            else
            {
                if (empty ( $where ))
                {
                    $where = array ();
                    foreach ( $primary_keys as $value )
                    {
                        if (is_numeric ( $value ))
                        {
                            $where [] = $value . ' = ' . $field_values [$value];
                        }
                        else
                        {
                            $where [] = $value . " = '" . $field_values [$value] . "'";
                        }
                    }
                    $where = implode ( ' AND ', $where );
                }
                
                if ($where && (! empty ( $sets ) || ! empty ( $fields )))
                {
                    if (intval ( $this->getOne ( "SELECT COUNT(*) FROM $table WHERE $where" ) ) > 0)
                    {
                        if (! empty ( $sets ))
                        {
                            $sql = 'UPDATE ' . $table . ' SET ' . implode ( ', ', $sets ) . ' WHERE ' . $where;
                        }
                    }
                    else
                    {
                        if (! empty ( $fields ))
                        {
                            $sql = 'REPLACE INTO ' . $table . ' (' . implode ( ', ', $fields ) . ') VALUES (' . implode ( ', ', $values ) . ')';
                        }
                    }
                }
            }
        }
        
        if ($sql)
        {
            return $this->query ( $sql, $querymode );
        }
        else
        {
            return false;
        }
    }
    function get_table_name ($query_item)
    {
        $query_item = trim ( $query_item );
        $table_names = array ();
        
        /* 判断语句中是不是含有 JOIN */
        if (stristr ( $query_item, ' JOIN ' ) == '')
        {
            /* 解析一般的 SELECT FROM 语句 */
            if (preg_match ( '/^SELECT.*?FROM\s*((?:`?\w+`?\s*\.\s*)?`?\w+`?(?:(?:\s*AS)?\s*`?\w+`?)?(?:\s*,\s*(?:`?\w+`?\s*\.\s*)?`?\w+`?(?:(?:\s*AS)?\s*`?\w+`?)?)*)/is', $query_item, $table_names ))
            {
                $table_names = preg_replace ( '/((?:`?\w+`?\s*\.\s*)?`?\w+`?)[^,]*/', '\1', $table_names [1] );
                
                return preg_split ( '/\s*,\s*/', $table_names );
            }
        }
        else
        {
            /* 对含有 JOIN 的语句进行解析 */
            if (preg_match ( '/^SELECT.*?FROM\s*((?:`?\w+`?\s*\.\s*)?`?\w+`?)(?:(?:\s*AS)?\s*`?\w+`?)?.*?JOIN.*$/is', $query_item, $table_names ))
            {
                $other_table_names = array ();
                preg_match_all ( '/JOIN\s*((?:`?\w+`?\s*\.\s*)?`?\w+`?)\s*/i', $query_item, $other_table_names );
                
                return array_merge ( array (
                        $table_names [1] 
                ), $other_table_names [1] );
            }
        }
        
        return $table_names;
    }
}

?>
