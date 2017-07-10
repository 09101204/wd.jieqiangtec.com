<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<form name="myform" action="save.php?action=runsql" onsubmit="return checkform()" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;请输入SQL语句<?=ToHelp('runsql')?></th>
</tr>
<tr>
<td colspan=2><?=setinput("textarea","thesql","","",100,20)?></td>
</tr>
<tr>
<td width="40" height="20" align="right">密码：</td>
<td><?=setinput("password","pwd","","",50,100)?></td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("submit","submit","确定执行")?>
<font color="red"> 注:此操作有一定的风险，请慎重操作！</font>
</td>
</tr>
</table>
</form>
<?include("footer.php");?>