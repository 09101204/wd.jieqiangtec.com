<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");
getdir("����ͷ��˺�,?action=worker|����¿ͷ�,?action=workeradd");
?>
<table width='90%' height=5><tr ><td></td></tr></table>
<form action="save.php" name="myform" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="9%">MQ</th>
<th width="10%">�û���</th>
<th width="12%">����</th>
<th width="12%">ϯλ</th>
<th width="12%">�ǳ�</th>
<th width="12%">����</th>
<th width="18%">Ȩ��</th>
<th width="20%">����</th>
</tr>
<?foreach($worker[0] as $rs){
if($cid==$username || ($cid!=$username && $rs["username"]!=$cid)){
$id=$rs["id"];
$taxis=$rs["taxis"];
$uname=$rs['online']>0 ? '<span style="font-weight:bold;color:green" title="����">'.$rs['username'].'</span>' : '<span style="color:gray" title="����">'.$rs['username'].'</span>';
$online=$rs["online"] ? "<font color=green><b>����</b></font>" : "<font color=999999>������</font>" ;
$grade=$rs["grade"]=="all" ? "<font color=blue><b>�����ͷ�</b></font>" : "<font color=000000>��ͨ�ͷ�</font>" ;
$sor=is_numeric($rs["username"]) && $rs["password"]=='EQMKQQ' ? "<font color=#ff00ff>QQ����</font>" : "<font color=blue>��ͨ</font>";
if($cid==$rs["username"]){
  $G='<font color=blue><b>ȫ��</b></font>';
  $icon='<img src="../images/membercp/admin.gif" alt="'.$G.'">����Ա';
}else{
  $G=array();
  foreach(explode(',',$rs["grade"]) as $v){
    $G[]=$MyGrades[$v];
  }
  $G=implode(',',$G);
  $icon='<img src="../images/membercp/manager.gif" alt="'.$G.'">�ͷ�';
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
  <a href="?action=pingfen&id=<?=$id?>">����</a>
  <a href="?action=workeredit&id=<?=$id?>">�༭</a>
  <?if($username==$rs['username']){?>
  <font color="#999999">ɾ��</font>
  <?}else{?>
  <a href="save.php?action=delworker&id=<?=$id?>" onClick="return confirm('��ȷ��Ҫɾ���ÿͷ���')">ɾ��</a>
  <?}?>
</td>
</tr>
<?}}?></table>
</form>
<?=$worker[1]?>
<?include("footer.php");?>