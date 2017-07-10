<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<form name="myform" action="save.php?action=<?=$action?>" onsubmit="return checkform()" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;<?=$title?></th>
</tr>
<tr>
<td width="15%" height="20" align="right">标题：</td>
<td width="85%"><?=setinput("text","title",$title_,"",50,100)?> <font color=red>*</font></td>
</tr>
<?if($ntype=='news'){?>
<tr>
<td height="20" align="right">作者：</td>
<td>
<?=setinput("text","author",$author,"",20,20)?>　
来源:
<?=setinput("text","comefrom",$company,"",30,80)?>
</td>
</tr>
<?}?>
<tr>
<td height="20" align="right"><font color=red>*</font>内容：</td>
<td><?=SetEditor(1,$content)?></td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("hidden","ntype",$ntype)?>
<?=setinput("hidden","id",$id)?>
<?=setinput("submit","submit",$btnname)?> 
<?=setinput("button","button","返回上一页","onclick='history.go(-1)'")?>
</td>
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
if(eWebEditor1.getHTML()==""){
    alert("内容不能为空");
    return false;
  }
}
</script>
<?include("footer.php");?>