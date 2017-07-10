<?include_once 'check.php';?>
<html>
<title>客服管理软件调用代码</title>
<META http-equiv=Content-Type content=text/html; charset=gb2312>
<script type="text/javascript" src="../include/javascript/common.js"></script>
<link rel="stylesheet" type="text/css" href="images/style.css">
<body LEFTMARGIN="0" TOPMARGIN="0" scroll="no" oncontextmenu=self.event.returnValue=false>
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th align="left" colspan=2>&nbsp;图片链接</th>
</tr>
<tr>
<td height="20" align="left">
<textarea id="piccode" cols="50" rows="2"><script src="<?=$homepage?>kf.php?cid=<?=$cid?>&mod=im&type=icon" charset="gb2312" type="text/javascript"></script></textarea>
<input type="button" value="复制代码" onClick="copycode(piccode)" />
<input type="button" value="预览效果" onClick="window.open('<?=$homepage?>kf.php?cid=<?=$cid?>&mod=demo&type=icon&charset=gb2312','','')" />
</td>
</tr>
<tr>
<th align="left" colspan=2>&nbsp;客服列表</th>
</tr>
<tr>
<td height="20" align="left">
<textarea id="listcode" cols="50" rows="2"><script src="<?=$homepage?>kf.php?cid=<?=$cid?>&mod=im&type=list" charset="gb2312" type="text/javascript"></script></textarea>
<input type="button" value="复制代码" onClick="copycode(listcode)" />
<input type="button" value="预览效果" onClick="window.open('<?=$homepage?>kf.php?cid=<?=$cid?>&mod=demo&type=list&charset=gb2312','','')" />
</td>
</tr>
</table><br />
以下代码不能使用主动邀请功能，访问量等信息也不会被记录！
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th align="left" colspan=2>&nbsp;论坛UBB调用(图标) <font color="#999999">可通过修改icon参数改变图标样式</font></th>
</tr>
<tr>
<td height="20" align="left">
<textarea id="ubbcode" cols="50" rows="3">[url=<?=$homepage?>kf.php?mod=client&cid=<?=$cid?>&wid=<?=$wid?>][img]<?=$homepage?>kf.php?mod=im&type=pic&cid=<?=$cid?>&wid=<?=$wid?>&icon=<?=$default_icon?>[/img][/url]</textarea>
<input type="button" value="复制代码" onClick="copycode(ubbcode)" />
<input type="button" value="预览效果" onClick="window.open('<?=$homepage?>kf.php?mod=demo&type=pic&cid=<?=$cid?>&wid=<?=$wid?>&icon=<?=$default_icon?>','','')" />
</td>
</tr>
<tr>
<th align="left" colspan=2>&nbsp;论坛UBB调用(文字)</th>
</tr>
<tr>
<td height="20" align="left">
<textarea id="ubbcode2" cols="50" rows="2">[url=<?=$homepage?>kf.php?mod=client&cid=<?=$cid?>&wid=<?=$wid?>]网上客服[/url]</textarea>
<input type="button" value="复制代码" onClick="copycode(ubbcode2)" />
<input type="button" value="预览效果" onClick="window.open('<?=$homepage?>kf.php?mod=demo&type=text&cid=<?=$cid?>&wid=<?=$wid?>&text=网上客服','','')" />
</td>
</tr>
<tr>
<th align="left" colspan=2>&nbsp;HTML格式调用(图标) <font color="#999999">可通过修改icon参数改变图标样式</font></th>
</tr>
<tr>
<td height="20" align="left">
<textarea id="htmlcode" cols="50" rows="4"><a href="<?=$homepage?>kf.php?mod=client&cid=<?=$cid?>&wid=<?=$wid?>" target="_blank"><img src="<?=$homepage?>kf.php?mod=im&type=pic&cid=<?=$cid?>&wid=<?=$wid?>&icon=<?=$default_icon?>" border="0"></a></textarea>
<input type="button" value="复制代码" onClick="copycode(htmlcode)" />
<input type="button" value="预览效果" onClick="window.open('<?=$homepage?>kf.php?mod=demo&type=pic&cid=<?=$cid?>&wid=<?=$wid?>&icon=<?=$default_icon?>','','')" />
</td>
</tr>
<tr>
<th align="left" colspan=2>&nbsp;HTML格式调用(文字)</th>
</tr>
<tr>
<td height="20" align="left">
<textarea id="htmlcode2" cols="50" rows="2"><a href="<?=$homepage?>kf.php?mod=client&cid=<?=$cid?>&wid=<?=$wid?>" target="_blank">网上客服</a></textarea>
<input type="button" value="复制代码" onClick="copycode(htmlcode2)" />
<input type="button" value="预览效果" onClick="window.open('<?=$homepage?>kf.php?mod=demo&type=text&cid=<?=$cid?>&wid=<?=$wid?>&text=网上客服','','')" />
</td>
</tr>
</table>
</body>
</html>