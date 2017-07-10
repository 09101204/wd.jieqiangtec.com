<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<table border=0 cellspacing=1 align=left class=list>
<tr><th align="left">清除服务器缓存1(cache)</th></tr>
<?$i=0;
$tplpath="../eqmkdata/cache";
$dh=opendir($tplpath);
while ($file=readdir($dh)) {
  if($file!="." && $file!="..") {
    if(!is_dir($tplpath.'/'.$file)) {?>
<tr>
  <td>正在删除 <u><?=$file?></u>........<?
  $i++;
  @unlink($tplpath.'/'.$file);
  if(file_exists($tplpath.'/'.$file)){
    echo"<font color=red>失败</font>";
  }else{
    echo"<font color=green>成功</font>";
  }
  ?></td>
</tr>
      <?
    }
  }
}
if($i==0){?>
<tr>
  <td align="center"><font color=999999>没有找到任何文件！</font></td>
</tr>
<?}?>
<tr><th align="left">清除服务器缓存2(template)</th></tr>
<?$i=0;
$tplpath="../eqmkdata/template";
$dh=opendir($tplpath);
while ($file=readdir($dh)) {
  if($file!="." && $file!="..") {
    if(!is_dir($tplpath.'/'.$file)) {?>
<tr>
  <td>正在删除 <u><?=$file?></u>........<?
  @unlink($tplpath.'/'.$file);
  $i++;
  if(file_exists($tplpath.'/'.$file)){
    echo"<font color=red>失败</font>";
  }else{
    echo"<font color=green>成功</font>";
  }
  ?></td>
</tr>
      <?
    }
  }
}
if($i==0){?>
<tr>
  <td align="center"><font color=999999>没有找到任何文件！</font></td>
</tr>
<?}?>
</table>
<?php
include("footer.php");
?>

