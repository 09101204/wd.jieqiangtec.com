<?
if(!defined('IN_EQMK'))exit('Access Denied');
@include_once('cache.func.php');
$wid=$db->select("worker","id","companyid='$cid' order by id desc");

$city=getaddress($onlineip);
$content='竭诚为您服务';
$onlinetitle='当前客服在线';
$onlinetip='您好，有什么需要我帮助的吗？';
$offlinetitle='当前客服不在线';
$offlinetip='我现在不在线，请留下您的联系方式，如电话、QQ或Email。我上线后会马上与您联系！';
$closetip='';

$db->update("worker","city,content,onlinetitle,offlinetitle,onlinetip,offlinetip,closetip","$city|$content|$onlinetitle|$offlinetitle|$onlinetip|$offlinetip|$closetip","id=$wid");
SaveWorker($cid,$wid);
?>