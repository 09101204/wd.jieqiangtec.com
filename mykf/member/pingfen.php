<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");
?>
<table width='90%' height=5><tr ><td></td></tr></table>
<form action="save.php" name="myform" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="10%">�ÿͱ��</th>
<th width="30%">����</th>
<th width="30%">�ÿ�IP</th>
<th width="30%">����ʱ��</th>
</tr>
<?foreach($P[0] as $rs){?>
<tr align="center">
<td height="20" style="color:red"><?=$rs["id"]?></td>
<td><?if($rs['fen']==0){
   	   	   $tt="�ǳ�����";
   	   }elseif($rs['fen']==1){
   	   		$tt="�Ϻ�";
   	   }elseif($rs['fen']==2){
   	   		$tt="һ��";
   	   }elseif($rs['fen']==3){
   	   		$tt="�ϲ�";
   	   }elseif($rs['fen']==4){
   	   		$tt="<font color=red>����</a>";
   	   }
   	   	   echo $tt;?></td>
<td><?=$rs["ip"]?></td>
<td><?=date('Y-m-d H:i:s',$rs["addtime"])?></td>
</tr>
<?}?></table>
</form>
<?=$P[1]?>
<?include("footer.php");?>