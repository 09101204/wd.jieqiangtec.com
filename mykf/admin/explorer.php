<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");
?>
<style type="text/css">
a{color:#0000ff;text-decoration:none}
a:hover{color:#0000ff}
</style>
<div style="text-align:left"><?=$parentpath?></div>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="200">文件名称</th>
<th width="80">大小</th>
<th width="160">文件类型</th>
<th width="160">修改时间</th>
</tr>
<?foreach($folder as $v){?>
<tr>
<td height="20" colspan="4"><font face="Wingdings">0</font> <a href="?action=explorer&path=<?=urlencode($tplpath.'/'.$v)?>"><?=$v?></a></td>
</tr>
<?}?>
<?foreach($files as $v){
$filetype=end(explode('.',$v[0]));
$img=file_exists('../images/file/'.$filetype.'.gif')?$filetype.'.gif':'unknow.gif';
$filename=$v[3]?'<font color=red>'.$v[0].'</font>':$v[0];
if(in_array($filetype,array('php','txt','sql','htm','html','eqmk','js','css'))){
  $url='?action=editfile&path='.urlencode($tplpath).'&file='.urlencode($tplpath.'/'.$v[0]);
}else{
  $url=$tplpath.'/'.$v[0].'" target="_blank';
}
?>
<tr>
<td height="20"><font face="Wingdings" size="4">2</font> <a href="<?=$url?>"><?=$filename?></a></td>
<td align="right"><?=$v[1]?></td>
<td align="center"><?=strtoupper($filetype)?>文件</td>
<td align="center" style="color:<?=$v[4]?>"><?=$v[2]?></td>
</tr>
<?}?>
</table>
<?include("footer.php");?>