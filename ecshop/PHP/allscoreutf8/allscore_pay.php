<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商银信</title>
</head>

<body>
<?php
require_once ("allscore.config.php");
require_once ("lib/allscore_service.class.php");

/**
 * ************************请求参数*************************
 */

// 必填参数//
// $paygateway = "http://192.168.8.98:8088/webpay/serviceDirect.htm?";//支付接口（不可以修改）
$service = "directPay"; // 快速付款交易服务（不可以修改）
//$inputCharset = trim(strtolower($allscore_config['input_charset'])); // （不可以修改）
$inputCharset = trim($allscore_config['input_charset']); // （不可以修改）
$merchantId = $_POST['merchantId']; // 商户号(商银信公司提供)

$key = trim($allscore_config['key']); // 安全密钥(商银信公司提供)
                                      // $payMethod = "allscorePay";//目前只有allscorePay(商银信支付)
                                      
// //商户网站订单（也就是外部订单号，是通过客户网站传给商银信系统，不可以重复）
$outOrderId = $_POST['out_orderNo'];
// 商品名称，其中*号后做了UrlEncode，商品订单号：
$subject = trim($_POST['goodName']) ;
// 商品描述，推荐格式：商品名称（订单编号：订单编号）
$body = $_POST['goodBody'];
// 订单总价
$transAmt = $_POST['goodPrice'];
$notifyUrl = $_POST['notifyUrl']; // 通知接收URL(本地测试时，服务器返回无法测试)
$returnUrl = $_POST['returnUrl']; // 支付完成后跳转返回的网址URL
$detailUrl = $_POST['detailUrl'];




$outAcctId = $_POST['outAcctId'];
$payMethod = $_POST['payMethod'];
$defaultBank = $_POST['defaultBank'];

$channel = $_POST['channel'];
$certType = $_POST['certType'];
$cardAttr = $_POST['cardAttr'];
$signType = $_POST['signType'];


if($signType=='MD5'){
    $notifyUrl=$notifyUrl."notify_url.php";
    $returnUrl=$returnUrl."return_url.php";


}else {
    $notifyUrl=$notifyUrl."notify_url_rsa.php";
    $returnUrl=$returnUrl."return_url_rsa.php";

}


if ($payMethod == 'bankPay') {
    
    // 构造要请求的参数数组
    $parameter = array(
        "service" => $service, //
        "inputCharset" => $inputCharset, //
        "merchantId" => $merchantId, //
        "payMethod" => $payMethod, //
        
        "outOrderId" => $outOrderId, //
        "subject" => $subject, //
        "body" => $body, //
        "transAmt" => $transAmt, //
        
        "notifyUrl" => $notifyUrl, //
        "returnUrl" => $returnUrl, //
        
        "signType" => $signType,
        
        "defaultBank" => $defaultBank,
        
        "channel" => $channel,
        "cardAttr" => $cardAttr
    );
    
    
    // 构造网银支付接口
    $allscoreService = new AllscoreService($allscore_config);
    $html_text = $allscoreService->bankPay($parameter);
    echo $html_text;
    $ItemUrl = $allscoreService->createBankUrl($parameter);
    
    
} else {
    
    $parameter = array(
        "service" => $service, //
        "inputCharset" => $inputCharset, //
        "merchantId" => $merchantId, //
        "payMethod" => $payMethod, //
        
        "outOrderId" => $outOrderId, //
        "subject" => $subject, //
        "body" => $body, //
        "transAmt" => $transAmt, //
        
        "notifyUrl" => $notifyUrl, //
        "returnUrl" => $returnUrl, //
        
        "signType" => $signType, //
        
        "outAcctId" => $outAcctId,
        "cardType" => $certType
    );
    
    
    // 构造快捷支付接口
    $allscoreService = new AllscoreService($allscore_config);
    $html_text = $allscoreService->quickPay($parameter);
    echo $html_text;
    $ItemUrl = $allscoreService->createQuickUrl($parameter);
    
}



?>

  <font color="#FF0000" size="+1">商银信即时支付入口：</font>
	<a href="<?php echo $ItemUrl ?>">商银信支付</a>
	<br> <br> 您可以检查提交给商银信的URL是否存在空值 <br> <br>
    生成的URL：<?php echo $ItemUrl?>

  






</body>
</html>