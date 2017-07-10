<?php
if(!defined('IN_EQMK') || !defined('IN_AGENT')) {
	exit('Access Denied');
}
include("header.php");?>
<?if($MyTitle)echo'<h3>'.$MyTitle.'</h3>'?>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="20%">企业名称</th>
<th width="20%">代理商</th>
<th width="10%">余额</th>
<th width="10%">消费额</th>
<th width="10%">热度</th>
<th width="10%">咨询</th>
<th width="10%">点评</th>
<th width="30%">操作</th>
</tr>
<?foreach($company[0] as $rs){
$id=$rs["id"];
if($rs['agent']){
  if($agent=$db->record("agent","prov,city,ntype,company","username='".$rs['agent']."'",1)){
    $ag=$agent[0]['ntype']=='prov' ? $agent[0]['company'] :'<a href="?action=agent_set&c='.$agent[0]['city'].'" title="'.$agent[0]['city'].'总代理">'.$agent[0]['company'].'</a>';
  }else{
    $ag='无';
  }
}else{
  $ag='无';
}
?>
<tr>
<td height="20"><a href="agent.php?action=companyedit&id=<?=$id?>"><?=$rs["company"]?></a></td>
<td><?=$ag?></td>
<td align="center"><?=$rs["money"]?></td>
<td align="center"><?=$rs["paymoney"]?></td>
<td align="center"><?=$rs["hot"]?></td>
<td align="center"><?=$rs["talk"]?></td>
<td align="center"><?=$rs["comment"]?></td>
<td align="center">
  <a href="agent.php?action=companyedit&id=<?=$id?>"><img src="../images/agentcp/icon_edit.gif" border="0" alt="编辑客户"></a>
  <?if($thegrade){?>
  <a href="save.php?action=delcompany&id=<?=$id?>&ac=<?=$action?>" onClick="return confirm('您确定要删除该企业吗？\n\n该操作不可恢复，请慎重进行！')"><img src="../images/agentcp/icon_delete.gif" border="0" alt="删除客户"></a>
  <?}?>
  <a href="agent.php?action=company_money&cid=<?=$rs["companyid"]?>"><img src="../images/agentcp/icon_money.gif" border="0" alt="消费明细"></a>
  <a href="agent.php?action=company_log&cid=<?=$rs["companyid"]?>"><img src="../images/agentcp/icon_log.gif" border="0" alt="操作日志"></a>
</td>
</tr>
<?}?>
</table>
<table width='90%' height=2><tr ><td></td></tr></table>
<!--页码开始-->
<?=$company[1]?>
<!--页码结束-->
<script language=javascript>
function CheckAll(form){
  for (var i=0;i<form.elements.length;i++){
    var e = form.elements[i];
    if (e.name != 'checkbox')
    e.checked = form.checkbox.checked;
  }
}
</script>
<?include("footer.php");?>