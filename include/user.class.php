<?php
if (! defined ( 'IN_CFM' ))
{
    die ( 'Hacking attempt' );
}

class user
{
    function user($username,$password)
    {
        $this->checkLogin($username,$password);
        
    }
}