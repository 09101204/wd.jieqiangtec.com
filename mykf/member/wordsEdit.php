<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");
?>
<form name="myform" action="save.php?action=<?=$action?>" method="post" onsubmit="return checkform()">
<table border="0" cellspacing="1" cellpadding="0" class="list">
<tr>
  <td width="120" height="45" align="right">Ӧ�÷�Χ��</td>
  <td>
    <?=setinput("radio","ntype","0",$ntype!=1?' checked':'')?>�ṩ�����пͷ�
    <?=setinput("radio","ntype","1",$ntype==1?' checked':'')?>�����Լ�
  </td>
</tr>
<tr>
  <td height="20" align="right">��������ࣺ</td>
  <td><select name="selsort" onchange="setsort(this.options[this.selectedIndex].value)">
  <option value="">�Զ�������</option>
  <?foreach($Sort as $rs){?>
  <option value="<?=$rs['sort']?>"<?=$rs['sort']==$sort?' selected':''?>><?=$rs['sort']?></option>
  <?}?>
  </select>
  <?=setinput("text","sort",$sort,$sort?' style="display:none"':'',20,50)?>
  </td>
</tr>
<tr>
  <td height="20" align="right">���������ݣ�</td>
  <td><?=setinput("textarea","words",$words,'',50,5)?></td>
</tr>
<tr>
  <td height="20" align="right"></td>
  <td>
    <?=setinput("hidden","id",$id)?>
    <?=setinput("submit","submit",$btnname)?>
  </td>
</tr>
</table>
</form>
<script type="text/javascript">
function setsort(v){
  if(v.length<1){
    $('sort').style.display='';
  }else{
    $('sort').style.display='none';
    $('sort').value=v;
  }
}
function checkform(){
  if(myform.sort.value.length<1){
    alert('��ѡ�������µĳ��������');
    myform.sort.focus();
    return false;
  }
  if(myform.words.value.length<1){
    alert('����д����������');
    myform.words.focus();
    return false;
  }
  return true;
}
</script>
<?include("footer.php");?>