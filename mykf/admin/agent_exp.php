<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="100">省市</th>
<th width="100">代理商</th>
<th width="100">联系方式</th>
<th width="80">过期时间</th>
<th width="80">状态</th>
<th width="100">操作</th>
</tr>
<?foreach($expagent[0] as $rs){?>
<tr align="center">
<td height="20"><?=$rs['prov']?><?=$rs['city']?></td>
<td><?=$rs['company']?></td>
<td><?=$rs['content']?></td>
<td><?=date('Y-m-d',$rs['exptime'])?></td>
<td><?=$rs['exptime']<$mytime ? '<font color="#ff0000">已过期</font>':'<font color="orange">即将过期</font>'?></td>
<td align="center">
  <a href="<?=$rs['ntype']=='prov' ? '?action=agent_set&type=prov&prov='.$rs['prov'] : '?action=agent_set&type=city&prov='.$rs['prov'].'&city='.$rs['city']?>" style="color:blue">设置</a>
</td>
</tr>
<?}?>
</table>
<?=$expagent[1]?>
<?include("footer.php");?>