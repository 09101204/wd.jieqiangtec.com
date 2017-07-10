using System;
using System.Data;
using System.Configuration;
using System.Collections.Generic;
using System.Web;
using System.Web.Security;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Web.UI.WebControls.WebParts;
using System.Web.UI.HtmlControls;
using System.Data.OleDb;
/// <summary>
/// IPFindAddr 的摘要说明
/// </summary>
public class IPFindAddr
{
    /// <summary>
    /// 数据库联接
    /// </summary>
    public static  OleDbConnection OleConn
    {
        get {
            return new OleDbConnection("Provider=Microsoft.Jet.OleDb.4.0;Jet OLEDB:Database Password=;Data Source=" + AppDomain.CurrentDomain.BaseDirectory + "\\App_Data\\IP.mdb"); //Access数据库连接字符串
           }
    }
    /// <summary>
    /// 获取真实地址
    /// </summary>
    public static string GetAddr
    { 
         get {
              string DiZhi = "未知网络";
              OleDbConnection Conn = OleConn;
              try
              {
                  string IP = IPToInt(HttpContext.Current.Request.UserHostAddress).ToString();

                  Conn.Open();
                  object Obj = new OleDbCommand("select top 1 region from ip where IPN1<=" + IP + "  and IPN2>=" + IP, Conn).ExecuteScalar();
                  if (Obj != null)
                  {
                      DiZhi = Obj.ToString();
                  }
              }
              catch { }
              finally { Conn.Close(); }
              return DiZhi;
             }
    }
    public IPFindAddr()
    {
        //
        // TODO: 在此处添加构造函数逻辑
        //
    }
    /// <summary>
    /// IP地址和数字之间转化的算法

    /// </summary>
    /// <param name="ipAddress">传入IP地址</param>
    /// <returns></returns>

    public static uint IPToInt(string ipAddress)
    {
        string disjunctiveStr = ".,: ";
        char[] delimiter = disjunctiveStr.ToCharArray();
        string[] startIP = null;
        for (int i = 1; i <= 5; i++)
        {
            startIP = ipAddress.Split(delimiter, i);
        }
        string a1 = startIP[0].ToString();
        string a2 = startIP[1].ToString();
        string a3 = startIP[2].ToString();
        string a4 = startIP[3].ToString();
        uint U1 = uint.Parse(a1);
        uint U2 = uint.Parse(a2);
        uint U3 = uint.Parse(a3);
        uint U4 = uint.Parse(a4);
        uint U = U1 << 24;
        U += U2 << 16;
        U += U3 << 8;
        U += U4;
        return U;
    }
    /// <summary>
    /// 数字和IP地址之间转化的算法
    /// </summary>
    /// <param name="ipAddress">传入IP地址</param>
    /// <returns></returns>
    public static string IntToIP(uint ipAddress)
    {
        long ui1 = ipAddress & 0xFF000000;
        ui1 = ui1 >> 24;
        long ui2 = ipAddress & 0x00FF0000;
        ui2 = ui2 >> 16;
        long ui3 = ipAddress & 0x0000FF00;
        ui3 = ui3 >> 8;
        long ui4 = ipAddress & 0x000000FF;
        string IPstr = "";
        IPstr = System.Convert.ToString(ui1) + "." + System.Convert.ToString(ui2) + "." + System.Convert.ToString(ui3) + "." + System.Convert.ToString(ui4);
        return IPstr;
    }
}
