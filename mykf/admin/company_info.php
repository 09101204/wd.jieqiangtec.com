<?php
include("check.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk">
<title></title>
<link href="../template/admin/<?=$adminstyle?>/style.css" rel="stylesheet" type="text/css">
<script language='javascript' src='../template/admin/<?=$adminstyle?>/private.js'></script>
</head>
<body leftmargin="0" topmargin="20" class="mainbody">
<center>
<table width="92%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td align="center"> <TABLE height=29 cellSpacing=0 cellPadding=0 width="100%"
background=../template/admin/<?=$adminstyle?>/r_1.gif border=0>
<TBODY>
<TR>
<TD width="34" height="28" background="../template/admin/<?=$adminstyle?>/r_12.gif"><img 

src="../template/admin/<?=$adminstyle?>/r_11.gif" width="30" height="28"></TD>
<TD background="../template/admin/<?=$adminstyle?>/r_12.gif"><span class="font">&nbsp;</span></TD>
<TD width="86" align="right" background="../template/admin/<?=$adminstyle?>/r_12.gif"><img 

src="../template/admin/<?=$adminstyle?>/r_13.gif" width="80" height="28"></TD>
</TR>
</TBODY>
</TABLE>
<?php
$expcompany=$db->record("setting","id,companyid,agent,company,infotime,exptime,city","id=".$_GET['id']."",1);
$worker=$db->record("worker","id,companyid,lasttime,email,phone,thistime,city","companyid='".$expcompany[0]['companyid']."'",1);
//print_r($worker);
if($expcompany[0]['agent']){
  if($agent=$db->record("agent","prov,city,ntype,company","username='".$expcompany[0]['agent']."'",1)){
    $ag=$agent[0]['ntype']=='prov' ? $agent[0]['company'] :'<a href="?action=agent_set&c='.$agent[0]['city'].'" title="'.$agent[0]['city'].'总代理">'.$agent[0]['company'].'</a>';
  }else{
    $ag='无';
  }
}else{
  $ag='无';
}
?>

<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
<TBODY>
<TR>
<TD width=8 background="../template/admin/<?=$adminstyle?>/r_di1.gif">&nbsp;</TD>
<TD align=center valign="top" class="mainbg"><script type="text/javascript" 

src="../include/javascript/common.js"></script><table width="100%" border="0" align="center" cellspacing="1" class="list">
<tr align="center">
<th colspan="4" align="left"><?=$expcompany[0]['company']?></th>
</tr>
<tr align="center">
<td height="1" colspan="4"></td>
</tr>
<tr align="center">
<td width="25%" height="20">代理商</td>
<td width="25%"><a href="admin.php?action=agent_set&type=prov&prov=<?=$agent[0]['city']?>" title="<?=$ag?>"><?=$ag?></a></td>
<td width="25%">省市</td>
<td width="25%" align="center"><?=$worker[0]['city']?></td>
</tr>

<tr align="center">
  <td height="20">联系电话</td>
  <td><?=$worker[0]['phone']?></td>
  <td>电子邮件</td>
  <td><?=$worker[0]['email']?></td>
  </tr>

<tr align="center">
  <td height="20">注册时间</td>
  <td><?=date('Y-m-d',$expcompany[0]['infotime'])?></td>
  <td>过期时间</td>
  <td><?=date('Y-m-d',$expcompany[0]['exptime'])?></td>
  </tr>
<tr align="center">
<td height="20" colspan="4"><a href="admin.php?action=companyedit&id=<?=$expcompany[0]['id']?>" style="color:blue">设置</a></td>
</tr>
</table>
</TD>
<TD width=8 background="../template/admin/<?=$adminstyle?>/r_di2.gif">&nbsp;</TD>
</TR>
<TR>
<TD height="7"><img src="../template/admin/<?=$adminstyle?>/r_21.gif" width="8" height="7"></TD>
<TD background="../template/admin/<?=$adminstyle?>/r_22.gif"></TD>
<TD><img src="../template/admin/<?=$adminstyle?>/r_23.gif" width="8" height="8"></TD>
</TR>
</TBODY>
</TABLE>
</td>
</tr>
</table>
<br/>
<div style="width:92%;">
<table border="0" cellspacing="1" width="100%" align="center" class="list">
<tr align="center">
<th width="15%">企业名称</th>
<th width="10%">代理商</th>
<th width="10%">过期时间</th>
<th width="10%">状态</th>
<th width="5%">操作</th>
<th width="10%">查看公司信息</th>
</tr>
<?$i=0;
$mytime=GetTime(date('Y-m-d',$time));
$expcompany=$db->record("setting","id,companyid,agent,company,exptime","exptime<=".($mytime+86400*7)." order by exptime desc",'1000');
//$expcompany=$db->record("setting","id,companyid,agent,company,exptime","1 order by exptime desc",'');
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
  <a href="admin.php?action=companyedit&id=<?=$rs['id']?>" style="color:blue">设置</a>
</td>
<td align="center">
<a href="company_info.php?id=<?=$rs['id']?>">查看</a>
  <!--a href="../kf.php?mod=client&cid=<?=$rs['companyid']?>" target="_blank"><img src="../kf.php?mod=im&type=pic&cid=<?=$rs['companyid']?>&icon=<?=$default_icon?>" border="0"></a-->
</td>
</tr>
<?
if($i>=10)break;
}?>
</table>
</div>
</center>
</body>
</html>