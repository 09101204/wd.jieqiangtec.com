<?php
/* * 
 * 功能：商银信页面跳转同步通知页面
 * 版本：1.0
 * 日期：2011-11-03
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究商银信接口使用，只是提供一个参考。

 *************************页面功能说明*************************
 * 该页面可在本机电脑测试
 * 可放入HTML等美化页面的代码、商户业务逻辑程序代码
 * 该页面可以使用PHP开发工具调试，也可以使用写文本函数logResult，该函数已被默认关闭，见allscore_notify_class.php中的函数verifyReturn
 
 * tradeStatus=2 表示交易已经成功结束;
 */
 

require_once("allscore.config.php");
require_once("lib/allscore_notify.class.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <title>商银信即时到帐接口</title>
	</head>
    <body>
<?php
//计算得出通知验证结果
$allscoreNotify = new AllscoreNotify($allscore_config);
$verify_result = $allscoreNotify->verifyReturn();

if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代码
	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    //获取商银信的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
    $out_trade_no	= $_GET['outOrderId'];	//获取订单号
    $total_fee		= $_GET['transAmt'];		//获取总价格
    $subject        = $_GET['subject'];
    $body           = $_GET['body'];


    if($_GET['tradeStatus'] == '2') {
        
        
		//判断该笔订单是否在商户网站中已经做过处理（可参考接入文档“）
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			//如果有做过处理，不执行商户的业务程序
?>

		<table width="450" height="300" border="0" align="center">
			<tr>
				<td valign="top" >
					<table width="444" border="0">
						<tr>
							<td height="42">
								<SPAN
									style="FONT-SIZE: 14px; COLOR: #FF6600; FONT-FAMILY: Verdana">您的订单号为:<B
									style="FONT-SIZE: 18px"> <?php echo $out_trade_no?></b> </span>
							</td>
						</tr>
						<tr>
							<td height="47">
								<SPAN
									style="FONT-SIZE: 14px; COLOR: #FF6600; FONT-FAMILY: Verdana">订单价格:<B
									style="FONT-SIZE: 18px"> <?php echo $total_fee?></b> </span>
							</td>
						</tr>
						<tr>
							<td height="47">
								<SPAN
									style="FONT-SIZE: 14px; COLOR: #FF6600; FONT-FAMILY: Verdana">商品名称:<B
									style="FONT-SIZE: 18px"> <?php echo $subject?></b> </span>
							</td>
						</tr>
						<tr>
							<td height="47">
								<SPAN
									style="FONT-SIZE: 14px; COLOR: #FF6600; FONT-FAMILY: Verdana">商品描述:<B
									style="FONT-SIZE: 18px"> <?php echo $body?></b> </span>
							</td>
						</tr>
						<tr>
							<td height="47">
								<div align="center">
									<span class="style1"><font size="+3">付款成功!</font> </span>
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

<?php            
            
            
    }
    else {
      echo "tradeStatus=".$_GET['tradeStatus'];
    }
		
	//echo "验证成功<br />";

	
	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //验证失败
    //如要调试，请看allscore_notify.php页面的verifyReturn函数，比对sign和mysign的值是否相等，或者检查$responseTxt有没有返回true
    echo "验证失败";
}
?>

    
    </body>
</html>