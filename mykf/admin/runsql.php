<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<form name="myform" action="save.php?action=runsql" onsubmit="return checkform()" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;������SQL���<?=ToHelp('runsql')?></th>
</tr>
<tr>
<td colspan=2><?=setinput("textarea","thesql","","",100,20)?></td>
</tr>
<tr>
<td width="40" height="20" align="right">���룺</td>
<td><?=setinput("password","pwd","","",50,100)?></td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("submit","submit","ȷ��ִ��")?>
<font color="red"> ע:�˲�����һ���ķ��գ������ز�����</font>
</td>
</tr>
</table>
</form>
<?include("footer.php");?>