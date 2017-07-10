<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}?>
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th align="left" colspan=2>&nbsp;综合统计</th>
</tr>
<tr>
<td height="20" colspan="2">　最早统计时间: <font color="red"><?=date('Y-m-d H:i:s',$firsttime)?></font></td>
</tr>
<tr>
<td height="20" colspan="2">　统计天数:  <font color="red"><?=$days?></font></td>
</tr>
<tr>
<td width="50%" height="20">　今日新客户量: <font color="red"><?=$newuser?></font></td>
<td width="50%">　今日老客户量: <font color="red"><?=$olduser?></font></td>
</tr>
<tr>
<td height="20" colspan="2">　在线人数: <font color="red"><?=$online?></font></td>
</tr>
<tr>
<td height="20">　今日访问量: <font color="red"><?=$thisday?></font></td>
<td>　昨日访问量: <font color="red"><?=$lastday?></font></td>
</tr>
<tr>
<td height="20">　本周访问量: <font color="red"><?=$thisweek?></font></td>
<td>　上周访问量: <font color="red"><?=$lastweek?></font></td>
</tr>
<tr>
<td height="20">　本月访问量: <font color="red"><?=$thismonth?></font></td>
<td>　上月访问量: <font color="red"><?=$lastmonth?></font></td>
</tr>
<tr>
<td height="20" colspan="2">　平均日访问量: <font color="red"><?=$avgday?></font></td>
</tr>
<tr>
<td height="20" colspan="2">　平均周访问量: <font color="red"><?=$avgweek?></font></td>
</tr>
<tr>
<td height="20" colspan="2">　平均月访问量: <font color="red"><?=$avgmonth?></font></td>
</tr>
<tr>
<td height="20" colspan="2">　总访问量: <font color="red"><?=$totalcount?></font></td>
</tr>
</table>
<?include("footer.php");?>