<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="100">企业名称</th>
<th width="100">代理商</th>
<th width="80">过期时间</th>
<th width="80">状态</th>
<th width="100">操作</th>
<th width="120"></th>
</tr>
<?$i=0;
foreach($expcompany[0] as $rs){
$i++;
if($rs['agent']){
  if($agent=$db->record("agent","prov,city,ntype,company","username='".$rs['agent']."'",1)){
    $ag='<a href="'.($agent[0]['ntype']=='prov' ? '?action=agent_set&type=prov&prov='.$agent[0]['prov'] : '?action=agent_set&type=city&prov='.$agent[0]['prov'].'&city='.$agent[0]['city']).'" title="'.($agent[0]['ntype']=='prov' ? $agent[0]['prov'].'总代理' : $agent[0]['prov'].$agent[0]['city'].'总代理').'">'.$agent[0]['company'].'</a>';
  }else{
    $ag='无';
  }
}else{
  $ag='无';
}?>
<tr align="center">
<td height="20"><?=$rs['company']?></td>
<td><?=$ag?></td>
<td><?=date('Y-m-d',$rs['exptime'])?></td>
<td><?=$rs['exptime']<$mytime ? '<font color="#ff0000">已过期</font>':'<font color="orange">即将过期</font>'?></td>
<td align="center">
  <a href="?action=companyedit&id=<?=$rs['id']?>" style="color:blue">设置</a>
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