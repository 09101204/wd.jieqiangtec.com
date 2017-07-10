<?
include("../include/common.inc.php");
$cid=$_SESSION["eqmk_worker_companyid"];
$username=$_SESSION["eqmk_worker_username"];
if($cid=='' || $username==''){
  header("location:login.php?url=".urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].($_SERVER['QUERY_STRING']?'?'.$_SERVER['QUERY_STRING']:'')));
  exit;
}
$wid=$db->select("worker","id","companyid='$cid' and username='$username'");
?>