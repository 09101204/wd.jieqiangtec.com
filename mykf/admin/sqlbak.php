<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<input type="button" value="���ݵ�ǰ���ݿ�" onclick="location.href='save.php?action=sqlbak'" style="line-height:30px;height:30px;font-weight:bold"><br /><br />
<table width="720" border="0" cellspacing="1" cellpadding="0" class="list">
<tr align="center">
<th height="20">�����ļ�����</th>
<th width="200">����ʱ��</th>
<th width="200">����</th>
</tr>
<?foreach($sqlbaklist as $v){
$thetime=preg_replace("/([0-9]+)_([0-9]+)_([0-9]+)_([0-9]+)_([0-9]+)_([0-9]+)_(.+?)/iU","$1-$2-$3 $4:$5:$6",$v)?>
<tr align="center">
<td align="left" height="20"><a href="javascript:sqlbakre('<?=$v?>')"><?=$v?></a></td>
<td><?=$thetime?></td>
<td>
  <a href="javascript:sqlbakre('<?=$v?>')">��ԭ���ݿ�</a>
  <a href="javascript:delsqlbakfile('<?=$v?>')">ɾ�������ļ�</a>
</td>
</tr>
<?}?>
</table>
<script type="text/javascript">
function sqlbakre(file){
  if(confirm("��ȷ��Ҫ��ԭ�����ļ���"+file+"����\n�˲�����ɾ���������ݣ������ؽ��У�")){
    location.href="save.php?action=sqlbakre&file="+file;
  }
}
function delsqlbakfile(file){
  if(confirm("��ȷ��Ҫɾ�������ļ���"+file+"����")){
    window.location.href="save.php?action=delsqlbak&file="+file;
  }
}
</script>
<?include("footer.php");?>