<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="120">����ʱ��</th>
<th width="80">�������</th>
<th>����</th>
</tr>
<?foreach($money[0] as $rs){
$icon= date('Y-m-d',$rs["addtime"])==date('Y-m-d',$time)? '<img src="../images/new.gif">' :'';
?><tr>
<td height="20" align="center"><?=date('Y-m-d H:i:s',$rs["addtime"])?></td>
<td align="center"><?=$rs["money"]>0? '<font color="green">'.$rs["money"].'</font>' : '<font color="red">'.$rs["money"].'</font>'?></td>
<td><?=$rs["content"]?><?=$icon?></td>
</tr>
<?}?></table>
<table width='90%' height=2><tr ><td></td></tr></table>
<?=$money[1]?>
<?=setinput("button","button","������һҳ","onclick=\"history.go(-1)\"")?>
<?include("footer.php");?>