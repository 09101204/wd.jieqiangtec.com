<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<form name="myform" action="save.php?action=editfunction" onsubmit="return checkform()" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;修改客服功能<?=ToHelp('function')?></th>
</tr>
<tr>
<td width="20%" height="20" align="right">功能标题：</td>
<td width="80%"><?=setinput("text","title",$title_,"",20,20)?> <?=setinput('checkbox',"isused",'1',$isused)?>有效</td>
</tr>
<tr>
<td height="20" align="right">购买价格：</td>
<td><?=setinput("text","price",$price,"",50,100)?></td>
</tr>
<tr>
<td height="20" align="right">使用天数：</td>
<td><?=setinput("text","days",$days,"",50,100)?></td>
</tr>
<tr>
<td height="20" align="right">功能描述：</td>
<td><?=setinput("text","content",$content,"",50,100)?></td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("hidden","id",$id)?><?=setinput("submit","submit","保存修改")?> 
<?=setinput("button","button","返回上一页","onclick=\"history.go(-1)\"")?> </td>
</tr>
</table>
</form>
<script language="JavaScript">
function checkform(){
  if(myform.title.value==""){
    alert("功能标题不能为空");
    myform.title.focus();
    return false;
  }
  if(myform.price.value==""){
    alert("购买价格不能为空");
    myform.price.focus();
    return false;
  }
  if(isNaN(myform.price.value)){
    alert("购买价格只能为数字");
    myform.price.value=0;
    myform.price.focus();
    return false;
  }
  if(myform.days.value==""){
    alert("使用天数不能为空");
    myform.days.focus();
    return false;
  }
  if(isNaN(myform.days.value)){
    alert("使用天数只能为数字");
    myform.days.value=0;
    myform.days.focus();
    return false;
  }
}
</script>
<?include("footer.php");?>