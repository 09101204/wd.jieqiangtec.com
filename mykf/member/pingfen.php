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
<th width="10%">访客编号</th>
<th width="30%">分数</th>
<th width="30%">访客IP</th>
<th width="30%">评分时间</th>
</tr>
<?foreach($P[0] as $rs){?>
<tr align="center">
<td height="20" style="color:red"><?=$rs["id"]?></td>
<td><?if($rs['fen']==0){
   	   	   $tt="非常满意";
   	   }elseif($rs['fen']==1){
   	   		$tt="较好";
   	   }elseif($rs['fen']==2){
   	   		$tt="一般";
   	   }elseif($rs['fen']==3){
   	   		$tt="较差";
   	   }elseif($rs['fen']==4){
   	   		$tt="<font color=red>恶劣</a>";
   	   }
   	   	   echo $tt;?></td>
<td><?=$rs["ip"]?></td>
<td><?=date('Y-m-d H:i:s',$rs["addtime"])?></td>
</tr>
<?}?></table>
</form>
<?=$P[1]?>
<?include("footer.php");?>