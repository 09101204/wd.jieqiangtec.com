<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<form name="myform" action="save.php?action=editfunction" onsubmit="return checkform()" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;�޸Ŀͷ�����<?=ToHelp('function')?></th>
</tr>
<tr>
<td width="20%" height="20" align="right">���ܱ��⣺</td>
<td width="80%"><?=setinput("text","title",$title_,"",20,20)?> <?=setinput('checkbox',"isused",'1',$isused)?>��Ч</td>
</tr>
<tr>
<td height="20" align="right">����۸�</td>
<td><?=setinput("text","price",$price,"",50,100)?></td>
</tr>
<tr>
<td height="20" align="right">ʹ��������</td>
<td><?=setinput("text","days",$days,"",50,100)?></td>
</tr>
<tr>
<td height="20" align="right">����������</td>
<td><?=setinput("text","content",$content,"",50,100)?></td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("hidden","id",$id)?><?=setinput("submit","submit","�����޸�")?> 
<?=setinput("button","button","������һҳ","onclick=\"history.go(-1)\"")?> </td>
</tr>
</table>
</form>
<script language="JavaScript">
function checkform(){
  if(myform.title.value==""){
    alert("���ܱ��ⲻ��Ϊ��");
    myform.title.focus();
    return false;
  }
  if(myform.price.value==""){
    alert("����۸���Ϊ��");
    myform.price.focus();
    return false;
  }
  if(isNaN(myform.price.value)){
    alert("����۸�ֻ��Ϊ����");
    myform.price.value=0;
    myform.price.focus();
    return false;
  }
  if(myform.days.value==""){
    alert("ʹ����������Ϊ��");
    myform.days.focus();
    return false;
  }
  if(isNaN(myform.days.value)){
    alert("ʹ������ֻ��Ϊ����");
    myform.days.value=0;
    myform.days.focus();
    return false;
  }
}
</script>
<?include("footer.php");?>