<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");?>
<form action="save.php?action=modify" method="post" onsubmit="return checkform()" name="myform">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">�޸�����</th>
</tr>
<tr>
<td align="right">�û�����</td>
<td><font color=red><?=$username?></font></td>
</tr>
<tr>
<td align="right">��ʾ�ǳƣ�</td>
<td><?=setinput("text","nickname",$nickname,"",52,20)?></td>
</tr>
<tr>
<td align="right">��ʵ������</td>
<td><?=setinput("text","realname",$realname,"",52,20)?></td>
</tr>
<tr>
<td align="right">�Ա�</td>
<td><?=setinput("text","sex",$sex,"",52,100)?></td>
</tr>
<tr>
<td align="right">ʡ�У�</td>
<td><?=setinput("text","city",$city,"",52,100)?></td>
</tr>
<tr>
<td align="right">�绰��</td>
<td><?=setinput("text","phone",$phone,"",52,100)?></td>
</tr>
<tr>
<td align="right">�����ʼ���</td>
<td><?=setinput("text","email",$email,"",52,100)?></td>
</tr>
<tr>
<td align="right">QQ/MSN��</td>
<td><?=setinput("text","qq",$qq,"",52,100)?></td>
</tr>
<tr>
<td align="right">����ǩ����</td>
<td>
<?=setinput("textarea","content",$content,"",50,8)?><img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_sign.gif'>" style="cursor:pointer">֧��UBB��ǩ</td>
</tr>
<tr>
<th colspan=2 align="left">&nbsp;�Ի�����Ϣ����</th>
</tr>
<tr>
<td align="right">������ʾ���⣺</td>
<td><?=setinput("textarea","onlinetitle",$onlinetitle,"",52,8)?><img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_tiptitle.gif'>" style="cursor:pointer" align="absmiddle"></td>
</tr>
<tr>
<td align="right">������ʾ���ݣ�</td>
<td><?=setinput("textarea","onlinetip",$onlinetip,"",52,8)?><img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_tipcontent.gif'>" style="cursor:pointer" align="absmiddle"></td>
</tr>
<tr>
<td align="right">��������ʾ���⣺</td>
<td><?=setinput("textarea","offlinetitle",$offlinetitle,"",52,8)?><img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_tiptitle.gif'>" style="cursor:pointer" align="absmiddle"></td>
</tr>
<tr>
<td align="right">��������ʾ���ݣ�</td>
<td><?=setinput("textarea","offlinetip",$offlinetip,"",52,8)?><img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_tipcontent.gif'>" style="cursor:pointer" align="absmiddle"></td>
</tr>
<tr>
<td align="right">�ر���ʾ��</td>
<td><?=setinput("textarea","closetip",$closetip,"",52,8)?></td>
</tr>
<tr>
  <td align="right">�����ղؼУ�</td>
  <td>
  <input type="radio" name="Favorite" value="1" <?if($Favorite==1)echo'checked'?>>����
  <input type="radio" name="Favorite" value="0" <?if($Favorite==0)echo'checked'?>>�ر�
  </td>
</tr>
<tr>
  <td align="right">�ղؼ���ַ��</td>
  <td><?=setinput("text","FavoriteUrl",$FavoriteUrl,"",52,100)?>&nbsp;&nbsp;<font color=red>��ַǰ�����http://,�������д����ñ����ܣ�</font></td>
</tr>
<tr>
  <td align="right">��վ���ƣ�</td>
  <td><?=setinput("text","FavoriteName",$FavoriteName,"",52,100)?></td>
</tr>
<tr>
<th colspan=2 align="left">�޸�����</th>
</tr>
<tr>
<td align="right">�����룺</td>
<td><?=setinput("password","pass0","","",52,20)?> ����������</td>
</tr>
<tr>
<td align="right">�����룺</td>
<td><?=setinput("password","pass1","","",52,20)?></td>
</tr>
<tr>
<td align="right">ȷ�������룺</td>
<td><?=setinput("password","pass2","","",52,20)?></td>
</tr>
<tr>
<td colspan=2 align="center"><?=setinput("submit","submit","�����޸�")?></td>
</tr>
</table>
</form>
<script language="JavaScript">
function checkform(){
  if(myform.nickname.value==""){
    alert("�ǳƲ���Ϊ��");
    myform.nickname.focus();
    return false;
  }
  if(myform.pass0.value!=""){
    if(myform.pass1.value==""){
      alert("�����벻��Ϊ��");
      myform.pass1.focus();
      return false;
    }
    if(myform.pass1.value!=myform.pass2.value){
      alert("��������ȷ�����벻һ��");
      myform.pass1.focus();
      return false;
    }
  }
  return true;
}
</script>
<?include("footer.php");?>