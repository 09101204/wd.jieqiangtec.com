<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");
getdir("管理客服账号,?action=worker|添加新客服,?action=workeradd");
?>
<form name="myform" action="save.php?action=editworker" onsubmit="return checkform()" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;修改客服资料</th>
</tr>
<tr>
<td width="20%" height="20" align="right">序号：</td>
<td width="80%"><?=setinput("text","taxis",$taxis,"",10,10)?> <span style="color:gray">指定客服显示顺序</span></td>
</tr>
<tr>
<td height="20" align="right">席位：</td>
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
<td height="20" align="right">是否显示：</td>
<td>
<?=setinput("radio","isshow","0",$s3)?>不显示
<?=setinput("radio","isshow","1",$s4)?>显示
</td>
</tr>
<tr>
<td height="20" align="right">账号类型：</td>
<td>
  <input type="radio" id="sort1" name="sort" value="1" onclick="selsort(1)" <?=$sort1?>>普通
  <input type="radio" id="sort2" name="sort" value="2" onclick="selsort(2)" <?=$sort2?>>QQ号码
</td>
</tr>
<tr id="common1" style="display:<?=$common?>">
<td height="20" align="right">权限：</td>
<td><?=$G?></td>
</tr>
<tr id="qq1" style="display:<?=$qq1?>">
<td height="20" align="right">QQ号码：</td>
<td><?=setinput("text","qq",$qq,"",30,30)?> <font color=red>*</font></td>
</tr>
<tr id="common2" style="display:<?=$common?>">
<td height="20" align="right">登陆用户名：</td>
<td><?=setinput("text","username",$uname,"",30,30)?> <font color=red>*</font></td>
</tr>
<tr id="common3" style="display:<?=$common?>">
<td height="20" align="right">登陆密码：</td>
<td><?=setinput("text","password","","",30,30)?> 不改请留空</td>
</tr>
<tr>
<td height="20" align="right">客服昵称：</td>
<td><?=setinput("text","nickname",$nickname,"",30,30)?> 
<?if(CheckGrade('super')){?>
<font color="blue">当前已开通<u>超级客服</u>功能，多个昵称请用<font color="red">,</font>分隔</font>
<?}?>
</td>
</tr>
<tr>
<td height="20" align="right">真实姓名：</td>
<td><?=setinput("text","realname",$realname,"",30,30)?>显示在客服端列表中</td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("hidden","id",$id)?><?=setinput("submit","submit","保存修改")?></td>
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
      if(!confirm("如果直接更改为QQ号码类型，原来的账号“"+myform.username.value+"”将被删除，是否继续？")){
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
      alert("登陆用户名不能为空");
      myform.username.focus();
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