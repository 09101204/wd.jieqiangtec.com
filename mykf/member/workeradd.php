<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");
getdir("管理客服账号,?action=worker");
?>
<form name="myform" action="save.php?action=addworker" onsubmit="return checkform()" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;添加新客服</th>
</tr>
<tr>
<td width="20%" height="20" align="right">序号：</td>
<td width="80%"><?=setinput("text","taxis","0","",10,10)?> <span style="color:gray">指定客服显示顺序</span></td>
</tr>
<tr>
<td height="20" align="right">席位：</td>
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
<td height="20" align="right">是否显示：</td>
<td>
<?=setinput("radio","isshow","0")?>不显示<?=setinput("radio","isshow","1","checked")?>显示</td>
</tr>
<tr>
<td height="20" align="right">账号类型：</td>
<td>
  <input type="radio" id="sort1" name="sort" value="1" onclick="selsort(1)" checked>普通
  <input type="radio" id="sort2" name="sort" value="2" onclick="selsort(2)">QQ号码
</td>
</tr>
<tr id="common1" style="display:">
<td height="20" align="right">权限：</td>
<td><?=$G?></td>
</tr>
<tr>
<td height="20" align="right">管理界面风格：</td>
<td><select name="style"><?=$style_options?></select></td>
</tr>
<tr id="qq1" style="display:none">
<td height="20" align="right">QQ号码：</td>
<td><?=setinput("text","qq",$qq,"",30,30)?> <font color=red>*</font></td>
</tr>
<tr id="common2" style="display:">
<td height="20" align="right">登陆用户名：</td>
<td><?=setinput("text","username",$uname,"",30,30)?> <font color=red>*</font></td>
</tr>
<tr id="common3" style="display:">
<td height="20" align="right">登陆密码：</td>
<td><?=setinput("text","password",$pword,"",30,30)?></td>
</tr>
<tr>
<td height="20" align="right">显示昵称：</td>
<td><?=setinput("text","nickname",$nname,"",30,30)?></td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("submit","submit","立即添加")?></td>
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
      alert("登陆用户名不能为空");
      myform.username.focus();
      return false;
    }
    if(myform.password.value==""){
      alert("登陆密码不能为空");
      myform.password.focus();
      return false;
    }
  }else{
    if(myform.qq.value==""){
      alert("QQ号码不能为空");
      myform.qq.focus();
      return false;
    }
    if(isNaN(myform.qq.value)){
      alert("QQ号码只能为数字");
      myform.qq.focus();
      return false;
    }
  }
  if(myform.nickname.value==""){
    alert("显示昵称不能为空");
    myform.nickname.focus();
    return false;
  }
}
</script>
<?include("footer.php");?>