<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");?>
<script type="text/javascript">
function ToServer(){
  window.open("<?=$homepage?>service","Dialog","toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=700,height=472");
}
</script>
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th align="left" colspan=2>&nbsp;友情提示</th>
</tr>
<tr>
<td height="20" colspan="2" style="line-height:20px">
<?if(is_dir('../service')){?><div style="float:right;margin:20px;cursor:pointer"><img src="../images/membercp/right_toserver.gif" onclick="ToServer()"></div><?}?>
  <a href="?action=help#skin1" title="<img src='../images/membercp/help_demo1.jpg' width='300'>" style="color:blue;text-decoration:none">对话框界面图示</a> 、
  <a href="?action=help#skin2" title="<img src='../images/membercp/help_demo2.jpg' width='300'>" style="color:blue;text-decoration:none">邀请框界面图示</a> 、
  <a href="?action=pay&type=pay" style="color:blue;text-decoration:none">账户充值</a><?if(!CheckGrade('allworker') && MyGrade('buy')){?> 、
  <a href="?action=pay&type=buysort" style="color:blue;text-decoration:none">增加席位数</a> 、
  <a href="?action=pay&type=buyworker" style="color:blue;text-decoration:none">增加客服数</a><?}?>
  <?=$tips?>
</td>
</tr>
</table>
<br />
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th align="left" colspan=2>&nbsp;登陆信息</th>
</tr>
<tr>
<td height="20" colspan="2">　您好,<span style="font-weight:bold;color:#ff0000"><?=$username?></span>　　MQ:<span style="font-weight:bold;color:#0000ff;text-decoration:underline"><?=$MQ?></span> <?=ToHelp('MQ')?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;管理界面风格
<select id="adminstyle"><?=$style_options?></select>
<?=setinput("button","button","应用","onclick=\"location.href='save.php?action=setstyle&curstyle='+$('adminstyle').options.value\"")?></td>
</tr>
<tr>
<td height="20" colspan="2">　这是您第<font color=red><?=$logincount?></font>次登陆本系统</td>
</tr>
<tr>
<td height="20">　上次登陆时间:<font color=009933><?=$lasttime?></font></td>
<td width="1" rowspan="4"></td>
</tr>
<tr>
<td height="20">　上次IP地址:<font color=009933><?=$lastip?></font> <?=$lastaddress?></td>
</tr>
<tr>
<td height="20">　本次登陆时间:<font color=009933><?=$thistime?></font></td>
</tr>
<tr>
<td height="20">　本次IP地址:<font color=009933><?=$thisip?></font> <?=$thisaddress?></td>
</tr>
<tr>
<th align="left" colspan=2>&nbsp;数据概况</th>
</tr>
<tr>
<td height="20" colspan="2">　
代理商:<font color="#ff0000"><?=$ag?></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td>
</tr>
<tr>
<td height="20" colspan="2">　
开通时间:<font color=gray><?=$infotime?></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
过期时间:<font color=gray><?=$exptime?></font> <?if(MyGrade('exptimes')){?>-><a href="?action=pay&type=exptimes" style="color:blue">展期</a><?}?>
</td>
</tr>
<tr>
<td height="20" colspan="2">　
余额:<font color=red><?=$money?></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
消费额:<font color=red><?=$paymoney?></font>
</td>
</tr>
<tr>
<td height="20" colspan="2">　<?if(CheckGrade('allworker')){?>
<font color=red>您已开通无限客服功能，座席不受限制，咨询量不受限制</font>
<?}else{?>
最大席位数:<font color=red><?=$sortcount?></font> <?if(MyGrade('buy')){?><a href="?action=pay&type=buysort" style="color:blue">增加</a><?}?>&nbsp;&nbsp;&nbsp;&nbsp;
最大客服数:<font color=red><?=$workercount?></font> <?if(MyGrade('buy')){?><a href="?action=pay&type=buyworker" style="color:blue">增加</a><?}?>
<?}?>
</td>
</tr>
<tr>
<td height="20" colspan="2">　
已用席位数:<font color=red><?=$count1?></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
已用客服数:<font color=red><?=$count2?></font>
</td>
</tr>
<tr>
<td height="20" colspan="2">　
在线客服:<font color=red><?=$count3?></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
在线访客:<font color=red><?=$count4?></font>
</td>
</tr>
<!--
<tr>
<th align="left" colspan=2>&nbsp;业绩推广</th>
</tr>
<tr>
<td height="20" colspan="2">　
推广编号:<font color="#ff0000"><?=$cid?></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td>
</tr>
<tr>
<td height="20" colspan="2">　
推广客户数:<font color="#ff0000"><?=$usercount1?></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
有效客户数:<font color="#ff0000"><?=$usercount2?></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
总收入:<font color="#ff0000"><?=$usermoney?></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td>
</tr>
-->
</table>
<?include("footer.php");?>