<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>订单查询</title>
</head>

<body>
<?php 
require_once("allscore.config.php");
require_once("lib/allscore_service.class.php");


	if(empty($_POST['outOrderId'])){
		
?>
<form  action="order_query.php" method="post">
		<table width="100%">
				<tr>
					<th colspan="2" scope="col">
						<a href="http://www.allscore.com" target="_blank"><img
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
					<td width="24%" align="right">外部交易号：					</td>
			  		<td width="76%">
						<input type="text" name="outOrderId" id="outOrderId" >
					</td>
				</tr>
				<tr>
				<td width="24%" align="right">加密方式：</td>
				<td width="76%"><select name="signType">
						<option value="RSA">RSA秘钥</option>
						<option value="MD5">MD5</option>
				</select></td>
			</tr>
				<tr>
					<td align="right">
						操作：
					</td>
					<td>
						<input type="submit" name="submit" value="订单查询" />
					</td>
				</tr>
		</table>
		</form>
        
<?php
}else{


    $service="orderQuery";
    $outOrderId=$_POST["outOrderId"];
    $inputCharset=trim(strtolower($allscore_config['input_charset']));
    $merchantId=trim($_POST["merchantId"]);
    $key=trim($allscore_config['key']);
    $signType=trim($_POST["signType"]);



    //构造要请求的参数数组
    $parameter = array(
    		"service"		=> $service,		
    		"inputCharset"	=> $inputCharset,
    		"merchantId"	=> $merchantId,
    		"signType"      => $signType,
    		"outOrderId"	=> $outOrderId

    );

    $allscoreService = new AllscoreService($allscore_config);
    $html_text = $allscoreService->query($parameter);
    echo $html_text;    


}
?>
</body>
</html>