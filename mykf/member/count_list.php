<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");?>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="8%">�ͻ����</th>
<th width="14%">����ʱ��</th>
<th width="15%">IP��ַ</th>
<th width="15%">��·</th>
<th width="15%">���ҳ��</th>
</tr>
<?foreach($count[0] as $rs){
$id=GetId($rs["id"],7);
$comeurl=$rs["comeurl"];
if(!$comeurl)$comeurl="�����������ַ";
$thispage=$rs["thispage"];
if(strlen($thispage)>30)$thispage=substr($thispage,0,30)."...";
?><tr align="center">
<td height="20"><?=$id?></td>
<td><?=date('Y-m-d H:i:s',$rs["addtime"])?></td>
<td><?=$rs["ip"]?><br>��<?=$rs["address"]?>��</td>
<td><?=$comeurl?></td>
<td title="<?=$rs["thispage"]?>"><a href="<?=$rs["thispage"]?>" target="_blank"><?=$thispage?></a></td>
</tr>
<?}?></table>
<?=$count[1]?>
<?include("footer.php");?>