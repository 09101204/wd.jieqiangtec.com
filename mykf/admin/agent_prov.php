<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<Object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="480" height="407">
<Param Name=quality Value='high'/>
<Param Name=wmode Value='transparent'/>
<Param Name=movie Value='../images/admincp/chinamap.swf'/>
<param name='FlashVars' value='<?=$vars?>'></Object>
<br /><br />
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="100">ʡ��</th>
<th width="80">����</th>
<th>��ϵ��ʽ</th>
<th width="80">�ͻ�����</th>
<th width="80">���</th>
<th width="80">���Ѷ�</th>
<th width="100">����</th>
</tr>
<?foreach($Province as $rs){
if($ag=$db->record("agent","company,content,money,paymoney","prov='".$rs[0]."'",1)){
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
$count2=$db->rows("setting","infoprov='".$rs[0]."'");
?>
<tr align="center">
<td height="20"><?=$rs[1]?></td>
<td><?=$Agent?></td>
<td><?=$content?></td>
<td><?=$count2?></td>
<td><?=$money?></td>
<td><?=$paymoney?></td>
<td align="center">
  <a href="admin.php?action=agent_set&type=prov&prov=<?=$rs[0]?>" style="color:blue">����</a> 
  <a href="admin.php?action=agent_city&prov=<?=$rs[0]?>" style="color:blue">�д���</a> 
  <a href="admin.php?action=company4&prov=<?=$rs[0]?>" style="color:blue">�ͻ�</a> 
</td>
</tr>
<?}?>
</table>
<?include("footer.php");?>