<?
include("../include/common.inc.php");
$webcharset='gb2312';

$lang=Char_Cv('language','get');
if($lang){
  dsetcookie('service_language',$lang,86400*365);
}else{
  $lang=$_COOKIE['eqmk_com_service_language'];
}
if(!$lang || !file_exists('language/'.$lang.'.php'))$lang='zh-cn';
include_once('language/'.$lang.'.php');

$cid=$_SESSION["eqmk_worker_companyid"];
$username=$_SESSION["eqmk_worker_username"];
if($cid=='' || $username==''){
  if(!defined('NOTCLOSE')){
    header("location:login.php");
    exit();
  }
}

function thischarset($msg){
  return $msg;
}
$w=$db->record("worker","id,nickname","companyid='$cid' and username='$username'",1);
if(!$w)ero($language['021'],0);
$wid=$w[0]['id'];
?>