<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");?>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="8%">客户编号</th>
<th width="14%">访问时间</th>
<th width="15%">IP地址</th>
<th width="15%">来路</th>
<th width="15%">最后页面</th>
</tr>
<?foreach($count[0] as $rs){
$id=GetId($rs["id"],7);
$comeurl=$rs["comeurl"];
if(!$comeurl)$comeurl="自行输入的网址";
$thispage=$rs["thispage"];
if(strlen($thispage)>30)$thispage=substr($thispage,0,30)."...";
?><tr align="center">
<td height="20"><?=$id?></td>
<td><?=date('Y-m-d H:i:s',$rs["addtime"])?></td>
<td><?=$rs["ip"]?><br>（<?=$rs["address"]?>）</td>
<td><?=$comeurl?></td>
<td title="<?=$rs["thispage"]?>"><a href="<?=$rs["thispage"]?>" target="_blank"><?=$thispage?></a></td>
</tr>
<?}?></table>
<?=$count[1]?>
<?include("footer.php");?>