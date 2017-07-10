<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");
getdir("管理自动应答,?action=faq");
?>
<form name="myform" action="save.php?action=addfaq" onsubmit="return checkform()" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;添加自动应答</th>
</tr>
<tr>
<td width="20%" height="20" align="right">标题：</td>
<td width="80%"><?=setinput("text","title","","",50,100)?> <font color=red>*</font></td>
</tr>
<tr>
<td height="20" align="right"> <font color=red>*</font>内容：</td>
<td><?=setinput("textarea","content1","","",50,8)?></td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("submit","submit","立即添加")?></td>
</tr>
</table>
</form>
<script language="JavaScript">
function checkform(){
if(myform.title.value==""){
    alert("标题不能为空");
    myform.title.focus();
    return false;
  }
if(myform.content1.value==""){
    alert("内容不能为空");
    myform.content1.focus();
    return false;
  }
}
</script>
<?include("footer.php");?>