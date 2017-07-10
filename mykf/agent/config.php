<?php
if(!defined('IN_EQMK') || !defined('IN_AGENT')) {
	exit('Access Denied');
}
include("header.php");?>
<form action="save.php?action=config" method="post" onsubmit="return checkform()" name="myform">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">修改资料</th>
</tr>
<tr>
<td width="30%" align="right">公司名称：</td>
<td width="70%"><?=setinput("text","company",$company,"",50,100)?></td>
</tr>
<tr>
<td align="right">联系方式：</td>
<td><?=setinput("text","content",$content,"",50,100)?></td>
</tr>
<tr>
<td colspan=2 align="center"><?=setinput("submit","submit"," 保存修改 ")?></td>
</tr>
</table>
</form>
<script language="JavaScript">
function checkform(){
  if(myform.company.value==""){
    alert("公司名称不能为空");
    myform.company.focus();
    return false;
  }
  if(myform.content.value==""){
    alert("联系方式不能为空");
    myform.content.focus();
    return false;
  }
  return true;
}
</script>
<?include("footer.php");?>