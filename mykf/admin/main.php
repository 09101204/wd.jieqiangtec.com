<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
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
<td height="20">��ϯλ����:<font color="#ff0000"><?=$sortcount?></font>
���������ͷ�����:<font color="#ff0000"><?=$workercount?></font></td>
</tr>
<tr>
<td height="20">�����߿ͷ�:<font color="#ff0000"><?=$onlinecount1?></font>
�����������߷ÿ�:<font color="#ff0000"><?=$onlinecount2?></font></td>
</tr>
</table>
<?if($expagent){?>
<h3>���´��������ڻ��ѹ���</h3>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="100">ʡ��</th>
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
<td height="20"><?=$rs['prov']?><?=$rs['city']?></td>
<td><?=$rs['company']?></td>
<td><?=$rs['content']?></td>
<td><?=date('Y-m-d',$rs['exptime'])?></td>
<td><?=$rs['exptime']<$mytime ? '<font color="#ff0000">�ѹ���</font>':'<font color="orange">��������</font>'?></td>
<td align="center">
  <a href="<?=$rs['ntype']=='prov' ? '?action=agent_set&type=prov&prov='.$rs['prov'] : '?action=agent_set&type=city&prov='.$rs['prov'].'&city='.$rs['city']?>" style="color:blue">����</a>
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
<th width="120">�鿴��˾��Ϣ</th>
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
<a href="company_info.php?id=<?=$rs['id']?>">�鿴</a>
  <!--a href="../kf.php?mod=client&cid=<?=$rs['companyid']?>" target="_blank"><img src="../kf.php?mod=im&type=pic&cid=<?=$rs['companyid']?>&icon=<?=$default_icon?>" border="0"></a-->
</td>
</tr>
<?
if($i>=10)break;
}?>
</table>
<?if(count($expcompany)>$i){?><div align="right"><a href="?action=company_exp" style="color:blue">����>>></a></div><?}?>
<?}?>
<br />
<table border=0 cellspacing=1 align=center class=list>
<tr><th colspan=2>���������йز���<?=ToHelp('servermsg')?></th><th colspan=2>���֧���йز���<?=ToHelp('dllmsg')?></th></tr>
<tr>
  <td width="25%">����������</td>
  <td width="35%"><?=$_SERVER["SERVER_NAME"]?></td>
  <td width="25%">mysql���ݿ⣺</td>
  <td width="25%"><?=showResult(function_exists("mysql_close"))?></td>
</tr>
<tr>
  <td>������IP��</td>
  <td><?=$_SERVER["LOCAL_ADDR"]?></td>
  <td>odbc���ݿ⣺</td>
  <td><?=showResult(function_exists("odbc_close"))?></td>
</tr>
<tr>
  <td>�������˿ڣ�</td>
  <td><?=$_SERVER["SERVER_PORT"]?></td>
  <td> SQL Server���ݿ⣺</td>
  <td><?=showResult(function_exists("mssql_close"))?></td>
</tr>
<tr>
  <td>������ʱ�䣺</td>
  <td><?=date("Y��m��d��H��i��s��")?></td>
  <td>msql���ݿ⣺</td>
  <td><?=showResult(function_exists("msql_close"))?></td>
</tr>
<tr>
  <td>PHP�汾��</td>
  <td><?=PHP_VERSION?></td>
  <td>SMTP��</td>
  <td><?=showResult(get_magic_quotes_gpc("smtp"))?></td>
</tr>
<tr>
  <td>WEB�������汾��</td>
  <td><?=$_SERVER["SERVER_SOFTWARE"]?></td>
  <td>ͼ�δ��� GD Library��</td>
  <td><?=showResult(function_exists("imageline"))?></td>
</tr>

<tr>
  <td>����������ϵͳ��</td>
  <td><?=PHP_OS?></td>
  <td>XML��</td>
  <td><?=showResult(get_magic_quotes_gpc("XML Support"))?></td>
</tr>
<tr>
  <td>�ű���ʱʱ�䣺</td>
  <td><?=get_cfg_var("max_execution_time")?> ��</td>
  <td>FTP��</td>
  <td><?=showResult(get_magic_quotes_gpc("FTP support"))?></td>
</tr>
<tr>
  <td>վ������·����</td>
  <td><?=realpath("../")?></td>
  <td>Sendmail��</td>
  <td><?=showResult(get_magic_quotes_gpc("Internal Sendmail Support for Windows 4"))?></td>
</tr>
<tr>
  <td>�ű��ϴ��ļ���С���ƣ�</td>
  <td><?=get_cfg_var("upload_max_filesize")?get_cfg_var("upload_max_filesize"):"�������ϴ�����"?></td>
  <td>��ʾ������Ϣ��</td>
  <td><?=showResult(get_cfg_var("display_errors"))?></td>
</tr>
<tr>
  <td>POST�ύ�������ƣ�</td>
  <td><?=get_cfg_var("post_max_size")?></td>
  <td>ʹ��URL���ļ���</td>
  <td><?=showResult(get_cfg_var("allow_url_fopen"))?></td>
</tr>
<tr>
  <td>���������֣�</td>
  <td><?=getenv("HTTP_ACCEPT_LANGUAGE")?></td>
  <td>ѹ���ļ�֧��(Zlib)��</td>
  <td><?=showResult(function_exists("gzclose"))?></td>
</tr>
<tr>
  <td>�ű�����ʱ��ռ����ڴ棺</td>
  <td><?=get_cfg_var("memory_limit")?get_cfg_var("memory_limit"):"��"?></td>
  <td>ZEND֧��(1.3.0)��</td>
  <td><?=showResult(function_exists("zend_version"))?></td>
</tr>	
</table>
<?include("footer.php");
unset($tmp);
?>