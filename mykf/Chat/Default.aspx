<%@ Page Language="C#" AutoEventWireup="true"  CodeFile="Default.aspx.cs" Inherits="_Default" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" >
<head runat="server">
    <title>在线客服示例</title>
</head>
<body>
    <form id="form1" runat="server">
     <h2>连接进入</h2>
   <hr>
   <div><a href="PowerTalk/IM/Chat.aspx" target="_blank">游客入口</a><br/>
<hr>
   <h2>效果进入</h2>
   <hr>
   <a href="#" onclick="window.open('PowerTalk/IM/Chat.aspx', 'popupnav', 'width=600,height=480,resizable=1,scrollbars=auto');">弹出窗口</a><br/>
    <a href="JavaScripts/LikeXP.htm" >黑屏效果</a><br/>
   <a href="JavaScripts/OutPop.htm" >弹出效果</a><br/>
      </div>
    </form>
</body>
</html>
