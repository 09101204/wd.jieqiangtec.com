<?
include_once("../include/common.inc.php");
$action=Char_Cv('action','get');
$cid=Char_Cv('cid','get');
$wid=Char_Cv('wid','get');
$uid=Char_Cv('uid','get');
if(!$cid || !$wid){
  //header("location:../");
}
if($action=='listw'){
  $onez=$db->page("worker","id,nickname","companyid='$cid' and id<>'$wid' order by id asc",50,"&action=$action&cid=$cid&wid=$wid&uid=$uid");
  $where=' &raquo; <a href="?action=listw&cid='.$cid.'&wid='.$wid.'">同企业客服</a>';
}elseif($action=='listu'){
  $onez=$db->page("history","clientid","companyid='$cid' and workerid='$wid' and (action='1' or action='2') group by clientid",50,"&action=$action&cid=$cid&wid=$wid&uid=$uid");
  $where=' &raquo; <a href="?action=listu&cid='.$cid.'&wid='.$wid.'">交谈过的访客</a>';
}elseif($action=='w'){
  $onez=$db->page("history","workerid,clientid,addtime,action,content","companyid='$cid' and ((workerid='$uid'and clientid='$wid') or (workerid='$wid'and clientid='$uid')) and action='3' order by id asc",20,"&action=$action&cid=$cid&wid=$wid&uid=$uid#bottom");
  $C=$db->record("worker","realname,nickname","companyid='$cid' and id=".intval($uid));
  $C=$C[0];
  //$wnickname=$db->select("worker","nickname","companyid='$cid' and id=$wid");
  $wnickname='您';
  if(!$cnickname)$cnickname=$C['nickname'];
  $where=' &raquo; <a href="?action=listw&cid='.$cid.'&wid='.$wid.'">同企业客服</a> &raquo; <a href="?action=u&cid='.$cid.'&wid='.$wid.'&uid='.$uid.'">'.$cnickname.'</a>';

}elseif($action=='u'){
  $onez=$db->page("history","workerid,clientid,addtime,action,content","companyid='$cid' and workerid='$wid' and clientid='$uid' and (action='1' or action='2') order by id asc",20,"&action=$action&cid=$cid&wid=$wid&uid=$uid#bottom");
  $C=$db->record("client","id,ip,address","companyid='$cid' and id=".intval($uid));
  $C=$C[0];
  //$wnickname=$db->select("worker","nickname","companyid='$cid' and id=$wid");
  $wnickname='您';
  if(!$cnickname)$cnickname='访客'.$uid;
  $where=' &raquo; <a href="?action=listu&cid='.$cid.'&wid='.$wid.'">交谈过的访客</a> &raquo; <a href="?action=u&cid='.$cid.'&wid='.$wid.'&uid='.$uid.'">'.$cnickname.'</a>';
}
?>
<html>
<title>访客恰谈记录</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="images/dialog.css">
<body LEFTMARGIN="0" TOPMARGIN="2" scroll="no" oncontextmenu=self.event.returnValue=false onselectstart="return false">
<style type="text/css">
a{text-decoration:none;color:#666666}
div{font-size:12px;}
td{padding:10px}
th,td{font-size: 12px; font-family: "宋体";height:20px;font-weight:normal}
.list li{margin:3px;float:left;
	font: 12px Arial, Helvetica, sans-serif;
	padding: 0 6px;
	color: #000000;
	background: #bedeff url(bg_button.gif) repeat-x;

	border: 1px solid #296C89 ;
	height: 24px;
	line-height: 20px;}
.list li a{color:#000000}
</style>
<table border="0" cellspacing="1" align="center" width="99%" bgcolor="#cedbeb">
<?if($action!=''){?>
<tr bgcolor="#f4f9ff">
<th height="20" align="left">位置：<a href="?cid=<?=$cid?>&wid=<?=$wid?>">恰谈记录</a><?=$where?></th>
</tr>
<?}?>
<?if($action=='listw'){?>
<tr bgcolor="#ffffff">
<td>
<?if($onez[2]==0){?>没有找到与您交谈过的客服<?}?>
<ul class="list">
<?foreach($onez[0] as $rs){?>
<li><a href="?action=w&cid=<?=$cid?>&wid=<?=$wid?>&uid=<?=$rs['id']?>&page=99999#"><?=$rs['nickname']?></a></li>
<?}?>
</ul>
</td>
</tr>
<?}elseif($action=='listu'){?>
<tr bgcolor="#ffffff">
<td>
<?if($onez[2]==0){?>没有找到与您交谈过的访客<?}?>
<ul class="list">
<?foreach($onez[0] as $rs){?>
<li><a href="?action=u&cid=<?=$cid?>&wid=<?=$wid?>&uid=<?=$rs['clientid']?>&page=99999#"><?=$rs['clientid']?></a></li>
<?}?>
</ul>
</td>
</tr>
<?}elseif($action=='w'){?>
<tr bgcolor="#ffffff">
<td>
<?foreach($onez[0] as $rs){?>
<?if($rs['clientid']==$wid){?>
<div class="im_to"><?=$wnickname?> <?=$rs['addtime']?></div>
<?}else{?>
<div class="im_from"><?=$cnickname?> <?=$rs['addtime']?></div>
<?}?>
<div class="im_content"><?=$rs['content']?></div>
<?}?>
</td>
</tr>
<?}elseif($action=='u'){?>
<tr bgcolor="#ffffff">
<td>
<?foreach($onez[0] as $rs){?>
<?if($rs['action']==1){?>
<div class="im_to"><?=$wnickname?> <?=$rs['addtime']?></div>
<?}else{?>
<div class="im_from"><?=$cnickname?> <?=$rs['addtime']?></div>
<?}?>
<div class="im_content"><?=$rs['content']?></div>
<?}?>
</td>
</tr>
<?}else{?>
<tr bgcolor="#ffffff">
<td align="center">
<h1>请选择用户类型<br /><br /><a href="?action=listw&cid=<?=$cid?>&wid=<?=$wid?>">客服</a>、<a href="?action=listu&cid=<?=$cid?>&wid=<?=$wid?>">访客</a></h1></td>
</tr>
<?}?>
<?if($action=='w'||$action=='u'){?>
<tr bgcolor="#f4f9ff">
<th height="20" align="left">位置：<a href="?cid=<?=$cid?>&wid=<?=$wid?>">恰谈记录</a><?=$where?></th>
</tr>
<?}?>
</table>
<?=$onez[1]?>
<a name="bottom"></a>
</body>
</html>