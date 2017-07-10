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
<td width="20%" height="20" align="right">城市：</td>
<td width="80%" style="color:red"> <?=$thecity?></td>
</tr>
<?if($ntype=='add'){?>
<tr>
<td height="20" align="right">登陆用户名：</td>
<td><?=setinput("text","uname",$uname,"",40,100)?></td>
</tr>
<tr>
<td height="20" align="right">登陆密码：</td>
<td><?=setinput("password","pword",$pword,"",40,100)?> <font color="#999999">默认为“<font color="red"><?=$pword?></font>”</font></td>
</tr>
<tr>
<td height="20" align="right">公司名称：</td>
<td><?=setinput("text","companyname",$companyname,"",40,100)?></td>
</tr>
<tr>
<td height="20" align="right">联系方式：</td>
<td><?=setinput("text","content",$content,"",40,100)?></td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("hidden","type","$type")?> 
<?=setinput("hidden","ntype","$ntype")?> 
<?=setinput("hidden","c","$city")?> 
<?=setinput("submit","submit","添加".$thecity."代理")?> 
<?=setinput("button","button","查看此区域所有客户","onclick=\"location.href='agent.php?action=company5&c=$city'\"")?> 
<?=setinput("button","button","返回上一页","onclick='history.go(-1)'")?>
</td>
</tr>
<?}else{?>
<tr>
<td height="20" align="right">登陆用户名：</td>
<td style="color:red"> <?=$uname?> <a href="javascript:if(confirm('您确定要删除此代理吗？'))location.href='save.php?action=agent_del&id=<?=$id?>'" style="color:#0000ff">删除此代理</a></td>
</tr>
<tr>
<td height="20" align="right">开通方式：</td>
<td style="color:red"> <?=$infotype?></td>
</tr>
<tr>
<td height="20" align="right">登陆密码：</td>
<td><?=setinput("password","pword","","",40,100)?> <font color="#999999">不改请留空</font></td>
</tr>
<tr>
<td height="20" align="right">公司名称：</td>
<td><?=setinput("text","companyname",$companyname,"",40,100)?></td>
</tr>
<tr>
<td height="20" align="right">联系方式：</td>
<td><?=setinput("text","content",$content,"",40,100)?></td>
</tr>
<tr>
<td height="20" align="right">余额：</td>
<td><font color="red"><?=$money?></font> 元</td>
</tr>
<tr>
<td height="20" align="right">消费额：</td>
<td><font color="red"><?=$paymoney?></font> 元</td>
</tr>
<tr>
<td height="20" align="right">转账余额：</td>
<td><?=setinput("text","money",0,"",5,5)?>元</td>
</tr>
<tr>
<td height="20" align="right">开通时间：</td>
<td><?=date('Y-m-d',$infotime)?></td>
</tr>
<tr>
<td height="20" align="right">过期时间：</td>
<td><?=date('Y-m-d',$exptime)?></td>
</tr>
<tr>
<td height="20" align="right">剩余天数：</td>
<td><?=setinput("text","days",$etime_,"",5,5)?>天</td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("hidden","id",$id)?>
<?=setinput("hidden","ntype","$ntype")?> 
<?=setinput("hidden","c","$city")?> 
<?=setinput("submit","submit","保存修改")?> 
<?=setinput("button","button","操作日志","onclick=\"location.href='agent.php?action=agent_log&agent=$uname'\"")?> 
<?=setinput("button","button","消费明细","onclick=\"location.href='agent.php?action=agent_money&agent=$uname'\"")?> 
<?=setinput("button","button","查看此区域所有客户","onclick=\"location.href='agent.php?action=company5&c=$city'\"")?> 
<?=setinput("button","button","返回上一页","onclick='history.go(-1)'")?>
</td>
</tr>
<?}?>
</table>
</form>
<script language="JavaScript">
function checkform(){
<?if($type=='add'){?>
  if(myform.uname.value.length<1){
    alert("登陆用户名不能为空");
    myform.uname.focus();
    return false;
  }
  if(myform.pword.value.length<1){
    alert("登陆密码不能为空");
    myform.pword.focus();
    return false;
  }
<?}?>
  if(myform.companyname.value.length<1){
    alert("公司名称不能为空");
    myform.companyname.focus();
    return false;
  }
  return true;
}
</script>
<?include("footer.php");?>