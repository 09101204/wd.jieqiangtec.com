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
<?=setinput("button","button","�����ļ��б�","onclick=\"location.href='?action=explorer&path=".urlencode($path)."'\"")?>
<form name="myform" action="save.php?action=editfile" onsubmit="return checkform()" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th align="left">&nbsp;�޸��ļ�<?=$file?>
</th>
</tr>
<tr>
<td><textarea name="content1" style="width:100%;height:500px;overflow-y:visible;font-family:Fixedsys;font-size:12px"><?=$co?></textarea></td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?if(!is_writeable($file)){
echo'<span style="color:red;font-weight:bold">���ļ���д��Ȩ��</span>';
}else{?>
<?=setinput("submit","submit","�����޸�")?> 
<?=setinput("reset","reset","����")?> 
<?if($defaultfile){?><?=setinput("button","button","�ָ������״̬","onclick=\"if(confirm('��ȷ��Ҫ�����ļ��ָ������״̬��')){location.href='?action=editfile&path=".urlencode($path)."&file=".urlencode($file)."&todefault=Y'}\"")?> <?}?>
<?=setinput("hidden","file",$file)?>
<?=setinput("hidden","path",$path)?>
<?}?>
<?=setinput("button","button","�����ļ��б�","onclick=\"location.href='?action=explorer&path=".urlencode($path)."'\"")?>
</td>
</tr>
</table>
</form>
<?include("footer.php");?>