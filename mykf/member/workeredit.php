<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");
getdir("����ͷ��˺�,?action=worker|����¿ͷ�,?action=workeradd");
?>
<form name="myform" action="save.php?action=editworker" onsubmit="return checkform()" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;�޸Ŀͷ�����</th>
</tr>
<tr>
<td width="20%" height="20" align="right">��ţ�</td>
<td width="80%"><?=setinput("text","taxis",$taxis,"",10,10)?> <span style="color:gray">ָ���ͷ���ʾ˳��</span></td>
</tr>
<tr>
<td height="20" align="right">ϯλ��</td>
<td>
<select name="sortid">
<?
$sort=$db->record("workersort","id,sort","companyid='$cid' order by taxis asc");
foreach($sort as $rs){
  $s=$rs["id"]==$sortid ? "selected" : null;
  echo "<option value=\"".$rs["id"]."\" $s>".$rs["sort"]."</option>";
}
?></select>
</td>
</tr>
<tr>
<td height="20" align="right">�Ƿ���ʾ��</td>
<td>
<?=setinput("radio","isshow","0",$s3)?>����ʾ
<?=setinput("radio","isshow","1",$s4)?>��ʾ
</td>
</tr>
<tr>
<td height="20" align="right">�˺����ͣ�</td>
<td>
  <input type="radio" id="sort1" name="sort" value="1" onclick="selsort(1)" <?=$sort1?>>��ͨ
  <input type="radio" id="sort2" name="sort" value="2" onclick="selsort(2)" <?=$sort2?>>QQ����
</td>
</tr>
<tr id="common1" style="display:<?=$common?>">
<td height="20" align="right">Ȩ�ޣ�</td>
<td><?=$G?></td>
</tr>
<tr id="qq1" style="display:<?=$qq1?>">
<td height="20" align="right">QQ���룺</td>
<td><?=setinput("text","qq",$qq,"",30,30)?> <font color=red>*</font></td>
</tr>
<tr id="common2" style="display:<?=$common?>">
<td height="20" align="right">��½�û�����</td>
<td><?=setinput("text","username",$uname,"",30,30)?> <font color=red>*</font></td>
</tr>
<tr id="common3" style="display:<?=$common?>">
<td height="20" align="right">��½���룺</td>
<td><?=setinput("text","password","","",30,30)?> ����������</td>
</tr>
<tr>
<td height="20" align="right">�ͷ��ǳƣ�</td>
<td><?=setinput("text","nickname",$nickname,"",30,30)?> 
<?if(CheckGrade('super')){?>
<font color="blue">��ǰ�ѿ�ͨ<u>�����ͷ�</u>���ܣ�����ǳ�����<font color="red">,</font>�ָ�</font>
<?}?>
</td>
</tr>
<tr>
<td height="20" align="right">��ʵ������</td>
<td><?=setinput("text","realname",$realname,"",30,30)?>��ʾ�ڿͷ����б���</td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("hidden","id",$id)?><?=setinput("submit","submit","�����޸�")?></td>
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
    if(isNaN(myform.username.value)){
      if(!confirm("���ֱ�Ӹ���ΪQQ�������ͣ�ԭ�����˺š�"+myform.username.value+"������ɾ�����Ƿ������")){
        $('sort1').checked=true;
        return;
      }else{
        myform.qq.value="";
        myform.qq.focus();
      }
    }
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