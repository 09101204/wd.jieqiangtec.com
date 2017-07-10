<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<td style="background:#EEEEEE"><?=implode('<br>',$table)?></td>
</tr>
</table>
<?include("footer.php");?>