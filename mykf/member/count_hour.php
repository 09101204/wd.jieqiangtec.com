<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");?>
<img src="http://www.cnzz.com/stat/image_table.php?type=us_post&value_go=<?=$nums?>&<?=$time?>">
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="20%">ʱ��</th>
<th width="15%">�ܷ�����</th>
<th width="15%">���ʱ���</th>
<th width="50%">ͼ��</th>
</tr>
<?=$tmp?></table>
<?include("footer.php");?>