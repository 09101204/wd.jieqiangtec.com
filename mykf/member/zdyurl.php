<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");?>
<Script language="JavaScript">   
 function openfile()   
  {   
  var a=window.open("dialog_1.htm","_blank");   
  a.document.execCommand("SaveAs");   
  a.close();   
  }   
</Script>
  <form action="save.php?action=zdyurl" method="post" name="myform">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;�Զ���URL</th>
</tr>
<tr>
<td width="20%" height="20" align="right" valign="top">˵����</td>
<td width="80%">
��53KF�Ի�����ҳ�棨���촰�ڣ����ص��Լ�����վ�����޸��û����ͼ��򿪵ĵ�ַ�������ӡ��öԻ�����ҳ���IE�������ϵ�ַ��ʾ�Լ���վ��������ַ�� 
  <BR><B>����������裺</B><BR>
  <SPAN style="COLOR: #666666"><B>1��</B>��������<B>���ͷ�ϵͳ�Ի�����ҳ��</B>��<a href="#" onclick="openfile()" title="����dialog_1.htm�ļ�"><font color="#FF0000"><STRONG>������ر��ͷ�ϵͳ�Ի�����ҳ��</STRONG></font></A><BR>
  <B>2��</B>�����ص�<B><SPAN style="COLOR: #666666"><B>���ͷ�ϵͳ</B></SPAN>�Ի�����ҳ��</B>�ϴ����Լ�����վ�ռ��� <BR>
  <B>3��</B>�ϴ���Ϻ�����IE������м���ո��ϴ���<B><SPAN style="COLOR: #666666"><B>���ͷ�ϵͳ</B></SPAN>�Ի�����</B>����ַ����һ���Ƿ��ܴ򿪴˴��ڡ�IE��ַ������ʾ�������Ƿ���ȷ�����һ��������������һ������������ѯ<B>�ͷ���Ա</B><BR>
  <B>4��</B>���������������������ո��ϴ������ܹ����ʵ�<B><SPAN style="COLOR: #666666"><B>���ͷ�ϵͳ</B></SPAN>�Ի�����ҳ��</B>����ַ(���磺<FONT color=#ff0000>http://www.</FONT></SPAN><FONT color=#ff0000>XXX</FONT><SPAN style="COLOR: #666666"><FONT color=#ff0000>.com/dialog_1.htm</FONT>)��������档</SPAN></td>
</tr>
<tr>
<td align="right" height="20">�Զ���URL���أ�</td>
<td>
  <input type="radio" name="urlkg" value="0" <?if($urlkg==0)echo'checked'?>>��
  <input type="radio" name="urlkg" value="1" <?if($urlkg==1)echo'checked'?>>��
</td>
</tr>
<tr>
<td align="right" height="20">����վ�Ի�ҳ�棺</td>
<td>
<?=setinput("text","url",$url,"",52,100)?> </td>
</tr>
<tr>
<td colspan=2 align="center"><br><?=setinput("submit","submit","�����޸�")?><br><br></td>
</tr>
</table>
</form>
<?include("footer.php");?>