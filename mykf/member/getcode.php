<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");?>
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th align="left" colspan=2>&nbsp;ͼƬ����</th>
</tr>
<tr>
<td height="20" align="left">
<textarea id="piccode" cols="80" rows="3"><script src="<?=$homepage?>kf.php?cid=<?=$cid?>&mod=im&type=icon" charset="gb2312" type="text/javascript"></script></textarea>
<input type="button" value="���ƴ���" onclick="copycode(piccode)" />
<input type="button" value="Ԥ��Ч��" onclick="window.open('<?=$homepage?>kf.php?cid=<?=$cid?>&mod=demo&type=icon&charset=gb2312','','')" />
</td>
</tr>
<tr>
<th align="left" colspan=2>&nbsp;�ͷ��б�</th>
</tr>
<tr>
<td height="20" align="left">
<textarea id="listcode" cols="80" rows="3"><script src="<?=$homepage?>kf.php?cid=<?=$cid?>&mod=im&type=list" charset="gb2312" type="text/javascript"></script></textarea>
<input type="button" value="���ƴ���" onclick="copycode(listcode)" />
<input type="button" value="Ԥ��Ч��" onclick="window.open('<?=$homepage?>kf.php?cid=<?=$cid?>&mod=demo&type=list&charset=gb2312','','')" />
</td>
</tr>
</table><br />
���´��벻��ʹ���������빦�ܣ�����������ϢҲ���ᱻ��¼��
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th align="left" colspan=2>&nbsp;��̳UBB����(ͼ��) <font color="#999999">��ͨ���޸�icon�����ı�ͼ����ʽ</font></th>
</tr>
<tr>
<td height="20" align="left">
<textarea id="ubbcode" cols="80" rows="3">[url=<?=$homepage?>kf.php?mod=client&cid=<?=$cid?>&wid=<?=$wid?>][img]<?=$homepage?>kf.php?mod=im&type=pic&cid=<?=$cid?>&wid=<?=$wid?>&icon=<?=$default_icon?>[/img][/url]</textarea>
<input type="button" value="���ƴ���" onclick="copycode(ubbcode)" />
<input type="button" value="Ԥ��Ч��" onclick="window.open('<?=$homepage?>kf.php?mod=demo&type=pic&cid=<?=$cid?>&wid=<?=$wid?>&icon=<?=$default_icon?>','','')" />
</td>
</tr>
<tr>
<th align="left" colspan=2>&nbsp;��̳UBB����(����)</th>
</tr>
<tr>
<td height="20" align="left">
<textarea id="ubbcode2" cols="80" rows="3">[url=<?=$homepage?>kf.php?mod=client&cid=<?=$cid?>&wid=<?=$wid?>]���Ͽͷ�[/url]</textarea>
<input type="button" value="���ƴ���" onclick="copycode(ubbcode2)" />
<input type="button" value="Ԥ��Ч��" onclick="window.open('<?=$homepage?>kf.php?mod=demo&type=text&cid=<?=$cid?>&wid=<?=$wid?>&text=���Ͽͷ�','','')" />
</td>
</tr>
<tr>
<th align="left" colspan=2>&nbsp;HTML��ʽ����(ͼ��) <font color="#999999">��ͨ���޸�icon�����ı�ͼ����ʽ</font></th>
</tr>
<tr>
<td height="20" align="left">
<textarea id="htmlcode" cols="80" rows="3"><a href="<?=$homepage?>kf.php?mod=client&cid=<?=$cid?>&wid=<?=$wid?>" target="_blank"><img src="<?=$homepage?>kf.php?mod=im&type=pic&cid=<?=$cid?>&wid=<?=$wid?>&icon=<?=$default_icon?>" border="0"></a></textarea>
<input type="button" value="���ƴ���" onclick="copycode(htmlcode)" />
<input type="button" value="Ԥ��Ч��" onclick="window.open('<?=$homepage?>kf.php?mod=demo&type=pic&cid=<?=$cid?>&wid=<?=$wid?>&icon=<?=$default_icon?>','','')" />
</td>
</tr>
<tr>
<th align="left" colspan=2>&nbsp;HTML��ʽ����(����)</th>
</tr>
<tr>
<td height="20" align="left">
<textarea id="htmlcode2" cols="80" rows="3"><a href="<?=$homepage?>kf.php?mod=client&cid=<?=$cid?>&wid=<?=$wid?>" target="_blank">���Ͽͷ�</a></textarea>
<input type="button" value="���ƴ���" onclick="copycode(htmlcode2)" />
<input type="button" value="Ԥ��Ч��" onclick="window.open('<?=$homepage?>kf.php?mod=demo&type=text&cid=<?=$cid?>&wid=<?=$wid?>&text=���Ͽͷ�','','')" />
</td>
</tr>
</table>
<?include("footer.php");?>