<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");?>
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th align="left" colspan=2>&nbsp;客服席位管理</th>
</tr>
<form action="save.php?action=addworkersort" method="post" onsubmit="return checkform(myform)" name="myform">
<tr>
<td height="20">
席位：<?=setinput("text","sort","","",20,20)?> 
排序：<?=setinput("text","taxis","0","",8,8)?><?=setinput("submit","submit","添加","")?></td>
</tr>
</form>
<?$i=0;
if(is_array($workersort)){
foreach($workersort as $rs){
$i++;?><form action="save.php?action=editworkersort" method="post" onsubmit="return checkform(myform<?=$i?>)" name="myform<?=$i?>">
<tr>
<td height="20">
席位：<?=setinput("text","sort",$rs['sort'],"",20,20)?> 
排序：<?=setinput("text","taxis",$rs['taxis'],"",8,8)?><?=setinput("hidden","id",$rs['id'])?><?=setinput("submit","submit","修改")?> 
<?=setinput("button","button","删除","onclick=\"if(confirm('所有下属客服也会被删除\\n您确定要删除此席位吗？'))location='save.php?action=delworkersort&id=".$rs['id']."'\"")?></td>
</tr>
</form>
<?}}?><script language="JavaScript">
function checkform(form){
  if(form.sort.value==""){
    alert("席位不能为空");
    form.sort.focus();
    return false;
  }
}
</script>
</table>
<?include("footer.php");?>