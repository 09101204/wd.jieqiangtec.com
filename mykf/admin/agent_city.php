<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<h3><?=$prov?>省代理商列表</h3>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="100">城市</th>
<th width="80">代理</th>
<th>联系方式</th>
<th width="80">客户数量</th>
<th width="80">余额</th>
<th width="80">消费额</th>
<th width="100">操作</th>
</tr>
<?foreach($citys as $c){
if($ag=$db->record("agent","company,content,money,paymoney","prov='$prov' and city='".$c."'",1)){
  $Agent= $ag[0]['company'];
  $content= $ag[0]['content'];
  $money= $ag[0]['money'];
  $paymoney= $ag[0]['paymoney'];
}else{
  $Agent= '无';
  $content= '无';
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
  <a href="admin.php?action=agent_set&type=city&prov=<?=$prov?>&city=<?=$c?>" style="color:blue">市代理</a> 
  <a href="admin.php?action=company5&prov=<?=$prov?>&city=<?=$c?>" style="color:blue">客户</a> 
</td>
</tr>
<?}?>
</table>
<?=setinput("button","button","返回上一页","onclick='history.go(-1)'")?>
<?include("footer.php");?>