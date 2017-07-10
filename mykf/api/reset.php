<?
include_once("../include/common.inc.php");
$db->update("client","workerid","","");
$db->delete("message","action='5' or action='7' or clientid='' or workerid='' or content=''");
$db->delete("dialog","");
?>
<h1>服务器初始化成功！</h1>