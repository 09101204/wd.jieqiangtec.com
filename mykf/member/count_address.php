<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");?>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="500" height="230" align="" viewastext>
      <param name="allowScriptAccess" value="sameDomain">
      <param name="FlashVars" value="&dataXML=<graph shownames='1' showvalues='0' decimalPrecision='0' pieRadius='150' numberPrefix='' formatNumber='1' formatNumberScale='0'  baseFont='宋体' baseFontSize='12' outCnvBaseFontSze='宋体' outCnvBaseFontSize='11'>
<?=$tmp?></graph>">
      <param name="movie" value="../images/membercp/round.swf?chartWidth=500&ChartHeight=230">
      <param name="quality" value="high">
  <param name="wmode" value="transparent">
      <embed src="../images/membercp/round.swf?chartWidth=500&ChartHeight=230" flashvars="&chartWidth=500&ChartHeight=300&dataXML=<graph shownames='1' showvalues='0' decimalPrecision='0' pieRadius='150' numberPrefix='' formatNumber='1' formatNumberScale='0'  baseFont='宋体' baseFontSize='12' outCnvBaseFontSze='宋体' outCnvBaseFontSize='11'>
<?=$tmp?></graph>" quality=high wmode="opaque" width="500" height="230" align="" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed></object>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="20%">访问者位置</th>
<th width="15%">访问量</th>
<th width="15%">访问比率</th>
<th width="50%">图表</th>
</tr>
<?
if(is_array($count)){
foreach($count as $rs){
$count2=$rs[1];
$bl2=number_format($count2/$dayscount*100,2, '.', '');
$prov=$rs[0] ? $Province[$rs[0]][1] : "未知地区";
?><tr align="center">
<td height="20"><?=$prov?></td>
<td><font color="#0163d1"><font color="#ad1963"><?=$count2?></font></td>
<td><font color="#ad1963"><?=$bl2?>%</font></td>
<td align="left"><?if($bl2>0){?><img src="../images/membercp/sum_on.gif" width="<?=$length*$bl2/100?>" height="8"><?}?></td>
</tr>
<?}}?></table>
<?include("footer.php");?>