<?
if(!defined('IN_EQMK'))exit('Access Denied');
@include_once('cache.func.php');
$wid=$db->select("worker","id","companyid='$cid' order by id desc");

$city=getaddress($onlineip);
$content='�߳�Ϊ������';
$onlinetitle='��ǰ�ͷ�����';
$onlinetip='���ã���ʲô��Ҫ�Ұ�������';
$offlinetitle='��ǰ�ͷ�������';
$offlinetip='�����ڲ����ߣ�������������ϵ��ʽ����绰��QQ��Email�������ߺ������������ϵ��';
$closetip='';

$db->update("worker","city,content,onlinetitle,offlinetitle,onlinetip,offlinetip,closetip","$city|$content|$onlinetitle|$offlinetitle|$onlinetip|$offlinetip|$closetip","id=$wid");
SaveWorker($cid,$wid);
?>