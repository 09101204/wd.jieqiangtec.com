<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}?>
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th align="left" colspan=2>&nbsp;�ۺ�ͳ��</th>
</tr>
<tr>
<td height="20" colspan="2">������ͳ��ʱ��: <font color="red"><?=date('Y-m-d H:i:s',$firsttime)?></font></td>
</tr>
<tr>
<td height="20" colspan="2">��ͳ������:  <font color="red"><?=$days?></font></td>
</tr>
<tr>
<td width="50%" height="20">�������¿ͻ���: <font color="red"><?=$newuser?></font></td>
<td width="50%">�������Ͽͻ���: <font color="red"><?=$olduser?></font></td>
</tr>
<tr>
<td height="20" colspan="2">����������: <font color="red"><?=$online?></font></td>
</tr>
<tr>
<td height="20">�����շ�����: <font color="red"><?=$thisday?></font></td>
<td>�����շ�����: <font color="red"><?=$lastday?></font></td>
</tr>
<tr>
<td height="20">�����ܷ�����: <font color="red"><?=$thisweek?></font></td>
<td>�����ܷ�����: <font color="red"><?=$lastweek?></font></td>
</tr>
<tr>
<td height="20">�����·�����: <font color="red"><?=$thismonth?></font></td>
<td>�����·�����: <font color="red"><?=$lastmonth?></font></td>
</tr>
<tr>
<td height="20" colspan="2">��ƽ���շ�����: <font color="red"><?=$avgday?></font></td>
</tr>
<tr>
<td height="20" colspan="2">��ƽ���ܷ�����: <font color="red"><?=$avgweek?></font></td>
</tr>
<tr>
<td height="20" colspan="2">��ƽ���·�����: <font color="red"><?=$avgmonth?></font></td>
</tr>
<tr>
<td height="20" colspan="2">���ܷ�����: <font color="red"><?=$totalcount?></font></td>
</tr>
</table>
<?include("footer.php");?>