<?php
if(!defined('IN_EQMK') || !defined('IN_AGENT')) {
	exit('Access Denied');
}
include("header.php");?>
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th align="left" colspan=2>&nbsp;������ʾ<?if($tips)echo'<img src="../images/admincp/tips.gif">'?></th>
</tr>
<tr>
<td height="20" colspan="2" style="line-height:20px">
  <?=$tips?>
</td>
</tr>
</table>
<br />
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th align="left" colspan=2>&nbsp;��½��Ϣ<?=ToHelp('loginmsg')?></th>
</tr>
<tr>
<td height="20" colspan="2">������,<font color=red><b><?=$username?></b></font>�������:<font color=blue><?=$wid?></font>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;���������
<select id="adminstyle"><?=$style_options?></select>
<?=setinput("button","button","Ӧ��","onclick=\"location.href='save.php?action=setstyle&curstyle='+$('adminstyle').options.value\"")?></td>
</tr>
<tr>
<td height="20" colspan="2">����������<font color=red><?=$logincount?></font>�ε�½��ϵͳ</td>
</tr>
<tr>
<td height="20">���ϴε�½ʱ��:<font color=009933><?=$lasttime?></font></td>
</tr>
<tr>
<td height="20">���ϴ�IP��ַ:<font color=009933><?=$lastip?></font> <?=$lastaddress?></td>
</tr>
<tr>
<td height="20">�����ε�½ʱ��:<font color=009933><?=$thistime?></font></td>
</tr>
<tr>
<td height="20">������IP��ַ:<font color=009933><?=$thisip?></font> <?=$thisaddress?></td>
</tr>
<tr>
<th align="left" colspan=2>&nbsp;���ݸſ�<?=ToHelp('datamsg')?></th>
</tr>
<tr>
<td height="20">����ѿͻ�:<font color="#ff0000"><?=$comcount1?></font>
�����������ѿͻ�:<font color="#ff0000"><?=$comcount2?></font>
��������ȫ���ܿͻ�:<font color="#ff0000"><?=$comcount3?></font></td>
</tr>
<tr>
<td height="20">����˾����:<font color="#ff0000"><?=$company?></font></td>
</tr>
<tr>
<td height="20">��������:<font color="#ff0000"><?=$grade?></font></td>
</tr>
<tr>
<td height="20">�����:<font color="#ff0000"><?=$money?></font> &nbsp;&nbsp;&nbsp;
���Ѷ�:<font color="#ff0000"><?=$paymoney?></font> <a href="?action=my_money" style="color:blue">��ϸ</a></td>
</tr>
</table>
<?if($expagent){?>
<h3>���´��������ڻ��ѹ���</h3>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="100">����</th>
<th width="100">������</th>
<th width="100">��ϵ��ʽ</th>
<th width="80">����ʱ��</th>
<th width="80">״̬</th>
<th width="100">����</th>
</tr>
<?$i=0;
foreach($expagent as $rs){
$i++;?>
<tr align="center">
<td height="20"><?=$rs['city']?></td>
<td><?=$rs['company']?></td>
<td><?=$rs['content']?></td>
<td><?=date('Y-m-d',$rs['exptime'])?></td>
<td><?=$rs['exptime']<$mytime ? '<font color="#ff0000">�ѹ���</font>':'<font color="orange">��������</font>'?></td>
<td align="center">
  <a href="?action=agent_set&c=<?=$rs['city']?>" style="color:blue">����</a>
</td>
</tr>
<?
if($i>=10)break;
}?>
</table>
<?if(count($expagent)>$i){?><div align="right"><a href="?action=agent_exp" style="color:blue">����>>></a></div><?}?>
<?}?>
<?if($expcompany){?>
<h3>���¿ͻ��������ڻ��ѹ���</h3>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="100">��ҵ����</th>
<th width="100">������</th>
<th width="80">����ʱ��</th>
<th width="80">״̬</th>
<th width="100">����</th>
<th width="120"></th>
</tr>
<?$i=0;
foreach($expcompany as $rs){
$i++;
if($rs['agent']){
  if($agent=$db->record("agent","prov,city,ntype,company","username='".$rs['agent']."'",1)){
    $ag=$agent[0]['ntype']=='prov' ? $agent[0]['company'] :'<a href="?action=agent_set&c='.$agent[0]['city'].'" title="'.$agent[0]['city'].'�ܴ���">'.$agent[0]['company'].'</a>';
  }else{
    $ag='��';
  }
}else{
  $ag='��';
}?>
<tr align="center">
<td height="20"><?=$rs['company']?></td>
<td><?=$ag?></td>
<td><?=date('Y-m-d',$rs['exptime'])?></td>
<td><?=$rs['exptime']<$mytime ? '<font color="#ff0000">�ѹ���</font>':'<font color="orange">��������</font>'?></td>
<td align="center">
  <a href="?action=companyedit&id=<?=$rs['id']?>" style="color:blue">����</a>
</td>
<td align="center">
  <a href="../kf.php?mod=client&cid=<?=$rs['companyid']?>" target="_blank"><img src="../kf.php?mod=im&type=pic&cid=<?=$rs['companyid']?>&icon=<?=$default_icon?>" border="0"></a>
</td>
</tr>
<?
if($i>=10)break;
}?>
</table>
<?if(count($expcompany)>$i){?><div align="right"><a href="?action=company_exp" style="color:blue">����>>></a></div><?}?>
<?}?>
<?include("footer.php");?>