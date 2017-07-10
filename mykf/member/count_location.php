<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");?>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="40%">受访页面</th>
<th width="15%">访问量</th>
<th width="15%">访问比率</th>
<th width="30%">图表</th>
</tr>
<?
if(is_array($count)){
foreach($count as $rs){
$count2=$rs[1];
$bl2=number_format($count2/$dayscount*100,2, '.', '');
$title=strlen($rs[0])>40 ? substr($rs[0],0,40).'...' : $rs[0];
?><tr align="center">
<td align="left" height="20" title="<?=$rs[0]?>"><a href="<?=$rs[0]?>" target="_blank"><?=$title?></a></td>
<td><font color="#0163d1"><font color="#ad1963"><?=$count2?></font></td>
<td><font color="#ad1963"><?=$bl2?>%</font></td>
<td align="left"><?if($bl2>0){?><img src="../images/membercp/sum_on.gif" width="<?=$length*$bl2/100?>" height="8"><?}?></td>
</tr>
<?}}?></table>
<?include("footer.php");?>