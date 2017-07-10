<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");
getdir("管理客服账号,?action=worker|添加新客服,?action=workeradd");
?>
<table width='90%' height=5><tr ><td></td></tr></table>
<form action="save.php" name="myform" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="9%">MQ</th>
<th width="10%">用户名</th>
<th width="12%">类型</th>
<th width="12%">席位</th>
<th width="12%">昵称</th>
<th width="12%">姓名</th>
<th width="18%">权限</th>
<th width="20%">操作</th>
</tr>
<?foreach($worker[0] as $rs){
if($cid==$username || ($cid!=$username && $rs["username"]!=$cid)){
$id=$rs["id"];
$taxis=$rs["taxis"];
$uname=$rs['online']>0 ? '<span style="font-weight:bold;color:green" title="在线">'.$rs['username'].'</span>' : '<span style="color:gray" title="离线">'.$rs['username'].'</span>';
$online=$rs["online"] ? "<font color=green><b>在线</b></font>" : "<font color=999999>不在线</font>" ;
$grade=$rs["grade"]=="all" ? "<font color=blue><b>超级客服</b></font>" : "<font color=000000>普通客服</font>" ;
$sor=is_numeric($rs["username"]) && $rs["password"]=='EQMKQQ' ? "<font color=#ff00ff>QQ号码</font>" : "<font color=blue>普通</font>";
if($cid==$rs["username"]){
  $G='<font color=blue><b>全部</b></font>';
  $icon='<img src="../images/membercp/admin.gif" alt="'.$G.'">管理员';
}else{
  $G=array();
  foreach(explode(',',$rs["grade"]) as $v){
    $G[]=$MyGrades[$v];
  }
  $G=implode(',',$G);
  $icon='<img src="../images/membercp/manager.gif" alt="'.$G.'">客服';
}
$del=$wid==$workerid ? "disabled" : NULL;
if(is_numeric($rs["sortid"])){
  $sort=$db->select("workersort","sort","companyid='$cid' and id=".$rs["sortid"]);
}
?><tr align="center">
<td height="20" style="color:red"><?=$rs["id"]+$MQStart?></td>
<td><?=$uname?></td>
<td><?=$sor?></td>
<td><?=$sort?></td>
<td><?=$rs["nickname"]?></td>
<td><?=$rs["realname"]?></td>
<td align="left"><?=$icon?></td>
<td>
  <a href="?action=pingfen&id=<?=$id?>">评分</a>
  <a href="?action=workeredit&id=<?=$id?>">编辑</a>
  <?if($username==$rs['username']){?>
  <font color="#999999">删除</font>
  <?}else{?>
  <a href="save.php?action=delworker&id=<?=$id?>" onClick="return confirm('您确定要删除该客服吗？')">删除</a>
  <?}?>
</td>
</tr>
<?}}?></table>
</form>
<?=$worker[1]?>
<?include("footer.php");?>