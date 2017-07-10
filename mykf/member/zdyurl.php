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
<th colspan=2 align="left">&nbsp;自定义URL</th>
</tr>
<tr>
<td width="20%" height="20" align="right" valign="top">说明：</td>
<td width="80%">
将53KF对话窗口页面（聊天窗口）下载到自己的网站，并修改用户点击图标打开的地址到此连接。让对话窗口页面的IE标题栏上地址显示自己网站的域名地址。 
  <BR><B>具体操作步骤：</B><BR>
  <SPAN style="COLOR: #666666"><B>1、</B>首先下载<B>本客服系统对话窗口页面</B>：<a href="#" onclick="openfile()" title="下载dialog_1.htm文件"><font color="#FF0000"><STRONG>点击下载本客服系统对话窗口页面</STRONG></font></A><BR>
  <B>2、</B>将下载的<B><SPAN style="COLOR: #666666"><B>本客服系统</B></SPAN>对话窗口页面</B>上传到自己的网站空间上 <BR>
  <B>3、</B>上传完毕后，请在IE浏览器中键入刚刚上传的<B><SPAN style="COLOR: #666666"><B>本客服系统</B></SPAN>对话窗口</B>的网址，试一下是否能打开此窗口、IE地址栏中显示的域名是否正确，如果一切正常，继续下一步；否则请咨询<B>客服人员</B><BR>
  <B>4、</B>在下面的输入框中填入您刚刚上传并且能够访问的<B><SPAN style="COLOR: #666666"><B>本客服系统</B></SPAN>对话窗口页面</B>的网址(例如：<FONT color=#ff0000>http://www.</FONT></SPAN><FONT color=#ff0000>XXX</FONT><SPAN style="COLOR: #666666"><FONT color=#ff0000>.com/dialog_1.htm</FONT>)，点击保存。</SPAN></td>
</tr>
<tr>
<td align="right" height="20">自定义URL开关：</td>
<td>
  <input type="radio" name="urlkg" value="0" <?if($urlkg==0)echo'checked'?>>开
  <input type="radio" name="urlkg" value="1" <?if($urlkg==1)echo'checked'?>>关
</td>
</tr>
<tr>
<td align="right" height="20">您网站对话页面：</td>
<td>
<?=setinput("text","url",$url,"",52,100)?> </td>
</tr>
<tr>
<td colspan=2 align="center"><br><?=setinput("submit","submit","保存修改")?><br><br></td>
</tr>
</table>
</form>
<?include("footer.php");?>