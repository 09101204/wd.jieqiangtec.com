<?php
if(!defined('IN_EQMK') || !defined('IN_AGENT')) {
	exit('Access Denied');
}
include("header.php");?>
<form action="save.php?action=config" method="post" onsubmit="return checkform()" name="myform">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">�޸�����</th>
</tr>
<tr>
<td width="30%" align="right">��˾���ƣ�</td>
<td width="70%"><?=setinput("text","company",$company,"",50,100)?></td>
</tr>
<tr>
<td align="right">��ϵ��ʽ��</td>
<td><?=setinput("text","content",$content,"",50,100)?></td>
</tr>
<tr>
<td colspan=2 align="center"><?=setinput("submit","submit"," �����޸� ")?></td>
</tr>
</table>
</form>
<script language="JavaScript">
function checkform(){
  if(myform.company.value==""){
    alert("��˾���Ʋ���Ϊ��");
    myform.company.focus();
    return false;
  }
  if(myform.content.value==""){
    alert("��ϵ��ʽ����Ϊ��");
    myform.content.focus();
    return false;
  }
  return true;
}
</script>
<?include("footer.php");?>