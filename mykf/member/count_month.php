<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");?>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="20%">时间</th>
<th width="15%">总访问量</th>
<th width="15%">访问比率</th>
<th width="50%">图表</th>
</tr>
<?
for($i=1;$i<=12;$i++){
$k=GetId($i,2);
$T1=GetTime("$Y-$k-01");
$T2=$i==12 ? GetTime(($Y+1)."-01-01") : GetTime("$Y-".GetId($i+1,2)."-01");;
$count2=$db->rows("client","companyid='$cid' and addtime>=$T1 and addtime<$T2");
$bl2=number_format($count2/$dayscount*100,2, '.', '');
?><tr align="center">
<td height="20"><a href="member.php?action=count_day&m=<?="$Y-$k"?>"><?=$k?>月</a></td>
<td><font color="#0163d1"><font color="#ad1963"><?=$count2?></font></td>
<td><font color="#ad1963"><?=$bl2?>%</font></td>
<td align="left"><?if($bl2>0){?><img src="../images/membercp/sum_on.gif" width="<?=$length*$bl2/100?>" height="8"><?}?></td>
</tr>
<?}?></table>
<?include("footer.php");?>