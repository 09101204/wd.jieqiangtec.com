<?php
if(!defined('IN_EQMK') || !defined('IN_AGENT')) {
	exit('Access Denied');
}
include("header.php");?>
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th align="left" colspan=2>&nbsp;友情提示<?if($tips)echo'<img src="../images/admincp/tips.gif">'?></th>
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
<th align="left" colspan=2>&nbsp;登陆信息<?=ToHelp('loginmsg')?></th>
</tr>
<tr>
<td height="20" colspan="2">　您好,<font color=red><b><?=$username?></b></font>　　编号:<font color=blue><?=$wid?></font>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;管理界面风格
<select id="adminstyle"><?=$style_options?></select>
<?=setinput("button","button","应用","onclick=\"location.href='save.php?action=setstyle&curstyle='+$('adminstyle').options.value\"")?></td>
</tr>
<tr>
<td height="20" colspan="2">　这是您第<font color=red><?=$logincount?></font>次登陆本系统</td>
</tr>
<tr>
<td height="20">　上次登陆时间:<font color=009933><?=$lasttime?></font></td>
</tr>
<tr>
<td height="20">　上次IP地址:<font color=009933><?=$lastip?></font> <?=$lastaddress?></td>
</tr>
<tr>
<td height="20">　本次登陆时间:<font color=009933><?=$thistime?></font></td>
</tr>
<tr>
<td height="20">　本次IP地址:<font color=009933><?=$thisip?></font> <?=$thisaddress?></td>
</tr>
<tr>
<th align="left" colspan=2>&nbsp;数据概况<?=ToHelp('datamsg')?></th>
</tr>
<tr>
<td height="20">　免费客户:<font color="#ff0000"><?=$comcount1?></font>
　　　　付费客户:<font color="#ff0000"><?=$comcount2?></font>
　　　　全功能客户:<font color="#ff0000"><?=$comcount3?></font></td>
</tr>
<tr>
<td height="20">　公司名称:<font color="#ff0000"><?=$company?></font></td>
</tr>
<tr>
<td height="20">　代理级别:<font color="#ff0000"><?=$grade?></font></td>
</tr>
<tr>
<td height="20">　余额:<font color="#ff0000"><?=$money?></font> &nbsp;&nbsp;&nbsp;
消费额:<font color="#ff0000"><?=$paymoney?></font> <a href="?action=my_money" style="color:blue">明细</a></td>
</tr>
</table>
<?if($expagent){?>
<h3>以下代理即将过期或已过期</h3>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="100">城市</th>
<th width="100">代理商</th>
<th width="100">联系方式</th>
<th width="80">过期时间</th>
<th width="80">状态</th>
<th width="100">操作</th>
</tr>
<?$i=0;
foreach($expagent as $rs){
$i++;?>
<tr align="center">
<td height="20"><?=$rs['city']?></td>
<td><?=$rs['company']?></td>
<td><?=$rs['content']?></td>
<td><?=date('Y-m-d',$rs['exptime'])?></td>
<td><?=$rs['exptime']<$mytime ? '<font color="#ff0000">已过期</font>':'<font color="orange">即将过期</font>'?></td>
<td align="center">
  <a href="?action=agent_set&c=<?=$rs['city']?>" style="color:blue">设置</a>
</td>
</tr>
<?
if($i>=10)break;
}?>
</table>
<?if(count($expagent)>$i){?><div align="right"><a href="?action=agent_exp" style="color:blue">更多>>></a></div><?}?>
<?}?>
<?if($expcompany){?>
<h3>以下客户即将过期或已过期</h3>
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
foreach($expcompany as $rs){
$i++;
if($rs['agent']){
  if($agent=$db->record("agent","prov,city,ntype,company","username='".$rs['agent']."'",1)){
    $ag=$agent[0]['ntype']=='prov' ? $agent[0]['company'] :'<a href="?action=agent_set&c='.$agent[0]['city'].'" title="'.$agent[0]['city'].'总代理">'.$agent[0]['company'].'</a>';
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
<?if(count($expcompany)>$i){?><div align="right"><a href="?action=company_exp" style="color:blue">更多>>></a></div><?}?>
<?}?>
<?include("footer.php");?>