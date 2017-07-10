<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<input type="button" value="备份当前数据库" onclick="location.href='save.php?action=sqlbak'" style="line-height:30px;height:30px;font-weight:bold"><br /><br />
<table width="720" border="0" cellspacing="1" cellpadding="0" class="list">
<tr align="center">
<th height="20">备份文件名称</th>
<th width="200">备份时间</th>
<th width="200">操作</th>
</tr>
<?foreach($sqlbaklist as $v){
$thetime=preg_replace("/([0-9]+)_([0-9]+)_([0-9]+)_([0-9]+)_([0-9]+)_([0-9]+)_(.+?)/iU","$1-$2-$3 $4:$5:$6",$v)?>
<tr align="center">
<td align="left" height="20"><a href="javascript:sqlbakre('<?=$v?>')"><?=$v?></a></td>
<td><?=$thetime?></td>
<td>
  <a href="javascript:sqlbakre('<?=$v?>')">还原数据库</a>
  <a href="javascript:delsqlbakfile('<?=$v?>')">删除备件文件</a>
</td>
</tr>
<?}?>
</table>
<script type="text/javascript">
function sqlbakre(file){
  if(confirm("您确定要还原备份文件“"+file+"”吗？\n此操作将删除现有数据，请慎重进行！")){
    location.href="save.php?action=sqlbakre&file="+file;
  }
}
function delsqlbakfile(file){
  if(confirm("您确定要删除备份文件“"+file+"”吗？")){
    window.location.href="save.php?action=delsqlbak&file="+file;
  }
}
</script>
<?include("footer.php");?>