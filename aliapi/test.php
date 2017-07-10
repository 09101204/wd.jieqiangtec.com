<?php
include_once 'AopSdk.php';

//商家详情页广告
//https://doc.open.alipay.com/docs/doc.htm?spm=a219a.7629140.0.0.CyRZFp&treeId=213&articleId=105082&docType=1
//商家店铺详情页广告是一个基于口碑提供给商家管理店铺详情页广告的能力，主要是自身店铺的投放，不允许投放到非自身管理的店铺页面内，可提供给商家多种广告形式投放，包含图片和H5链接。


//$aop = new AopClient ();
//$aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
//$aop->appId = 'your app_id';
//$aop->rsaPrivateKeyFilePath = 'merchant_private_key_file';
//$aop->alipayPublicKey='alipay_public_key_file';
//$aop->apiVersion = '1.0';
////$aop->postCharset='GBK';
//$aop->format='json';
//$request = new AlipayMarketingCdpAdvertiseQueryRequest ();
//$request->setBizContent("{" .
//"    \"ad_id\":\"100\"" .
//"  }");
//$result = $aop->execute ( $request)


$aop = new AopClient ();
$aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
//$aop->appId = '2016090301845995';//  mydemo2016
//$aop->appId = '2016082901817086'; // 口碑VR全景
$aop->appId = '2016082001777808'; // 口碑VR全景  厦门蚝友绘餐饮管理有限公司  2016081900077000000018140711
//$aop->appId = '2016072300102331'; // 沙箱测试应用2016072300102331
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
	$result = $aop->execute ( $request);
	var_dump($result);
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
}else {
	var_dump(555);
	//	alipay.marketing.cdp.advertise.create (创建广告接口)
	//"    \"ad_rules\":\"{\\\"shop_id\\\":[\\\"2015090800077000000002549828\\\"]}\"," .
	$request = new AlipayMarketingCdpAdvertiseCreateRequest ();
	$request->setBizContent("{" .
"    \"ad_code\":\"CDP_OPEN_MERCHANT\"," .
"    \"content_type\":\"URL\"," .
"    \"content\":\"https://m.alipay.com/J/fdfd\"," .
"    \"action_url\":\"https://m.alipay.com/J/dfdf\"," .

"    \"ad_rules\":\"{\\\"shop_id\\\":[\\\"2016081900077000000018140711\\\"]}\"," .
"    \"height\":\"100\"," .
"    \"start_time\":\"2016-02-24 12:12:12\"," .
"    \"end_time\":\"2017-02-24 12:12:12\"" .
"  }");
}


var_dump($request);
$result = $aop->execute ( $request);
var_dump($result);
