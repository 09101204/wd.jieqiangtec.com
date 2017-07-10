<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<style type="text/css">
textarea td{
  color:red;
}
</style>
<?=setinput("button","button","返回文件列表","onclick=\"location.href='?action=explorer&path=".urlencode($path)."'\"")?>
<form name="myform" action="save.php?action=editfile" onsubmit="return checkform()" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th align="left">&nbsp;修改文件<?=$file?>
</th>
</tr>
<tr>
<td><textarea name="content1" style="width:100%;height:500px;overflow-y:visible;font-family:Fixedsys;font-size:12px"><?=$co?></textarea></td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?if(!is_writeable($file)){
echo'<span style="color:red;font-weight:bold">该文件无写入权限</span>';
}else{?>
<?=setinput("submit","submit","保存修改")?> 
<?=setinput("reset","reset","重置")?> 
<?if($defaultfile){?><?=setinput("button","button","恢复至最初状态","onclick=\"if(confirm('您确定要将此文件恢复到最初状态吗？')){location.href='?action=editfile&path=".urlencode($path)."&file=".urlencode($file)."&todefault=Y'}\"")?> <?}?>
<?=setinput("hidden","file",$file)?>
<?=setinput("hidden","path",$path)?>
<?}?>
<?=setinput("button","button","返回文件列表","onclick=\"location.href='?action=explorer&path=".urlencode($path)."'\"")?>
</td>
</tr>
</table>
</form>
<?include("footer.php");?>