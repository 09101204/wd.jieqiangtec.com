<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<form action="save.php?action=modify" method="post" onsubmit="return checkform()" name="myform">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">密码修改</th>
</tr>
<tr>
<td align="right">旧密码：</td>
<td><?=setinput("password","pass0","","",20,20)?></td>
</tr>
<tr>
<td align="right">新密码：</td>
<td><?=setinput("password","pass1","","",20,20)?></td>
</tr>
<tr>
<td align="right">确认新密码：</td>
<td><?=setinput("password","pass2","","",20,20)?></td>
</tr>
<tr>
<td colspan=2 align="center"><?=setinput("submit","submit"," 保存修改 ")?></td>
</tr>
</table>
</form>
<script language="JavaScript">
function checkform(){
  if(myform.pass0.value==""){
    alert("旧密码不能为空");
    myform.pass0.focus();
    return false;
  }
  if(myform.pass1.value==""){
    alert("新密码不能为空");
    myform.pass1.focus();
    return false;
  }
  if(myform.pass1.value!=myform.pass2.value){
    alert("新密码与确认密码不一致");
    myform.pass1.focus();
    return false;
  }
  return true;
}
</script>
<?include("footer.php");?>