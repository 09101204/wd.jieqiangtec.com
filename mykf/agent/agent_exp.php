<?php
if(!defined('IN_EQMK') || !defined('IN_AGENT')) {
	exit('Access Denied');
}
include("header.php");?>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="100">����</th>
<th width="100">������</th>
<th width="100">��ϵ��ʽ</th>
<th width="80">����ʱ��</th>
<th width="80">״̬</th>
<th width="100">����</th>
</tr>
<?foreach($expagent[0] as $rs){?>
<tr align="center">
<td height="20"><?=$rs['city']?></td>
<td><?=$rs['company']?></td>
<td><?=$rs['content']?></td>
<td><?=date('Y-m-d',$rs['exptime'])?></td>
<td><?=$rs['exptime']<$mytime ? '<font color="#ff0000">�ѹ���</font>':'<font color="orange">��������</font>'?></td>
<td align="center">
  <a href="?action=agent_set&c=<?=$rs['city']?>" style="color:blue">����</a>
</td>
</tr>
<?}?>
</table>
<?=$expagent[1]?>
<?include("footer.php");?>