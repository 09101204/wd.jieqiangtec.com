<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<table border=0 cellspacing=1 align=left class=list>
<tr><th align="left">�������������1(cache)</th></tr>
<?$i=0;
$tplpath="../eqmkdata/cache";
$dh=opendir($tplpath);
while ($file=readdir($dh)) {
  if($file!="." && $file!="..") {
    if(!is_dir($tplpath.'/'.$file)) {?>
<tr>
  <td>����ɾ�� <u><?=$file?></u>........<?
  $i++;
  @unlink($tplpath.'/'.$file);
  if(file_exists($tplpath.'/'.$file)){
    echo"<font color=red>ʧ��</font>";
  }else{
    echo"<font color=green>�ɹ�</font>";
  }
  ?></td>
</tr>
      <?
    }
  }
}
if($i==0){?>
<tr>
  <td align="center"><font color=999999>û���ҵ��κ��ļ���</font></td>
</tr>
<?}?>
<tr><th align="left">�������������2(template)</th></tr>
<?$i=0;
$tplpath="../eqmkdata/template";
$dh=opendir($tplpath);
while ($file=readdir($dh)) {
  if($file!="." && $file!="..") {
    if(!is_dir($tplpath.'/'.$file)) {?>
<tr>
  <td>����ɾ�� <u><?=$file?></u>........<?
  @unlink($tplpath.'/'.$file);
  $i++;
  if(file_exists($tplpath.'/'.$file)){
    echo"<font color=red>ʧ��</font>";
  }else{
    echo"<font color=green>�ɹ�</font>";
  }
  ?></td>
</tr>
      <?
    }
  }
}
if($i==0){?>
<tr>
  <td align="center"><font color=999999>û���ҵ��κ��ļ���</font></td>
</tr>
<?}?>
</table>
<?php
include("footer.php");
?>

