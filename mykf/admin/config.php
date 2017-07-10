<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<form action="save.php?action=config" method="post" name="myform">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;��������<?=ToHelp('config')?></th>
</tr>
<tr>
<td width="30%" align="right" height="20">��˾���ƣ�</td>
<td width="70%">
<?=setinput("text","company",$company,"",40,100)?></td>
</tr>
<tr>
<td align="right" height="20">������ַ��</td>
<td>
<?=setinput("text","homepage",$homepage,"",40,100)?>�������ԡ�/��������
</td>
</tr>
<tr>
<td align="right" height="20">�ٷ��ͷ���ţ�</td>
<td>
<?=setinput("text","mycompanyqq",$mycompanyqq,"",40,100)?> <font color="#999999">(�ٷ��ṩ�ͻ�����Ŀͷ����)</font></td>
</tr>
<tr>
<td align="right" height="20">ǰ̨��ҳ���ԣ�</td>
<td>
  <input type="radio" name="lang_web" value="zh-cn" <?if($lang_web=='zh-cn')echo'checked'?>>�������� 
  <input type="radio" name="lang_web" value="zh-tw" <?if($lang_web=='zh-tw')echo'checked'?>>��������
</td>
</tr>
<tr>
<td align="right" height="20">�Ի���Ĭ�����ԣ�</td>
<td>
  <input type="radio" name="lang_dialog" value="zh-cn" <?if($lang_dialog=='zh-cn')echo'checked'?>>�������� 
  <input type="radio" name="lang_dialog" value="zh-tw" <?if($lang_dialog=='zh-tw')echo'checked'?>>�������� 
  <input type="radio" name="lang_dialog" value="en" <?if($lang_dialog=='en')echo'checked'?>>Ӣ��
</td>
</tr>
<tr>
<td align="right" height="20">Ĭ�϶Ի���Logo��</td>
<td>
<?=setinput("text","dialoglogo",$dialoglogo,"",40,100)?></td>
</tr>
<tr>
<td align="right" height="20">Ĭ�϶Ի���Logo���ӣ�</td>
<td>
<?=setinput("text","dialoglogourl",$dialoglogourl,"",40,100)?></td>
</tr>
<tr>
<td align="right" height="20">������ʱ�</td>
<td>
<?=setinput("text","timezone",$timezone,"",4,5)?></td>
</tr>
<tr>
<th colspan=2 align="left">&nbsp;����������</th>
</tr>
<tr>
<td align="right" height="20">����Ȩ��</td>
<td>
<?=setinput("checkbox","default_agenttype","1",$agenttype)?>��ת����ɶԿͻ�������������<?=ToHelp('agentset')?>
</td>
</tr>
<tr>
<th colspan=2 align="left">&nbsp;�ͷ��������</th>
</tr>
<tr>
<td align="right" height="20">�ٷ���ַ��</td>
<td>
<?=setinput("text","companyurl",$companyurl,"",40,100)?><br /><font color="#999999">(����ͻ��ˡ����ʹٷ���վ����ת����ַ�����Բ��ǵ�ǰ����)</font></td>
</tr>
<tr>
<td align="right" height="20">������⣺</td>
<td>
<?=setinput("text","softtitle",$softtitle,"",40,100)?><br /><font color="#999999">(���Ŀͷ����������ʲô���ƣ��磺�ͻ�ͨ)</font></td>
</tr>
<tr>
<td align="right" height="20"></td>
<td>
<?=setinput("checkbox","closeloginad","1",$closeloginad=='1'?'checked':'')?>�رյ�½����
</td>
</tr>
<tr>
<td align="right" height="20"></td>
<td>
<?=setinput("checkbox","closemainad","1",$closemainad=='1'?'checked':'')?>�ر����б���
</td>
</tr>
<tr>
<td align="right" height="20"></td>
<td>
<?=setinput("checkbox","closefile","1",$closefile=='1'?'checked':'')?>�ر��ļ����͹���
</td>
</tr>
<tr>
<td align="right" height="20"></td>
<td>
<?=setinput("checkbox","closecatch","1",$closecatch=='1'?'checked':'')?>�رս�ͼ����
</td>
</tr>
<tr>
<td align="right" height="20"></td>
<td>
<?=setinput("checkbox","closepublic","1",$closepublic=='1'?'checked':'')?>�رչ���Ƶ��(��ҵ�ڲ�ͨ��)
</td>
</tr>
<tr>
<td align="right" height="20"></td>
<td>
<?=setinput("checkbox","closelimit","1",$closelimit=='1'?'checked':'')?>�رպ���������
</td>
</tr>
<tr>
<th colspan=2 align="left">&nbsp;�ͷ�����<?=ToHelp('worker')?></th>
</tr>
<tr>
<td align="right" height="20"></td>
<td>
<?=setinput("checkbox","allowreg","1",$allowreg=='1'?'checked':'')?>�������û�����
</td>
</tr>
<tr>
<td align="right" height="20">�߼��������ʱ�䣺</td>
<td>
<?=setinput("text","freeday",$freeday,"",4,5)?> ��
</td>
</tr>
<tr>
<td align="right" height="20">���ʱ�������͵ĸ߼����ܣ�</td>
<td>
<?$i=0;
foreach($superfun as $rs){
$i++;
echo setinput("checkbox","regfun[]",$rs['keyname'],in_array($rs['keyname'],$regfuns)?'checked':'').'<span style="width:60px">'.$rs['title'].'</span> ';
if($i>0 && $i % 4==0)echo'<br />';
}?>
</td>
</tr>
<tr>
<td align="right" height="20">�߼����ܹ��ں�</td>
<td>
<?=setinput("radio","autolock",'1',$autolock=='1'?'checked':'')?>��ֹ��¼�ͷ���
<?=setinput("radio","autolock",'0',$autolock!='1'?'checked':'')?>����ʹ����ѹ���
</td>
</tr>
<tr>
<td align="right" height="20">Ĭ��ϯλ���ƣ�</td>
<td>
<?=setinput("text","default_workersort",$default_workersort,"",20,20)?>
</td>
</tr>
<tr>
<td align="right" height="20">Ĭ�Ͽͷ����ƣ�</td>
<td>
<?=setinput("text","default_worker",$default_worker,"",20,20)?>
</td>
</tr>
<tr>
<td align="right" height="20">Ĭ��ϯλ������</td>
<td>
<?=setinput("text","default_sortcount",$default_sortcount,"",4,5)?>
</td>
</tr>
<tr>
<td align="right" height="20">Ĭ�Ͽͷ�������</td>
<td>
<?=setinput("text","default_workercount",$default_workercount,"",4,5)?>
</td>
</tr>
<tr>
<th colspan=2 align="left">&nbsp;�ͷ��۸��</th>
</tr>
<tr>
<td align="right" height="20">ϯλ������</td>
<td>
<?=setinput("text","price_sort",$price_sort,"",4,10)?> Ԫ
</td>
</tr>
<tr>
<td align="right" height="20">�ͷ�������</td>
<td>
<?=setinput("text","price_worker",$price_worker,"",4,10)?> Ԫ
</td>
</tr>
<tr>
<td align="right" height="20">��׼�ͻ�����<?=$PriceOne[0]?>�۸�</td>
<td>
<?=setinput("text","price_days1",$price_days1,"",4,10)?> Ԫ
</td>
</tr>
<tr>
<th colspan=2 align="left">&nbsp;�ļ��ϴ�����<?=ToHelp('sendfile')?></th>
</tr>
<tr>
<td align="right" height="20">�����ļ���С��</td>
<td>
<?=setinput("text","maxfilesize",$maxfilesize,"",4,100)?>MB
</td>
</tr>
<tr>
<td align="right" height="20">�����ļ����ͣ�</td>
<td>
<?=setinput("text","allowfiletype",$allowfiletype,"",40,100)?><font color="#999999">(��<font color="red">|</font>�ָ�)</font>
</td>
</tr>
<tr>
<th colspan=2 align="left">&nbsp;֧��������<?=ToHelp('alipay')?></th>
</tr>
<tr>
<td align="right" height="20">֧�����˺ţ�</td>
<td>
<?=setinput("text","alipayid",$alipayid,"",40,100)?>
</td>
</tr>
<tr>
<td align="right" height="20">��ȫ�����룺</td>
<td>
<?=setinput("text","alipaykey",$alipaykey,"",40,100)?>
</td>
</tr>
<tr>
<td align="right" height="20">�������ID��</td>
<td>
<?=setinput("text","partner",$partner,"",40,100)?>
</td>
</tr>
<tr>
<th colspan=2 align="left">&nbsp;�������������</th>
</tr>
<tr>
<td align="right" height="20">�����˺ţ�</td>
<td>
<?=setinput("text","smtp_mail",$smtp_mail,"",40,100)?>&nbsp;&nbsp;���ڷ����ʼ��������˺�
</td>
</tr>
<tr>
<td align="right" height="20">�ʼ�SMTP��������</td>
<td>
<?=setinput("text","smtp_smtp",$smtp_smtp,"",40,100)?>&nbsp;&nbsp;��163����Ϊsmtp.163.com
</td>
</tr>
<tr>
<td align="right" height="20">�������룺</td>
<td>
<?=setinput("password","smtp_psd",$smtp_psd,"",40,100)?>&nbsp;&nbsp;���ڷ����ʼ�����������
</td>
</tr>
<tr>
<td colspan=2 align="center"><?=setinput("submit","submit","�����޸�")?></td>
</tr>
</table>
</form>
<?include("footer.php");?>