<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");
getdir("����ͷ��˺�,?action=worker");
?>
<form name="myform" action="save.php?action=addworker" onsubmit="return checkform()" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;����¿ͷ�</th>
</tr>
<tr>
<td width="20%" height="20" align="right">��ţ�</td>
<td width="80%"><?=setinput("text","taxis","0","",10,10)?> <span style="color:gray">ָ���ͷ���ʾ˳��</span></td>
</tr>
<tr>
<td height="20" align="right">ϯλ��</td>
<td>
<select name="sortid">
<?
foreach($sort as $rs){
  echo "<option value=\"".$rs["id"]."\">".$rs["sort"]."</option>";
}
?></select>
</td>
</tr>
<tr>
<td height="20" align="right">�Ƿ���ʾ��</td>
<td>
<?=setinput("radio","isshow","0")?>����ʾ<?=setinput("radio","isshow","1","checked")?>��ʾ</td>
</tr>
<tr>
<td height="20" align="right">�˺����ͣ�</td>
<td>
  <input type="radio" id="sort1" name="sort" value="1" onclick="selsort(1)" checked>��ͨ
  <input type="radio" id="sort2" name="sort" value="2" onclick="selsort(2)">QQ����
</td>
</tr>
<tr id="common1" style="display:">
<td height="20" align="right">Ȩ�ޣ�</td>
<td><?=$G?></td>
</tr>
<tr>
<td height="20" align="right">���������</td>
<td><select name="style"><?=$style_options?></select></td>
</tr>
<tr id="qq1" style="display:none">
<td height="20" align="right">QQ���룺</td>
<td><?=setinput("text","qq",$qq,"",30,30)?> <font color=red>*</font></td>
</tr>
<tr id="common2" style="display:">
<td height="20" align="right">��½�û�����</td>
<td><?=setinput("text","username",$uname,"",30,30)?> <font color=red>*</font></td>
</tr>
<tr id="common3" style="display:">
<td height="20" align="right">��½���룺</td>
<td><?=setinput("text","password",$pword,"",30,30)?></td>
</tr>
<tr>
<td height="20" align="right">��ʾ�ǳƣ�</td>
<td><?=setinput("text","nickname",$nname,"",30,30)?></td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("submit","submit","�������")?></td>
</tr>
</table>
</form>
<script language="JavaScript">
function selsort(id){
  if(id==1){
    $('common1').style.display='';
    $('common2').style.display='';
    $('common3').style.display='';
    $('qq1').style.display='none';
  }else{
    $('common1').style.display='none';
    $('common2').style.display='none';
    $('common3').style.display='none';
    $('qq1').style.display='';
  }
}
function checkform(){
  if($('sort1').checked){
    if(myform.username.value==""){
      alert("��½�û�������Ϊ��");
      myform.username.focus();
      return false;
    }
    if(myform.password.value==""){
      alert("��½���벻��Ϊ��");
      myform.password.focus();
      return false;
    }
  }else{
    if(myform.qq.value==""){
      alert("QQ���벻��Ϊ��");
      myform.qq.focus();
      return false;
    }
    if(isNaN(myform.qq.value)){
      alert("QQ����ֻ��Ϊ����");
      myform.qq.focus();
      return false;
    }
  }
  if(myform.nickname.value==""){
    alert("��ʾ�ǳƲ���Ϊ��");
    myform.nickname.focus();
    return false;
  }
}
</script>
<?include("footer.php");?>