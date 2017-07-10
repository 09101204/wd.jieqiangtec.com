<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");?>
<form action="save.php?action=modify" method="post" onsubmit="return checkform()" name="myform">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">修改资料</th>
</tr>
<tr>
<td align="right">用户名：</td>
<td><font color=red><?=$username?></font></td>
</tr>
<tr>
<td align="right">显示昵称：</td>
<td><?=setinput("text","nickname",$nickname,"",52,20)?></td>
</tr>
<tr>
<td align="right">真实姓名：</td>
<td><?=setinput("text","realname",$realname,"",52,20)?></td>
</tr>
<tr>
<td align="right">性别：</td>
<td><?=setinput("text","sex",$sex,"",52,100)?></td>
</tr>
<tr>
<td align="right">省市：</td>
<td><?=setinput("text","city",$city,"",52,100)?></td>
</tr>
<tr>
<td align="right">电话：</td>
<td><?=setinput("text","phone",$phone,"",52,100)?></td>
</tr>
<tr>
<td align="right">电子邮件：</td>
<td><?=setinput("text","email",$email,"",52,100)?></td>
</tr>
<tr>
<td align="right">QQ/MSN：</td>
<td><?=setinput("text","qq",$qq,"",52,100)?></td>
</tr>
<tr>
<td align="right">个人签名：</td>
<td>
<?=setinput("textarea","content",$content,"",50,8)?><img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_sign.gif'>" style="cursor:pointer">支持UBB标签</td>
</tr>
<tr>
<th colspan=2 align="left">&nbsp;对话框信息设置</th>
</tr>
<tr>
<td align="right">在线提示标题：</td>
<td><?=setinput("textarea","onlinetitle",$onlinetitle,"",52,8)?><img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_tiptitle.gif'>" style="cursor:pointer" align="absmiddle"></td>
</tr>
<tr>
<td align="right">在线提示内容：</td>
<td><?=setinput("textarea","onlinetip",$onlinetip,"",52,8)?><img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_tipcontent.gif'>" style="cursor:pointer" align="absmiddle"></td>
</tr>
<tr>
<td align="right">不在线提示标题：</td>
<td><?=setinput("textarea","offlinetitle",$offlinetitle,"",52,8)?><img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_tiptitle.gif'>" style="cursor:pointer" align="absmiddle"></td>
</tr>
<tr>
<td align="right">不在线提示内容：</td>
<td><?=setinput("textarea","offlinetip",$offlinetip,"",52,8)?><img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_tipcontent.gif'>" style="cursor:pointer" align="absmiddle"></td>
</tr>
<tr>
<td align="right">关闭提示：</td>
<td><?=setinput("textarea","closetip",$closetip,"",52,8)?></td>
</tr>
<tr>
  <td align="right">启用收藏夹：</td>
  <td>
  <input type="radio" name="Favorite" value="1" <?if($Favorite==1)echo'checked'?>>开启
  <input type="radio" name="Favorite" value="0" <?if($Favorite==0)echo'checked'?>>关闭
  </td>
</tr>
<tr>
  <td align="right">收藏夹网址：</td>
  <td><?=setinput("text","FavoriteUrl",$FavoriteUrl,"",52,100)?>&nbsp;&nbsp;<font color=red>网址前必须加http://,如果不填写则禁用本功能！</font></td>
</tr>
<tr>
  <td align="right">网站名称：</td>
  <td><?=setinput("text","FavoriteName",$FavoriteName,"",52,100)?></td>
</tr>
<tr>
<th colspan=2 align="left">修改密码</th>
</tr>
<tr>
<td align="right">旧密码：</td>
<td><?=setinput("password","pass0","","",52,20)?> 不改请留空</td>
</tr>
<tr>
<td align="right">新密码：</td>
<td><?=setinput("password","pass1","","",52,20)?></td>
</tr>
<tr>
<td align="right">确认新密码：</td>
<td><?=setinput("password","pass2","","",52,20)?></td>
</tr>
<tr>
<td colspan=2 align="center"><?=setinput("submit","submit","保存修改")?></td>
</tr>
</table>
</form>
<script language="JavaScript">
function checkform(){
  if(myform.nickname.value==""){
    alert("昵称不能为空");
    myform.nickname.focus();
    return false;
  }
  if(myform.pass0.value!=""){
    if(myform.pass1.value==""){
      alert("新密码不能为空");
      myform.pass1.focus();
      return false;
    }
    if(myform.pass1.value!=myform.pass2.value){
      alert("新密码与确认密码不一致");
      myform.pass1.focus();
      return false;
    }
  }
  return true;
}
</script>
<?include("footer.php");?>