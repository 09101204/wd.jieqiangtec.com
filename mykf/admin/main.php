<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
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
<td height="20">　席位数量:<font color="#ff0000"><?=$sortcount?></font>
　　　　客服数量:<font color="#ff0000"><?=$workercount?></font></td>
</tr>
<tr>
<td height="20">　在线客服:<font color="#ff0000"><?=$onlinecount1?></font>
　　　　在线访客:<font color="#ff0000"><?=$onlinecount2?></font></td>
</tr>
</table>
<?if($expagent){?>
<h3>以下代理即将过期或已过期</h3>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="100">省市</th>
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
<td height="20"><?=$rs['prov']?><?=$rs['city']?></td>
<td><?=$rs['company']?></td>
<td><?=$rs['content']?></td>
<td><?=date('Y-m-d',$rs['exptime'])?></td>
<td><?=$rs['exptime']<$mytime ? '<font color="#ff0000">已过期</font>':'<font color="orange">即将过期</font>'?></td>
<td align="center">
  <a href="<?=$rs['ntype']=='prov' ? '?action=agent_set&type=prov&prov='.$rs['prov'] : '?action=agent_set&type=city&prov='.$rs['prov'].'&city='.$rs['city']?>" style="color:blue">设置</a>
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
<th width="120">查看公司信息</th>
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
<a href="company_info.php?id=<?=$rs['id']?>">查看</a>
  <!--a href="../kf.php?mod=client&cid=<?=$rs['companyid']?>" target="_blank"><img src="../kf.php?mod=im&type=pic&cid=<?=$rs['companyid']?>&icon=<?=$default_icon?>" border="0"></a-->
</td>
</tr>
<?
if($i>=10)break;
}?>
</table>
<?if(count($expcompany)>$i){?><div align="right"><a href="?action=company_exp" style="color:blue">更多>>></a></div><?}?>
<?}?>
<br />
<table border=0 cellspacing=1 align=center class=list>
<tr><th colspan=2>服务器的有关参数<?=ToHelp('servermsg')?></th><th colspan=2>组件支持有关参数<?=ToHelp('dllmsg')?></th></tr>
<tr>
  <td width="25%">服务器名：</td>
  <td width="35%"><?=$_SERVER["SERVER_NAME"]?></td>
  <td width="25%">mysql数据库：</td>
  <td width="25%"><?=showResult(function_exists("mysql_close"))?></td>
</tr>
<tr>
  <td>服务器IP：</td>
  <td><?=$_SERVER["LOCAL_ADDR"]?></td>
  <td>odbc数据库：</td>
  <td><?=showResult(function_exists("odbc_close"))?></td>
</tr>
<tr>
  <td>服务器端口：</td>
  <td><?=$_SERVER["SERVER_PORT"]?></td>
  <td> SQL Server数据库：</td>
  <td><?=showResult(function_exists("mssql_close"))?></td>
</tr>
<tr>
  <td>服务器时间：</td>
  <td><?=date("Y年m月d日H点i分s秒")?></td>
  <td>msql数据库：</td>
  <td><?=showResult(function_exists("msql_close"))?></td>
</tr>
<tr>
  <td>PHP版本：</td>
  <td><?=PHP_VERSION?></td>
  <td>SMTP：</td>
  <td><?=showResult(get_magic_quotes_gpc("smtp"))?></td>
</tr>
<tr>
  <td>WEB服务器版本：</td>
  <td><?=$_SERVER["SERVER_SOFTWARE"]?></td>
  <td>图形处理 GD Library：</td>
  <td><?=showResult(function_exists("imageline"))?></td>
</tr>

<tr>
  <td>服务器操作系统：</td>
  <td><?=PHP_OS?></td>
  <td>XML：</td>
  <td><?=showResult(get_magic_quotes_gpc("XML Support"))?></td>
</tr>
<tr>
  <td>脚本超时时间：</td>
  <td><?=get_cfg_var("max_execution_time")?> 秒</td>
  <td>FTP：</td>
  <td><?=showResult(get_magic_quotes_gpc("FTP support"))?></td>
</tr>
<tr>
  <td>站点物理路径：</td>
  <td><?=realpath("../")?></td>
  <td>Sendmail：</td>
  <td><?=showResult(get_magic_quotes_gpc("Internal Sendmail Support for Windows 4"))?></td>
</tr>
<tr>
  <td>脚本上传文件大小限制：</td>
  <td><?=get_cfg_var("upload_max_filesize")?get_cfg_var("upload_max_filesize"):"不允许上传附件"?></td>
  <td>显示错误信息：</td>
  <td><?=showResult(get_cfg_var("display_errors"))?></td>
</tr>
<tr>
  <td>POST提交内容限制：</td>
  <td><?=get_cfg_var("post_max_size")?></td>
  <td>使用URL打开文件：</td>
  <td><?=showResult(get_cfg_var("allow_url_fopen"))?></td>
</tr>
<tr>
  <td>服务器语种：</td>
  <td><?=getenv("HTTP_ACCEPT_LANGUAGE")?></td>
  <td>压缩文件支持(Zlib)：</td>
  <td><?=showResult(function_exists("gzclose"))?></td>
</tr>
<tr>
  <td>脚本运行时可占最大内存：</td>
  <td><?=get_cfg_var("memory_limit")?get_cfg_var("memory_limit"):"无"?></td>
  <td>ZEND支持(1.3.0)：</td>
  <td><?=showResult(function_exists("zend_version"))?></td>
</tr>	
</table>
<?include("footer.php");
unset($tmp);
?>