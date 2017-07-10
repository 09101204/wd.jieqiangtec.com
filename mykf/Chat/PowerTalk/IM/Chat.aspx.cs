using System;
using System.Data;
using System.Configuration;
using System.Collections;
using System.Web;
using System.Web.Security;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Web.UI.WebControls.WebParts;
using System.Web.UI.HtmlControls;
using PowerTalkBox;
public partial class PowerChatRoom_Chat : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {

       
        if (!IsPostBack)
        {
                string WebServiceAnser = "在线客服";//客服名称       
                try { PowerTalk.NewUserLogin(WebServiceAnser, "信息", DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")); }
                catch { }
                PowerTalkBox1.ToUserIdContent = WebServiceAnser;
                PowerTalkBox1.UserChangeList = "";//不提示任何消息
                PowerTalkBox1.InitLoad(); //初始化PowerTalkBox
                string IpAddr = IPFindAddr.GetAddr.Replace("CZ88.NET","").Trim();
                PowerTalkBox.PowerTalk.AddChatInfo(WebServiceAnser, PowerTalkBox1.MyUserName, "&nbsp;&nbsp;&nbsp;&nbsp;欢迎来自" + IpAddr + "的朋友您好,很高兴为您服务。我是" + WebServiceAnser + "!");
                //上线格式
                //@uplogin:游客ID,IP地址,真实地址,进入时刻,上次访问路径
                object UpHtml = null;
                try { UpHtml = Request.UrlReferrer.AbsolutePath; }
                catch { }
                string UpHtmlStr = "Chat.aspx";
                if (UpHtml != null)
                {
                    UpHtmlStr = UpHtml.ToString();
                }
                string FormatSpliteStr = "@uplogin:" + PowerTalkBox1.MyUserName+",";
                FormatSpliteStr+=HttpContext.Current.Request.UserHostAddress+",";
                FormatSpliteStr += IpAddr + "," + DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") + "," + UpHtmlStr;
                PowerTalkBox.PowerTalk.AddChatInfo(PowerTalkBox1.MyUserName, WebServiceAnser, FormatSpliteStr);           
        }
      


    }
  

}
