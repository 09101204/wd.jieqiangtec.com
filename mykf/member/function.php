<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");?>
<table width='100%' height=5><tr ><td>
<b>�ײ͹���</b>:�ͷ���ֵ�ײ͹���(<font color="red">ע����������ײͣ�ԭ���ײͽ��ᱻ�滻��ϵͳ�����˻�����ԭ���ײ���֧���Ľ��</font>)
</td></tr></table>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="150">�ײ�����</th>
<th width="80">�۸�</th>
<th>��������</th>
<th width="80">����</th>
</tr>
<?foreach($PackAge as $rs){?>
<tr align="center">
<td height="20"<?=$package==$rs['id']?'style="color:green;font-weight:bold"':''?>><?=$rs['title']?></td>
<td><font color="red"><?=$rs['price']?></font>Ԫ/<?=$rs['dayti']?></td>
<td align="left"><?=$rs['funcos']?></td>
<td>
<?if($package!=$rs['id'] && MyGrade('buy')){?><a href="?action=pay&type=buypackage&id=<?=$rs['id']?>" style="color:#0000ff">��ͨ</a><?}?>
<?if($package==$rs['id'] && MyGrade('pay')){?><a href="?action=pay&type=paypackage&id=<?=$rs['id']?>" style="color:#0000ff">����</a><?}?>
</td>
</tr>
<?}?>
</table>
<table width='100%' height=5><tr ><td>
<b>��������</b>:���пͷ������б�
</td></tr></table>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="150">��������</th>
<th width="80">�۸�</th>
<th width="100">��ͨʱ��</th>
<th width="100">����ʱ��</th>
<th>��ע</th>
<th width="80">����</th>
</tr>
<?foreach($F as $rs){?><tr align="center">
<td height="20" title="<?=$rs[2]?>"><?=$rs[1]?></td>
<td><?=$rs[3]?></td>
<td><?=$rs[5]?></td>
<td><?=$rs[6]?></td>
<td><?=$rs[4]?></td>
<td>
<?if($rs[5]=='---' && MyGrade('buy')){?><a href="?action=pay&type=reg&keyname=<?=$rs[0]?>" style="color:#0000ff">��ͨ</a><?}?>
<?if($rs[5]!='---' && MyGrade('add')){?>
<?if($rs[7]!=0){?>
<a href="?action=pay&type=paypackage&id=<?=$rs[7]?>" style="color:#0000ff">����</a>
<?}else{?>
<a href="?action=pay&type=add&keyname=<?=$rs[0]?>" style="color:#0000ff">����</a>
<?}}?>
</td>
</tr>
<?}?>
</table>
</form>
<?include("footer.php");?>