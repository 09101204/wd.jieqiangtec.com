<?php
if(!defined('IN_EQMK') || !defined('IN_AGENT')) {
	exit('Access Denied');
}
include("header.php");?>
<form name="myform" action="save.php?action=agent_set" onsubmit="return checkform()" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;<?=$title?></th>
</tr>
<tr>
<td width="20%" height="20" align="right">���У�</td>
<td width="80%" style="color:red"> <?=$thecity?></td>
</tr>
<?if($ntype=='add'){?>
<tr>
<td height="20" align="right">��½�û�����</td>
<td><?=setinput("text","uname",$uname,"",40,100)?></td>
</tr>
<tr>
<td height="20" align="right">��½���룺</td>
<td><?=setinput("password","pword",$pword,"",40,100)?> <font color="#999999">Ĭ��Ϊ��<font color="red"><?=$pword?></font>��</font></td>
</tr>
<tr>
<td height="20" align="right">��˾���ƣ�</td>
<td><?=setinput("text","companyname",$companyname,"",40,100)?></td>
</tr>
<tr>
<td height="20" align="right">��ϵ��ʽ��</td>
<td><?=setinput("text","content",$content,"",40,100)?></td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("hidden","type","$type")?> 
<?=setinput("hidden","ntype","$ntype")?> 
<?=setinput("hidden","c","$city")?> 
<?=setinput("submit","submit","���".$thecity."����")?> 
<?=setinput("button","button","�鿴���������пͻ�","onclick=\"location.href='agent.php?action=company5&c=$city'\"")?> 
<?=setinput("button","button","������һҳ","onclick='history.go(-1)'")?>
</td>
</tr>
<?}else{?>
<tr>
<td height="20" align="right">��½�û�����</td>
<td style="color:red"> <?=$uname?> <a href="javascript:if(confirm('��ȷ��Ҫɾ���˴�����'))location.href='save.php?action=agent_del&id=<?=$id?>'" style="color:#0000ff">ɾ���˴���</a></td>
</tr>
<tr>
<td height="20" align="right">��ͨ��ʽ��</td>
<td style="color:red"> <?=$infotype?></td>
</tr>
<tr>
<td height="20" align="right">��½���룺</td>
<td><?=setinput("password","pword","","",40,100)?> <font color="#999999">����������</font></td>
</tr>
<tr>
<td height="20" align="right">��˾���ƣ�</td>
<td><?=setinput("text","companyname",$companyname,"",40,100)?></td>
</tr>
<tr>
<td height="20" align="right">��ϵ��ʽ��</td>
<td><?=setinput("text","content",$content,"",40,100)?></td>
</tr>
<tr>
<td height="20" align="right">��</td>
<td><font color="red"><?=$money?></font> Ԫ</td>
</tr>
<tr>
<td height="20" align="right">���Ѷ</td>
<td><font color="red"><?=$paymoney?></font> Ԫ</td>
</tr>
<tr>
<td height="20" align="right">ת����</td>
<td><?=setinput("text","money",0,"",5,5)?>Ԫ</td>
</tr>
<tr>
<td height="20" align="right">��ͨʱ�䣺</td>
<td><?=date('Y-m-d',$infotime)?></td>
</tr>
<tr>
<td height="20" align="right">����ʱ�䣺</td>
<td><?=date('Y-m-d',$exptime)?></td>
</tr>
<tr>
<td height="20" align="right">ʣ��������</td>
<td><?=setinput("text","days",$etime_,"",5,5)?>��</td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("hidden","id",$id)?>
<?=setinput("hidden","ntype","$ntype")?> 
<?=setinput("hidden","c","$city")?> 
<?=setinput("submit","submit","�����޸�")?> 
<?=setinput("button","button","������־","onclick=\"location.href='agent.php?action=agent_log&agent=$uname'\"")?> 
<?=setinput("button","button","������ϸ","onclick=\"location.href='agent.php?action=agent_money&agent=$uname'\"")?> 
<?=setinput("button","button","�鿴���������пͻ�","onclick=\"location.href='agent.php?action=company5&c=$city'\"")?> 
<?=setinput("button","button","������һҳ","onclick='history.go(-1)'")?>
</td>
</tr>
<?}?>
</table>
</form>
<script language="JavaScript">
function checkform(){
<?if($type=='add'){?>
  if(myform.uname.value.length<1){
    alert("��½�û�������Ϊ��");
    myform.uname.focus();
    return false;
  }
  if(myform.pword.value.length<1){
    alert("��½���벻��Ϊ��");
    myform.pword.focus();
    return false;
  }
<?}?>
  if(myform.companyname.value.length<1){
    alert("��˾���Ʋ���Ϊ��");
    myform.companyname.focus();
    return false;
  }
  return true;
}
</script>
<?include("footer.php");?>