<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");
?>
<style type="text/css">
.parentfolder{text-align:left;background:url('../images/file/parentfolder.gif') no-repeat left -5px;padding-left:20px}
a{color:#0000ff;text-decoration:none}
a:hover{color:#0000ff}
</style>
<div class="parentfolder"><?=$parentpath?></div>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="200">文件名称</th>
<th width="80">原文件大小</th>
<th width="80">新文件大小</th>
<th width="160">修改时间</th>
</tr>
<?foreach($files as $v){
$filetype=end(explode('.',$v[0]));
?>
<tr>
<td height="20"><font face="Wingdings" size="4">2</font> <?=$v[0]?></td>
<td align="right"><?=$v[1]?></td>
<td align="right"><?=$v[2]?></td>
<td align="center" style="color:<?=$v[4]?>"><?=$v[3]?></td>
</tr>
<?}?>
</table>
<?include("footer.php");?>