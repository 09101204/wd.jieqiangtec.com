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
<td width="15%" height="20" align="right">���⣺</td>
<td width="85%"><?=setinput("text","title",$title_,"",50,100)?> <font color=red>*</font></td>
</tr>
<?if($ntype=='news'){?>
<tr>
<td height="20" align="right">���ߣ�</td>
<td>
<?=setinput("text","author",$author,"",20,20)?>��
��Դ:
<?=setinput("text","comefrom",$company,"",30,80)?>
</td>
</tr>
<?}?>
<tr>
<td height="20" align="right"><font color=red>*</font>���ݣ�</td>
<td><?=SetEditor(1,$content)?></td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("hidden","ntype",$ntype)?>
<?=setinput("hidden","id",$id)?>
<?=setinput("submit","submit",$btnname)?> 
<?=setinput("button","button","������һҳ","onclick='history.go(-1)'")?>
</td>
</tr>
</table>
</form>
<script language="JavaScript">
function checkform(){
if(myform.title.value==""){
    alert("���ⲻ��Ϊ��");
    myform.title.focus();
    return false;
  }
if(eWebEditor1.getHTML()==""){
    alert("���ݲ���Ϊ��");
    return false;
  }
}
</script>
<?include("footer.php");?>