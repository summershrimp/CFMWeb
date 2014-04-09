<?php
if (! defined('IN_CFM'))
{
    die('Hacking attempt');
}

error_reporting(E_ALL);

if (__FILE__ == '')
{
    die('Fatal error code: 0');
}


/* 取得当前CarryForMe所在的根目录 */
define ( 'ROOT_PATH', str_replace ( 'includes/init.inc.php', '', str_replace ( '\\', '/', __FILE__ ) ) );

/* 初始化设置 */
@ini_set('memory_limit', '256M');
@ini_set('session.cache_expire', 180);
@ini_set('session.use_trans_sid', 0);
@ini_set('session.use_cookies', 1);
@ini_set('session.auto_start', 0);
@ini_set('display_errors', 1);

if (DIRECTORY_SEPARATOR == '\\')
{
    @ini_set('include_path', '.;' . ROOT_PATH);
}
else
{
    @ini_set('include_path', '.:' . ROOT_PATH);
}

require (ROOT_PATH . 'data/config.php');

if (defined('DEBUG_MODE') == false)
{
    define('DEBUG_MODE', 0);
}

if (PHP_VERSION >= '5.1' && ! empty($timezone))
{
    date_default_timezone_set($timezone);
}

$php_self = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
if ('/' == substr($php_self, - 1))
{
    $php_self .= 'index.php';
}
define('PHP_SELF', $php_self);

/* 对用户传入的变量进行转义操作。 */
if (! get_magic_quotes_gpc())
{
    if (! empty($_GET))
    {
        $_GET = addslashes_deep($_GET);
    }
    if (! empty($_POST))
    {
        $_POST = addslashes_deep($_POST);
    }
    
    $_COOKIE = addslashes_deep($_COOKIE);
    $_REQUEST = addslashes_deep($_REQUEST);
}

/* 创建cfm对象 */
require_once ROOT_PATH . 'include/cfm.class.php';

$cfm = new CFM($db_name, $prefix);
define('DATA_DIR', $ecs->data_dir());
define('IMAGE_DIR', $ecs->image_dir());
/* 创建db对象 */

require (ROOT_PATH . 'includes/db.class.php');
$db = new database($db_host, $db_user, $db_pass, $db_name, $prefix);
$db_host = $db_user = $db_pass = $db_name = NULL;

require_once ROOT_PATH . 'includes/defines.inc.php';
?>