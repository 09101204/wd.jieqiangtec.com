<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
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
foreach($expcompany[0] as $rs){
$i++;
if($rs['agent']){
  if($agent=$db->record("agent","prov,city,ntype,company","username='".$rs['agent']."'",1)){
    $ag='<a href="'.($agent[0]['ntype']=='prov' ? '?action=agent_set&type=prov&prov='.$agent[0]['prov'] : '?action=agent_set&type=city&prov='.$agent[0]['prov'].'&city='.$agent[0]['city']).'" title="'.($agent[0]['ntype']=='prov' ? $agent[0]['prov'].'�ܴ���' : $agent[0]['prov'].$agent[0]['city'].'�ܴ���').'">'.$agent[0]['company'].'</a>';
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
<?=$expcompany[1]?>
<?include("footer.php");?>