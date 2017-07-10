<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="70%">日志内容</th>
<th width="30%">发生时间</th>
</tr>
<?foreach($log[0] as $rs){
$icon= date('Y-m-d',$rs["addtime"])==date('Y-m-d',$time)? '<img src="../images/new.gif">' :'';
?><tr>
<td height="20"><?=$rs["content"]?><?=$icon?></td>
<td align="center"><?=date('Y-m-d H:i:s',$rs["addtime"])?></td>
</tr>
<?}?></table>
<table width='90%' height=2><tr ><td></td></tr></table>
<?=$log[1]?>
<?=setinput("button","button","返回上一页","onclick=\"history.go(-1)\"")?>
<?include("footer.php");?>