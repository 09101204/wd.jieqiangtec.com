<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<style type="text/css">
.pay_have {color:#009900;font-weight:bold;font-family:"Arial";}
</style>
<form name="myform" action="save.php?action=editcompany" onsubmit="return checkform()" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;<?=$title?><?=ToHelp('company')?></th>
</tr>
<tr>
<td width="20%" height="20" align="right">��ҵ�˺ţ�</td>
<td width="80%" style="color:red"> <?=$companyid?></td>
</tr>
<tr>
<td height="20" align="right">��ҵ���ƣ�</td>
<td><?=setinput("text","company",$company,"",50,100)?></td>
</tr>
<tr>
<td height="20" align="right">�����̣�</td>
<td><font color="red"><?=$ag?></font></td>
</tr>
<tr>
<td height="20" align="right">��</td>
<td><font color="red"><?=$money?></font> Ԫ</td>
</tr>
<tr>
<td height="20" align="right">���Ѷ</td>
<td><font color="red"><?=$paymoney?></font> Ԫ</td>
</tr>
<tr>
<td height="20" align="right">��ֵ��</td>
<td><?=setinput("text","money",0,"",5,5)?>Ԫ <font color="#999999">�۳���������븺��</font></td>
</tr>
<tr>
<td height="20" align="right">ע��ʱ�䣺</td>
<td><?=date('Y-m-d',$infotime)?></td>
</tr>
<tr>
<td height="20" align="right">����λ�ã�</td>
<td><?=getaddress($infoip,true)?>(<?=$infoip?>)</td>
</tr>
<tr>
<td height="20" align="right">����ʱ�䣺</td>
<td><?=date('Y-m-d',$exptime)?></td>
</tr>
<tr>
<td height="20" align="right">ʣ��������</td>
<td><?=setinput("text","days",$etime_,"",5,5)?>��</td>
</tr>
<tr>
<td height="20" align="right">�ͷ��б�</td>
<td style="line-height:15px;padding:5px 0px 5px 5px" valign="top"><?foreach($wsort as $rs){
print($rs['sort'].'<br />');
$w=$db->record("worker","id,mq,username,nickname,isshow","companyid='$companyid' and sortid=".$rs['id']." order by taxis asc");
foreach($w as $r){
print('<font color="#999999">'.($r==end($w)?'&nbsp;&nbsp;��-':'&nbsp;&nbsp;��-').'</font>'.$r['nickname'].'('.$r['username'].')'.($r['isshow']==1 ? ($r['mq'] ? '<a href="../kf.php?mod=client&mq='.$r['mq'].'" target="Dialog'.$r['id'].'"><img src="../images/admincp/icon_msg.gif" border="0" align="absmiddle"></a>':'') : ' <font color="#999999">[����ʾ]</font>').'<br />');
}
}?></td>
</tr>
<tr>
<td height="30" align="right" style="color:blue">�ײͣ�</td>
<td>
    <select name="package">
    <option value="0">��ͨ�û�</option>
    <?foreach($Package as $rs){
    $s=$rs['id']==$package?' selected':'';?>
    <option value="<?=$rs['id']?>"<?=$s?>><?=$rs['title']?></option>
    <?}?></select>
</td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("hidden","id",$id)?>
<?=setinput("submit","submit","�����޸�")?> 
<?=setinput("button","button","�鿴������ϸ","onclick=\"location.href='admin.php?action=company_money&cid=$companyid'\"")?> 
<?=setinput("button","button","�鿴������־","onclick=\"location.href='admin.php?action=company_log&cid=$companyid'\"")?> 
<?=setinput("button","button","������һҳ","onclick=\"history.go(-1)\"")?>
</td>
</tr>
</table>
</form>
<script language="JavaScript">
function checkform(){
  if(myform.money.value.length<1 || isNaN(myform.money.value)){
    alert("��ֵ������Ϊ����");
    myform.money.focus();
    return false;
  }
  if(myform.days.value.length<1 || isNaN(myform.days.value) || myform.days.value.indexOf('.')!=-1){
    alert("ʣ����������Ϊ����");
    myform.days.focus();
    return false;
  }
  <?if($ag!='��'){?>
  return confirm("�ÿͻ����������Ѵ��ڴ����̣�ȷ��Ҫ�������в�����");
  <?}?>
  return true;
}
</script>
<br />
<form name="myform2" action="save.php?action=editcompany2" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="70%">��������</th>
<th width="30%">���ô˹���</th>
</tr>
<?foreach($funs as $rs){
$keyname=$rs["keyname"];
$s=in_array($keyname,$myfuns)?'checked':'';
?>
<tr align="center">
<td height="20" align="left">[
<?if($rs["price"]>0){?>
<span style="color:blue">�߼�</span>
<?}else{?>
<span style="color:#ff6600">��ͨ</span>
<?}?>
]<?=$rs['title']?></td>
<td>
<?if($rs["price"]>0){?>
<?if($package>0 && in_array($keyname,$myfuns2)){?>
<span class="pay_have">��</span>
<?}else{?>
<input type="hidden" name="A[<?=$keyname?>]" value="1">
<input type="checkbox" name="used[<?=$keyname?>]" <?=$s?> value="1">
<?}?>
<?}else{?>
<span class="pay_have">��</span>
<?}?>
</td>
</tr>
<?}?>
</table><br/>
<input type="hidden" name="companyid" value="<?=$companyid?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="submit" name="submit" value=" �����޸� ">
</form>
<?include("footer.php");?>