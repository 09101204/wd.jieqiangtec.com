<?php
if(!defined('IN_EQMK') || !defined('IN_AGENT')) {
	exit('Access Denied');
}
include("header.php");?>
<form action="save.php?action=company_add" method="post" onsubmit="return checkform()" name="myform">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">��ӿͻ�</th>
</tr>
<tr>
<td width="30%" align="right">����ʡ�У�</td>
<td width="70%">
  <select name="p"><?=$provs?></select>
  <select name="c"><?=$citys?></select>
</td>
</tr>
<tr>
<td align="right">�ͻ���ţ�</td>
<td><?=setinput("text","companyid",$companyid,"",20,100)?></td>
</tr>
<tr>
<td align="right">��½�û�����</td>
<td><font color="red">Ĭ�Ϲ����˺���ͻ������ͬ</font></td>
</tr>
<tr>
<td align="right">��½���룺</td>
<td><?=setinput("text","pass",$pass,"",20,100)?> 
<?=setinput("button","dpass","000000","onclick=\"myform.pass.value=this.value\"")?> 
<?=setinput("button","dpass","123456","onclick=\"myform.pass.value=this.value\"")?> 
<?=setinput("button","dpass","666666","onclick=\"myform.pass.value=this.value\"")?> 
<?=setinput("button","dpass","888888","onclick=\"myform.pass.value=this.value\"")?> 
</td>
</tr>
<tr>
<td colspan=2 align="center"><?=setinput("submit","submit"," �����޸� ")?></td>
</tr>
</table>
</form>
<script language="JavaScript">
function checkform(){
  if(myform.companyid.value==""){
    alert("�ͻ���Ų���Ϊ��");
    myform.companyid.focus();
    return false;
  }
  if(myform.pass.value==""){
    alert("��½���벻��Ϊ��");
    myform.pass.focus();
    return false;
  }
  return true;
}
</script>
<?include("footer.php");?>