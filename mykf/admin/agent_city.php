<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<h3><?=$prov?>ʡ�������б�</h3>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="100">����</th>
<th width="80">����</th>
<th>��ϵ��ʽ</th>
<th width="80">�ͻ�����</th>
<th width="80">���</th>
<th width="80">���Ѷ�</th>
<th width="100">����</th>
</tr>
<?foreach($citys as $c){
if($ag=$db->record("agent","company,content,money,paymoney","prov='$prov' and city='".$c."'",1)){
  $Agent= $ag[0]['company'];
  $content= $ag[0]['content'];
  $money= $ag[0]['money'];
  $paymoney= $ag[0]['paymoney'];
}else{
  $Agent= '��';
  $content= '��';
  $money= '0';
  $paymoney= '0';
}
$count2=$db->rows("setting","infoprov='".$prov."' and infocity='".$c."'");
?>
<tr align="center">
<td height="20"><?=$c?></td>
<td><?=$Agent?></td>
<td><?=$content?></td>
<td><?=$count2?></td>
<td><?=$money?></td>
<td><?=$paymoney?></td>
<td align="center">
  <a href="admin.php?action=agent_set&type=city&prov=<?=$prov?>&city=<?=$c?>" style="color:blue">�д���</a> 
  <a href="admin.php?action=company5&prov=<?=$prov?>&city=<?=$c?>" style="color:blue">�ͻ�</a> 
</td>
</tr>
<?}?>
</table>
<?=setinput("button","button","������һҳ","onclick='history.go(-1)'")?>
<?include("footer.php");?>