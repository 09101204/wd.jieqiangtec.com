<?php

error_reporting(all);
include_once 'AopSdk.php';

write('写日志========');

//第三方应用授权
//https://doc.open.alipay.com/doc2/detail?treeId=216&articleId=105193&docType=1#
//商户对开发者进行应用授权后，开发者可以帮助商户完成相应的业务逻辑，例如代替商户发起当面付的收单请求。
//授权采用标准的OAuth 2.0流程。
//要进行第三方调用，商户和开发者都需要申请开通相应的权限（例如对于当面付，开发者和商户都需要开通“当面付”，开发者才能帮助商户发起当面付的收单请求）。

//第四步：获取app_auth_code
//商户授权成功后，pc或者钱包客户端会跳转至开发者定义的回调页面（即redirect_uri参数对应的url），在回调页面请求中会带上当次授权的授权码app_auth_code和开发者的app_id，示例如下：
//http://example.com/doc/toAuthPage.html?app_id=2015101400446982&app_auth_code=ca34ea491e7146cc87d25fca24c4cD11

//http://wd.jieqiangtec.com/aliapi/?app_id=2016090301845995&source=alipay_app_auth&app_auth_code=3ce54d3169d9478897272bed6d116F00

//$app_auth_code = $_GET['app_auth_code'];
$app_auth_code = '3ce54d3169d9478897272bed6d116F00';

$aop = new AopClient ();
$aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
//$aop->appId = '2016090301845995';//  mydemo2016
//$aop->appId = '2016082901817086'; // 口碑VR全景
//$aop->appId = '2016082001777808'; // 口碑VR全景  厦门蚝友绘餐饮管理有限公司  2016081900077000000018140711
//$aop->appId = '2016090401848785'; // 口碑VR全景  厦门蚝友绘餐饮管理有限公司  2016081900077000000018140711
$aop->appId = '2016090301845995'; // jieqianagVR全景  厦门蚝友绘餐饮管理有限公司  2016081900077000000018140711
//$aop->appId = '2016072300102331'; // 沙箱测试应用2016072300102331
//$aop->appId = '2016072400106015'; // 沙箱测试应用2016072300102331
$aop->rsaPrivateKeyFilePath = './rsa_private_key.pem';
$aop->alipayPublicKey='./rsa_public_key.pem';
$aop->apiVersion = '1.0';
//$aop->postCharset='GBK';
$aop->format='json';

var_dump($_GET['request']);
if ($_GET['request']==1) {
	var_dump(111);
	//alipay.marketing.cdp.advertise.query (查询广告接口);
	$request = new AlipayMarketingCdpAdvertiseQueryRequest ();
	$request->setBizContent("{" .
"    \"ad_id\":\"100\"" .
"  }");
}elseif ($_GET['request']==2) {
	var_dump(222);
	//alipay.marketing.cdp.advertise.operate (操作广告接口)
	$request = new AlipayMarketingCdpAdvertiseOperateRequest ();
	$request->setBizContent("{" .
"    \"ad_id\":\"100\"," .
"    \"operate_type\":\"online\"" .
"  }");

}elseif ($_GET['request']==3) {
	var_dump(333);
	//alipay.marketing.cdp.advertise.modify (修改广告接口)
	$request = new AlipayMarketingCdpAdvertiseModifyRequest ();
	$request->setBizContent("{" .
"    \"ad_id\":\"100\"," .
"    \"content\":\"https://m.alipay.com/J/dfdf\"," .
"    \"action_url\":\"https://m.alipay.com/J/dfdf\"," .
"    \"height\":\"100\"," .
"    \"start_time\":\"2016-02-24 12:12:12\"," .
"    \"end_time\":\"2017-02-24 12:12:12\"" .
"  }");
}elseif ($_GET['request']==4) {
	var_dump(444);
	//alipay.marketing.cdp.advertise.query (查询广告接口);
	$request = new AlipayMarketingCdpAdvertiseQueryRequest ();
	$request->setBizContent("{" .
"    \"ad_id\":\"100\"" .
"  }");
}elseif ($_GET['request']==5) {
	var_dump(444);
	$request = new AlipayOpenAuthTokenAppQueryRequest ();
$request->setBizContent("{" .
"    \"app_auth_token\":\"201609BBa5968983a60f462b9d6c7355366f2D00\"" .
"  }");
}else {
	var_dump(555);
	//	alipay.marketing.cdp.advertise.create (创建广告接口)
	//"    \"ad_rules\":\"{\\\"shop_id\\\":[\\\"2015090800077000000002549828\\\"]}\"," .
	//	$request = new AlipayOpenPublicTemplateMessageIndustryModifyRequest ();
	//	$request = new AlipayUserUserinfoShareRequest ();
	$request = new AlipayOpenAuthTokenAppRequest ();
	//	$request->setBizContent("{" .
	//"    \"grant_type\":\"authorization_code\"," .
	//"    \"code\":\"{$app_auth_code}\"," .
	//"  }");

	$request->setBizContent("{" .
"    \"grant_type\":\"authorization_code\"," .
"     \"code\":\"{$app_auth_code}\"," .
"  }");

}
//write('request========'.$request);
//write('result========'.$result);

//var_dump($request);
//write('请求值request========'.$request);

$result = $aop->execute ( $request);
var_dump($result);

write('返回值result========'.$result);



function write($message, $destination = '') {
	$now = date ( 'Y-m-d H:i:s' );
	// 文件方式记录日志
	if (empty ( $destination )){
		//		$destination = 'D:\WWW\aliapi/data/logs/'. date ( 'y_m_d' ) . '.log';
		$destination = './data/logs/'. date ( 'y_m_d' ) . '.log';
	}

	//	var_dump($destination);exit;

	// 检测日志文件大小，超过配置大小则备份日志文件重新生成
	if (is_file ( $destination ) && floor ( '2097152' ) <= filesize ( $destination )){
		rename ( $destination, dirname ( $destination ) . '/' . time () . '-' . basename ( $destination ) );
	}
	$request = json_encode($_REQUEST);
	$message = $request.'========='.$message;
	error_log ( "{$now} : {$message}\r\n",3, $destination );
	// clearstatcache();
}

