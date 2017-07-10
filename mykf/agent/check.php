<?
include("../include/common.inc.php");
$username=$_SESSION["eqmk_agent_username"];
if($username==''){
  header("location:index.php");
  exit;
}
$rs=$db->record("agent","id,ntype,grade,company,prov,city,logincount,lasttime,thistime,lastip,thisip,lastaddress,thisaddress,style","username='$username'");
$Ntype=$rs[0]["ntype"];
$grade=$rs[0]["grade"];
$company=$rs[0]["company"];
$prov=$rs[0]["prov"];
$city=$rs[0]["city"];
$logincount=$rs[0]["logincount"];
$wid=$rs[0]["id"];
$lasttime=$rs[0]["lasttime"];
$thistime=$rs[0]["thistime"];
$lastip=$rs[0]["lastip"];
$thisip=$rs[0]["thisip"];
$lastaddress=$rs[0]["lastaddress"];
$thisaddress=$rs[0]["thisaddress"];
$adminstyle=$rs[0]["style"];
if(!$adminstyle)$adminstyle="default";

if($grade==-1){
  $thegrade=false;
}elseif($grade==1){
  $thegrade=true;
}else{
  $thegrade=$default_agenttype=='1' ? true : false;
}

include("../template/admin/$adminstyle/config.php");
unset($logo);
?>