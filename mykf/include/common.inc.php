<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//date_default_timezone_set (PRC);
ob_start();
ob_implicit_flush(1);
if(function_exists(session_cache_limiter))session_cache_limiter('private, must-revalidate');
session_start();
set_magic_quotes_runtime(0);

define('IN_EQMK', TRUE);
define('EQMK_ROOT', substr(dirname(__FILE__), 0, -7));

if(PHP_VERSION < '4.1.0') {
	$_GET = &$HTTP_GET_VARS;
	$_POST = &$HTTP_POST_VARS;
	$_COOKIE = &$HTTP_COOKIE_VARS;
	$_SERVER = &$HTTP_SERVER_VARS;
	$_ENV = &$HTTP_ENV_VARS;
	$_FILES = &$HTTP_POST_FILES;
}
require_once EQMK_ROOT.'./include/global.func.php';
$magic_quotes_gpc = get_magic_quotes_gpc();
$register_globals = @ini_get('register_globals');
if(!$register_globals || !$magic_quotes_gpc) {
	@extract(daddslashes($_POST));
	@extract(daddslashes($_GET));
	if(!$magic_quotes_gpc) {
		$_FILES = daddslashes($_FILES);
	}
}

require_once EQMK_ROOT.'./config.inc.php';
require_once EQMK_ROOT.'./include/config_setting.inc.php';
if($headercharset) {
  header('Content-Type: text/html; charset='.$wcharset);
}
$lang=Char_Cv('lang','get');
$default_language=$lang_web;
if(in_array($lang,array('zh-cn','zh-tw')))$lang_web=$lang;
if(!$lang_web)$lang_web='zh-cn';
@include_once EQMK_ROOT.'./language/'.$lang_web.'/web.php';
if(!$charset)$charset='gbk';
if(!$dbtype)$dbtype='mysql';
if(!$maxfilesize)$maxfilesize=2;
if(@ini_get('file_uploads')) {
  $upload_max=intval(str_replace('M','',ini_get('upload_max_filesize')));
  $maxfilesize = $upload_max>$maxfilesize ? $maxfilesize : $upload_max;
}else{
  $maxfilesize = 0;
}
require_once EQMK_ROOT.'./include/db_'.$dbtype.'.class.php';
$db=new db;
$PHP_SELF = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
$SCRIPT_FILENAME = str_replace('\\\\', '/', ($_SERVER['PATH_TRANSLATED'] ? $_SERVER['PATH_TRANSLATED'] : $_SERVER['SCRIPT_FILENAME']));

function get_real_ip()
{
$ip=false;
if(!empty($_SERVER["HTTP_CLIENT_IP"]))
{
$ip = $_SERVER["HTTP_CLIENT_IP"];
}
if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
{
$ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
if ($ip)
{
array_unshift($ips, $ip); $ip = FALSE;
}
for ($i = 0; $i < count($ips); $i++)
{
if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i]))
{
$ip = $ips[$i];
break;
}
}
}
return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}
$onlineip = get_real_ip();
$onlineip = preg_replace("/^([\d\.]+).*/", "\\1", $onlineip);
$time=time();
//$time=time()+$timezone*60*60; 服务器时间差
$now=date("Y-m-d H:i:s",$time);
?>