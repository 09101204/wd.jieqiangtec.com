using System;
using System.Web;
using System.Collections;
using System.Web.Services;
using System.Web.Services.Protocols;
using PowerTalkBoxContrls.Design;
using PowerTalkBoxEnum.Enum;
using PowerTalkBox;
using System.Collections.Generic;

/// <summary>
/// FetionInterFace 的摘要说明
/// </summary>
[WebService(Namespace = "http://tempuri.org/")]
[WebServiceBinding(ConformsTo = WsiProfiles.BasicProfile1_1)]
public class FetionInterFace : System.Web.Services.WebService
{

    public FetionInterFace()
    {

        //如果使用设计的组件，请取消注释以下行 
        //InitializeComponent(); 
    }

    [WebMethod]
    public string HelloWorld()
    {
        return "Hello World";
    }
    /// <summary>
    /// 添加信息
    /// </summary>
    /// <param name="MyUserId">我的ID，一般为手机号</param>
    /// <param name="ToUserID">对方ID，游客12345</param>
    /// <param name="SendMsg">发送的信息</param>
    /// <returns></returns>
    [WebMethod]
    public void ChatAdd(string MyUserId, string ToUserID, string SendMsg)
    {
        PowerTalk.AddChatInfo(MyUserId, ToUserID, SendMsg);
    }
    /// <summary>
    /// 删除
    /// </summary>
    /// <param name="MyUserId">我的ID，一般为手机号</param>
    [WebMethod]
    public void DeleteUserInfo(string DelUserId)
    {
        PowerTalkBox.PowerTalk.DeleteUserInfo(DelUserId);
    }
    /// <summary>
    /// 获取聊天内容
    /// </summary>
    /// <param name="MyUserName">我的ID,手机号码</param>
    /// <returns></returns>
    [WebMethod]
    public List<ChatInfo> GetChatInfos(string MyUserName)
    {      
        List < ChatInfo > LCI = PowerTalk.ReadChatInfo(MyUserName, PowerTalkBoxEnum.Enum.SystemMode.WebToIm);
        foreach (ChatInfo In in LCI)
        {
            In.SendContent = In.SendContent.Replace("<P>", "").Replace("</P>","").Replace("&nbsp;"," ");
        }
        return LCI;
    }

}

