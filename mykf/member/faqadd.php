<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");
getdir("�����Զ�Ӧ��,?action=faq");
?>
<form name="myform" action="save.php?action=addfaq" onsubmit="return checkform()" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;����Զ�Ӧ��</th>
</tr>
<tr>
<td width="20%" height="20" align="right">���⣺</td>
<td width="80%"><?=setinput("text","title","","",50,100)?> <font color=red>*</font></td>
</tr>
<tr>
<td height="20" align="right"> <font color=red>*</font>���ݣ�</td>
<td><?=setinput("textarea","content1","","",50,8)?></td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("submit","submit","�������")?></td>
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
if(myform.content1.value==""){
    alert("���ݲ���Ϊ��");
    myform.content1.focus();
    return false;
  }
}
</script>
<?include("footer.php");?>