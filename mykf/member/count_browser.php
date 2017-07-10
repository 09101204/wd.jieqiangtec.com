<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");?>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="20%">浏览器类型</th>
<th width="15%">访问量</th>
<th width="15%">访问比率</th>
<th width="50%">图表</th>
</tr>
<?
if(is_array($count)){
foreach($count as $rs){
$count2=$rs[1];
$bl2=number_format($count2/$dayscount*100,2, '.', '');
?><tr align="center">
<td height="20"><?=$rs[0]?></td>
<td><font color="#0163d1"><font color="#ad1963"><?=$count2?></font></td>
<td><font color="#ad1963"><?=$bl2?>%</font></td>
<td align="left"><?if($bl2>0){?><img src="../images/membercp/sum_on.gif" width="<?=$length*$bl2/100?>" height="8"><?}?></td>
</tr>
<?}}?></table>
<?include("footer.php");?>