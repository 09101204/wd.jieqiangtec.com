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

public partial class PowerTalk_LoginOut : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {

        if (Session["Engin_UserID"] != null)
        {
         //下线格式
        // @downlogin:游客ID,IP地址,真实地址,进入时刻,上次访问路径
        string WebServiceAnser = "在线客服";//客服名称
         object UpHtml = null;
        
         try { UpHtml = Request.UrlReferrer.AbsolutePath; }
         catch { }
         string UpHtmlStr = "Chat.aspx";
         if (UpHtml != null)
         {
             UpHtmlStr = UpHtml.ToString();
         }
     
             string FormatSpliteStr = "@downlogin:" + Session["Engin_UserID"].ToString() + ",";
             FormatSpliteStr += HttpContext.Current.Request.UserHostAddress + ",";
             FormatSpliteStr += "local" + "," + DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") + "," + UpHtmlStr;
             PowerTalkBox.PowerTalk.AddChatInfo(Session["Engin_UserID"].ToString(), WebServiceAnser, FormatSpliteStr);
             Session.Abandon();
         }
    }
}
