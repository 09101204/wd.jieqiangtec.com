<%@ Page Language="C#" AutoEventWireup="true" CodeFile="Chat.aspx.cs" Inherits="PowerChatRoom_Chat" %>

<%@ Register Assembly="PowerTalkBox" Namespace="PowerTalkBox" TagPrefix="PTB" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" >
<head runat="server">
    <title>XXXX公司在线咨询系统</title>
    <link href="css.css" rel="stylesheet" type="text/css" />


</head>

<script type="text/javascript">       
<!--         

     window.onbeforeunload = onbeforeunload_handler;       
     window.onunload = onunload_handler;       
     function onbeforeunload_handler(){  
     document.getElementById('PowerTalkImg').src='LoginOut.aspx';
      var warning="感谢您的光临,请您为客服做一份评价!";  
      alert(warning);             
      //return warning;    
     }       
           
     function onunload_handler(){   
       
         //var warning="谢谢光临";       
         //alert(warning);       
     }     


// -->    
  </script>
  
<body >

    <form id="form1" runat="server">
    <div>
   <PTB:PowerTalkBox ID="PowerTalkBox1" runat="server" LeaveTimes="999999" AllowSendFile="False" CMode="OneToOne" ChatContrlHtml="大连XXXXXX公司<br>&nbsp;&nbsp;&nbsp;&nbsp;联系电话:XXXXXXX<br>Email:XXXX@XXXXXX</a><p class='online'><a href='http://powertalkbox.cnblogs.com' title='下载' target='_blank'>下载源代码 </p>"  UserChangeList="" Interval="3300"/>
     
    
    </div>
    </form>
</body>
</html>
