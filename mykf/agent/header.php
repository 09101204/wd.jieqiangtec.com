<?php
$charset='gb2312';
function getdir($menu){
if(!$menu)return false;
$managemap="¹ÜÀíµ¼º½";
echo<<<EOT
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th align="left">&nbsp;$managemap</th>
</tr>
<tr>
<td align="center">
EOT;
$m1=split("\|",$menu);
for($i=0;$i<count($m1);$i++){
  $m2=split(",",$m1[$i]);
  echo"[<a href=\"".$m2[1]."\">".$m2[0]."</a>]¡¡";
}
echo<<<EOT
</td>
</tr>
</table>
<table border="0" cellspacing="0" align="center">
<tr>
<th height="15"> </th>
</tr>
</table>
EOT;
}
include("../template/admin/$adminstyle/top.htm");
?><script type="text/javascript" src="../include/javascript/common.js"></script>