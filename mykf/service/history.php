<?
include_once 'check.php';
$uid=Char_Cv('uid','get');
if(!$cid || !$wid || !$uid){
  header("location:../");
}
$C=$db->record("client","id,ip,address","companyid='$cid' and id=".intval($uid));
$C=$C[0];
$wnickname=$db->select("worker","nickname","companyid='$cid' and id=$wid");
?>
<html>
<title><?=$language['046']?></title>
<META http-equiv="Content-Type" content="text/html; charset=<?=$webcharset?>">
<link rel="stylesheet" type="text/css" href="images/dialog.css">
<body>
<style type="text/css">
div{font-size:12px;}
td{padding:2px}
th,td{font-size: 12px; font-family: "<?=$language['047']?>";height:20px;font-weight:normal}
</style>
<table border="0" cellspacing="1" align="center" width="99%" bgcolor="#cedbeb">
<tr bgcolor="#f4f9ff">
<th height="20">
<?=$language['006']?><font color="red"><?=$uid?></font> &raquo; 
<?=$language['009']?><font color="red"><?=$C['ip']?></font> &raquo; 
<?=$language['034']?><font color="red"><?=$C['address']?></font>
<?$onez=$db->page("history","workerid,clientid,addtime,action,content","companyid='$cid' and workerid='$wid' and clientid='$uid' and (action='1' or action='2') order by id asc",20,"&cid=$cid&wid=$wid&uid=$uid");?>
</th>
</tr>
<tr bgcolor="#ffffff">
<td>
<?foreach($onez[0] as $rs){?>
<?if($rs['action']==1){?>
<div class="im_to"><?=$wnickname?> <?=$rs['addtime']?></div>
<?}else{?>
<div class="im_from"><?=$uid?> <?=$rs['addtime']?></div>
<?}?>
<div class="im_content"><?=$rs['content']?></div>
<?}?>
</td>
</tr>
</table>
<?=$onez[1]?>
</body>
</html>