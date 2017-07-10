<?php
if(!defined('IN_EQMK') || !defined('IN_AGENT')) {
	exit('Access Denied');
}
include("header.php");?>
<form action="save.php?action=company_add" method="post" onsubmit="return checkform()" name="myform">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">添加客户</th>
</tr>
<tr>
<td width="30%" align="right">所属省市：</td>
<td width="70%">
  <select name="p"><?=$provs?></select>
  <select name="c"><?=$citys?></select>
</td>
</tr>
<tr>
<td align="right">客户编号：</td>
<td><?=setinput("text","companyid",$companyid,"",20,100)?></td>
</tr>
<tr>
<td align="right">登陆用户名：</td>
<td><font color="red">默认管理账号与客户编号相同</font></td>
</tr>
<tr>
<td align="right">登陆密码：</td>
<td><?=setinput("text","pass",$pass,"",20,100)?> 
<?=setinput("button","dpass","000000","onclick=\"myform.pass.value=this.value\"")?> 
<?=setinput("button","dpass","123456","onclick=\"myform.pass.value=this.value\"")?> 
<?=setinput("button","dpass","666666","onclick=\"myform.pass.value=this.value\"")?> 
<?=setinput("button","dpass","888888","onclick=\"myform.pass.value=this.value\"")?> 
</td>
</tr>
<tr>
<td colspan=2 align="center"><?=setinput("submit","submit"," 保存修改 ")?></td>
</tr>
</table>
</form>
<script language="JavaScript">
function checkform(){
  if(myform.companyid.value==""){
    alert("客户编号不能为空");
    myform.companyid.focus();
    return false;
  }
  if(myform.pass.value==""){
    alert("登陆密码不能为空");
    myform.pass.focus();
    return false;
  }
  return true;
}
</script>
<?include("footer.php");?>