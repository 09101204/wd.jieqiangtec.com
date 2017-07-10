<?php
if(!defined('IN_EQMK') || !defined('IN_AGENT')) {
	exit('Access Denied');
}
include("header.php");?>
<Object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="480" height="407">
<Param Name=quality Value='high'/>
<Param Name=wmode Value='transparent'/>
<Param Name=movie Value='../images/agentcp/chinamap.swf'/>
<param name='FlashVars' value='<?=$vars?>'></Object>
<br /><br />
<h3><?=$title?></h3>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="100">城市</th>
<th width="80">代理</th>
<th width="120">联系方式</th>
<th width="80">客户数量</th>
<th width="80">余额</th>
<th width="80">消费额</th>
<th width="100">操作</th>
</tr>
<?foreach($citys as $c){
if($ag=$db->record("agent","company,content,money,paymoney","ntype='city' and prov='$prov' and city='".$c."'",1)){
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
  <a href="agent.php?action=agent_set&c=<?=$c?>" style="color:blue">设置</a> 
  <a href="agent.php?action=company5&c=<?=$c?>" style="color:blue">客户</a> 
</td>
</tr>
<?}?>
</table>
<?include("footer.php");?>