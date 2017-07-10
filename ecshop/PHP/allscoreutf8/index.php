<?php
/* *
 * 功能：商银信即时到帐接口调试入口页面
 * 版本：1.0
 * 日期：2011-11-03
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 */

 date_default_timezone_set("Asia/Shanghai"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>商银信支付--即时支付接口</title>
	</head>
	<body>
			<a href="order_query.php" target="_blank">订单查询</a>
			<a href="order_bank_refund.php" target="_blank">网银支付订单退货</a>
			<a href="order_quick_refund.php" target="_blank">快捷支付订单退货</a>
		<form name="direct" action="allscore_pay.php" method="post" target="_blank">
			<table width="100%" border="0">
				<tr>
					<th colspan="2" scope="col">
						<a href="http://www.allscore.com.cn" target="_blank"><img
								src="images/allscore_logo.gif" border="0" align='left' /> </a>
					</th>
				</tr>
                <tr>
    				<td colspan="2" height="2" bgcolor="#ff7300"></td>
  				</tr>
  				<tr>
				<td width="24%" align="right">商户编号：</td>
				<td width="76%"><input type="text" name="merchantId"
					id="merchantId" value="888110053110040"></td>
				</tr>
				<tr>
					<td align="right">
						商家订单号：
					</td>
					<td>
						<input type="text" name="out_orderNo" id="out_orderNo"
							value="<?php echo date("YmdHis");?>" />
					</td>
				</tr>
                <tr>
					<td width="16%" align="right">商品名称：					</td>
			 		 <td width="84%">
						<input type="text" name="goodName" id="goodName">
					</td>
				</tr>
                <tr>
					<td width="16%" align="right">商品描述：					</td>
			  		<td width="84%">
						<input type="text" name="goodBody" id="goodBody">
					</td>
				</tr>
                <tr>
					<td width="16%" align="right">订单总价：					</td>
			  		<td width="84%">
						<input type="text" name="goodPrice" id="goodPrice">
					</td>
				</tr>
				
			<tr>
				<td width="24%" align="right">外部账户ID：</td>
				<td width="76%"><input type="text" name="outAcctId"
					id="outAcctId" value="lidong"></td>
			</tr>
			<tr>
				<td width="24%" align="right">支付方式：</td>
				<td width="76%">
					
					<select name="payMethod">
						<option value="fastPay">纯快捷</option>
						<option value="bankPay">纯网银</option>
					</select>	
				</td>
			</tr>
			<tr>
				<td width="24%" align="right">（网上银行必要参数）默认银行卡编号：</td>
				<td width="76%"><select name="defaultBank">
						<option value="ABC">中国农业银行</option>
						<option value="BJBANK">北京银行</option>
						<option value="BJRCB">北京农商银行</option>
						<option value="BOC">中国银行</option>
						<option value="CEB">中国光大银行</option>
						<option value="CIB">兴业银行</option>
						<option value="CITIC">中信银行</option>
						<option value="CMBC">中国民生银行</option>
						<option value="ICBC">中国工商银行</option>
						<option value="NBBANK">宁波银行</option>
						<option value="SDB">深圳发展银行</option>
						<option value="HXBANK">华夏银行</option>
						<option value="SPDB">浦发银行</option>
						<option value="PSBC">中国邮政储蓄银行</option>
						<option value="HZCB">杭州银行</option>
						<option value="NJCB">南京银行</option>
						<option value="COMM">交通银行</option>
					    <option value="CMB">招商银行</option>
						<option value="CCB">中国建设银行</option>
						<option value="GDB">广发银行</option>
						
				</select></td>
			</tr>
			<tr>
				<td width="24%" align="right">（网上银行必要参数）加密方式：</td>
				<td width="76%"><select name="channel">
						<option value="B2C">个人网银</option>
						<option value="B2B">企业网银</option>
				</select></td>
			</tr>	
			<tr>
				<td width="24%" align="right">（快捷支付必要参数）卡类标识：</td>
				<td width="76%"><select name="certType">
						<option value="debit">储蓄卡</option>
						<option value="credit">信用卡</option>
				</select></td>
			</tr>
			<tr>
				<td width="24%" align="right">（网上银行支持类型）卡类标识：</td>
				<td width="76%"><select name="cardAttr">
						<option value="01">储蓄卡</option>
						<option value="02">信用卡</option>
				</select></td>
			</tr>
			<tr>
				<td width="24%" align="right">加密方式：</td>
				<td width="76%"><select name="signType">
						<option value="MD5">MD5</option>				
						<option value="RSA">RSA秘钥</option>

				</select></td>
			</tr>
			<tr>
				<td width="24%" align="right">returnUrl：</td>
				<td width="76%"><input type="text" name="returnUrl"
					id="returnUrl" style="width:400px;" value="http://192.168.9.9/allscoreutf8/">(回调地址ip和端口需要更具测试地址更改)</td>
			</tr>
			
			<tr>
				<td width="24%" align="right">notifyUrl：</td>
				<td width="76%"><input type="text" name="notifyUrl"
					id="notifyUrl" style="width:400px;" value="http://192.168.9.9/allscoreutf8/">(回调地址ip和端口需要更具测试地址更改)</td>
			</tr>
			<tr>
				<td width="24%" align="right">ditailUrl：</td>
				<td width="76%"><input type="text" name="detailUrl"
					id="detailUrl" style="width:400px;" value="http://192.168.9.9/allscoreutf8/"></td>
			</tr>
			<tr>
				<td align="right">操作：</td>
				<td><input type="submit" name="submit" value="商银信支付" /></td>
			</tr>
			</table>
		</form>
		
	</body>
</html>