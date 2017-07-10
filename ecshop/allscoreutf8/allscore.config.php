<?php
/* *
 * 配置文件
 * 版本：1.0
 * 日期：2011-11-03
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究商银信接口使用，只是提供一个参考。
	
 * 提示：如何获取安全校验码和商户号
 * 1.致电商银信客服热线（400-620-7575）进行咨询

 */
 
//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//商户id
$allscore_config['merchantId']      = '001015013101118';

//安全检验码，以数字和字母组成的32位字符
$allscore_config['key']          = '22c531a0d83a46b0988ffdb038646b5b';

//页面跳转同步通知页面路径，要用 http://格式的完整路径，不允许加?id=123这类自定义参数
//return_url的域名不能写成http://localhost/allscoreutf8/return_url.php ，否则会导致return_url执行无效
$allscore_config['return_url']   = 'http://test.allscore.com/allscoreutf8/return_url.php';

//服务器异步通知页面路径，要用 http://格式的完整路径，不允许加?id=123这类自定义参数
//$allscore_config['notify_url']   = 'http://www.xxx.com/allscoreutf8/notify_url.php';
$allscore_config['notify_url']   = 'http://test.allscore.com/allscoreutf8/notify_url.php';

//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

//字符编码格式 目前支持 utf-8
$allscore_config['input_charset']= 'UTF-8';

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$allscore_config['transport']    = 'http';


$allscore_config['AllscorePublicKey']='key/allscore_public_key.pem';
$allscore_config['MerchantPrivateKey']='key/rsa_private_key.pem';


$allscore_config['request_gateway'] = 'http://119.61.12.89:8090/olgateway/serviceDirect.htm?';    //网关地址
$allscore_config['query_gateway']='http://119.61.12.89:8090/olgateway/orderQuery.htm?';   //查询网关地址
$allscore_config['bank_refund_gateway']='http://119.61.12.89:8090/olgateway/partRefund.htm?';  //纯网银退货网关地址
$allscore_config['quick_refund_gateway']='http://119.61.12.89:8090/olgateway/refund.htm?';//快捷退货地址

$allscore_config['http_verify_url'] = 'http://192.168.88.108:8090/olgateway/noticeQuery.htm?';  //http通知验证地址
$allscore_config['https_verify_url'] = 'https://paymenta.allscore.com/olgateway/noticeQuery.htm?';  //https通知验证地址

?>