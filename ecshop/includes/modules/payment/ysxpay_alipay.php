<?php

/**
 * ECSHOP 银商信插件
 * $Author: liubo $
 * $Id: alipay.php 17217 2011-01-19 06:29:08Z liubo $
 */
if(! defined('IN_ECS')){
	die('Hacking attempt');
}

// $payment_lang = ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/payment/alipay.php';
$payment_lang = ROOT_PATH . 'languages/' . $GLOBALS['_CFG']['lang'] . '/payment/ysxpay_alipay.php';

if(file_exists($payment_lang)){
	global $_LANG;
	include_once ($payment_lang);
}

/* 模块的基本信息 */
if(isset($set_modules) && $set_modules == TRUE){
	$i = isset($modules) ? count($modules) : 0;

	/* 代码 */
	$modules[$i]['code'] = basename(__FILE__, '.php');

	/* 描述对应的语言项 */
	$modules[$i]['desc'] = 'ysxpay_desc';

	/* 是否支持货到付款 */
	$modules[$i]['is_cod'] = '0';

	/* 是否支持在线支付 */
	$modules[$i]['is_online'] = '1';

	/* 作者 */
	$modules[$i]['author'] = 'ECSHOP TEAM222';

	/* 网址 */
	$modules[$i]['website'] = 'http://www.alipay.com';

	/* 版本号 */
	$modules[$i]['version'] = '1.0.2';

	/* 配置信息 */
	$modules[$i]['config'] = array(
	array(
					'name' => 'ysxpay_account',
					'type' => 'text',
					'value' => '001015013101118' 
					),
					array(
					'name' => 'ysxpay_key',
					'type' => 'text',
					'value' => '22c531a0d83a46b0988ffdb038646b5b' 
					),
					array(
					'name' => 'ysxpay_request_gateway',
					'type' => 'text',
					'value' => 'http://58.132.206.38:8090/olgateway/scan/scanPay.htm?' 
					),
					array(
					'name' => 'ysxpay_http_verify_url',
					'type' => 'text',
					'value' => 'http://58.132.206.38:8090/olgateway/noticeQuery.htm?' 
					)
					);
					return;
}

/**
 * 类
 */
class ysxpay_alipay{

	/**
	 * 构造函数
	 *
	 * @access public
	 * @param
	 *
	 * @return void
	 */
	function alipay(){
	}
	function __construct(){
		$this->alipay();
	}

	/**
	 * 生成支付代码
	 *
	 * @param array $order 订单信息
	 * @param array $payment 支付方式信息
	 */
	function get_code($order, $payment){
		if(! defined('EC_CHARSET')){
			$charset = 'utf-8';
		} else{
			$charset = EC_CHARSET;
		}

		/**
		 * ************************请求参数*************************
		 */
		// 商户id
		$allscore_config['merchantId'] = $payment['ysxpay_account']; // '001015013101118'
		// 安全检验码，以数字和字母组成的32位字符
		$allscore_config['key'] = $payment['ysxpay_key']; // '22c531a0d83a46b0988ffdb038646b5b';
		// 页面跳转同步通知页面路径，要用 http://格式的完整路径，不允许加?id=123这类自定义参数
		$allscore_config['return_url'] = return_url(basename(__FILE__, '.php')); // 通知接收URL(本地测试时，服务器返回无法测试);
		// 服务器异步通知页面路径，要用 http://格式的完整路径，不允许加?id=123这类自定义参数
		$allscore_config['notify_url'] = return_url(basename(__FILE__, '.php')); // 通知接收URL(本地测试时，服务器返回无法测试);
			
		// ↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
			
		// 字符编码格式 目前支持 utf-8
		$allscore_config['input_charset'] = 'UTF-8';

		// 访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
		$allscore_config['transport'] = 'http';

		$allscore_config['AllscorePublicKey'] = 'key/allscore_public_key.pem';
		$allscore_config['MerchantPrivateKey'] = 'key/rsa_private_key.pem';

		$allscore_config['request_gateway'] = $payment['ysxpay_request_gateway']; // 网关地址
		$allscore_config['http_verify_url'] = $payment['ysxpay_http_verify_url']; // http通知验证地址
			
		// 必填参数
		$service = "directPay"; // 快速付款交易服务（不可以修改）
		$inputCharset = trim($allscore_config['input_charset']); // （不可以修改）
		$merchantId = $allscore_config['merchantId']; // 商户号(商银信公司提供)
		$key = trim($allscore_config['key']); // 安全密钥(商银信公司提供)

		// //商户网站订单（也就是外部订单号，是通过客户网站传给商银信系统，不可以重复）
		$outOrderId = $order['order_sn'] . '-' . $order['order_id'] . '-' . rand(100, 999);
		$subject = get_goods_name_by_id($order['order_id']);
		// 商品描述，推荐格式：商品名称（订单编号：订单编号）
		$body = $subject;
		// 订单总价
		$transAmt = $order['order_amount'];
		$notifyUrl = return_url(basename(__FILE__, '.php')); // 通知接收URL(本地测试时，服务器返回无法测试)
		$returnUrl = return_url(basename(__FILE__, '.php')); // 支付完成后跳转返回的网址URL
		$detailUrl = return_url(basename(__FILE__, '.php'));
		if ($_SESSION['user_id']) {
			$outAcctId = $_SESSION['user_id'];
		}else{
			$outAcctId = 1;
		}

		//		$payMethod = 'commonPay';//目前只有allscorePay(商银信支付)
		//		$payMethod = 'default_wechat';//目前只有allscorePay(商银信支付)
		$payMethod = 'default_alipay';//目前只有allscorePay(商银信支付)

		$channel = 'B2C';
		$certType = 'debit';
		$cardAttr = '01';
		$signType = 'MD5';

		if($signType == 'MD5'){
			$notifyUrl = $notifyUrl;
			$returnUrl = $returnUrl;
		} else{
			$notifyUrl = $notifyUrl . "notify_url_rsa.php";
			$returnUrl = $returnUrl . "return_url_rsa.php";
		}



		$parameter = array(
					"ip" => $_SERVER['REMOTE_ADDR'], //
		//"ip" => '127.0.0.1', //
					"detailUrl" => $detailUrl, //
					"service" => $service, //
					"inputCharset" => $inputCharset, //
					"merchantId" => $merchantId, //
					"payMethod" => $payMethod, //

					"outOrderId" => $outOrderId, //
					"subject" => $subject, //
					"body" => $body, //
					"transAmt" => $transAmt, //

					"returnUrl" => $returnUrl, // TODO 可以屏蔽同步回调
					"signType" => $signType, //
					"notifyUrl" => $notifyUrl, // TODO 可以屏蔽异步回调
		//					"notifyUrl" => $notifyUrl, // TODO 可以屏蔽异步回调

					"outAcctId" => $outAcctId 
		);

		// 构造快捷支付接口
		$allscoreService = new AllscoreService($allscore_config);
		//echo $html_text;
		ini_set('user_agent','Mozilla/5.0 (Windows NT 6.1; rv:14.0) Gecko/20100101 Firefox/14.0.2');
		$ItemUrl = $allscoreService->createScankUrl($parameter);
		//得到XML格式返回数据
		$xml = file_get_contents($ItemUrl);
		//创建一个返回数组
		$result = array();
		//将XML转换成数组
		$resultCode = $allscoreService->xmlToArray($xml);
		//判断是否成功
		$scanCode;
		$signFlag=true;
		if($resultCode['reCode'] == "SUCCESS"){
			$scanCode = $resultCode['payCode'];
			$resultCode['message'] = urldecode($resultCode['message']);
			//logResult("resultCode=".print_r($resultCode,1));
			//验签
			$signFlag=true;
			//logResult("=======================".$parameter['signType']);
			if($parameter['signType'] == "RSA"){
				$pubKey = $allscore_config['AllscorePublicKey'];
				//logResult("pubKey=============".$pubKey);
				$signFlag = verifyRSA($resultCode, $resultCode['sign'],$pubKey);
				//logResult("signFlag=============".$signFlag);
			}elseif($parameter['signType'] == "MD5"){
				$key = $allscore_config['key'];
				$signFlag = $allscoreService->verifySign($resultCode, $resultCode['sign'], $key);
				//logResult("signFlag=============".$signFlag);
			}
			//logResult("signFlag=".$signFlag);
			//验签失败
			if($signFlag != 1){
				$err = urlencode("验证签名失败");
				$result['scancode'] = $err;
				$result['xml'] = $xml;
				$json = json_encode($result);
				echo json_encode($json);
			}

		}else{
			$scanCode = $resultCode['message'];
		}

		//logResult("scanCode=".$scanCode);
		$result['scancode'] = $scanCode;
		$result['message'] = urldecode($resultCode['message']);
		//logResult("result=".print_r($result,1));
		$result['xml'] = $xml;


		// TODO 日志记录
		logResult('file in ysxpay_alipay json_encode($parameter)===' . json_encode($parameter));
		logResult('file in ysxpay_alipay $ItemUrl===' .$ItemUrl);
		//		include 'phpqrcode.php';
		//		$qrCode = QRcode::png($scanCode,false,0,5);

		// 生成二维码 更改域名地址
		$ItemUrl = "http://{$_SERVER['SERVER_NAME']}/ecshop/pay.php?qrcode=$scanCode ";
		$button = '<div style="text-align:center"><input type="button" onclick="window.open(\'' . $ItemUrl.'\')" value="' . $GLOBALS['_LANG']['pay_button'] . '" /></div>';

		return $button;
	}

	/**
	 * 响应操作
	 */
	function respond(){
		// TODO 日志记录
		logResult('file in ysxpay_alipay json_encode($_REQUEST)===' . json_encode($_REQUEST));
		logResult('file in ysxpay_alipay json_encode($_POST)===' . json_encode($_POST));
		logResult('file in ysxpay_alipay json_encode($_GET)===' . json_encode($_GET));

		/*
		 * 配置文件
		 * 版本：1.0
		 * 日期：2011-11-03
		 * 说明：
		 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
		 * 该代码仅供学习和研究商银信接口使用，只是提供一个参考。
		 * 提示：如何获取安全校验码和商户号
		 * 1.致电商银信客服热线（400-620-7575）进行咨询
		 */

		// $payment = payment_info(7);
		$payment = get_payment($_GET['code']);
		// TODO 日志记录
		logResult('file in ysxpay_alipay json_encode($payment)===' . json_encode($payment));


		// ↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
		// 商户id
		$allscore_config['merchantId'] = $payment['ysxpay_account']; // '001015013101118'
			
		// 安全检验码，以数字和字母组成的32位字符
		$allscore_config['key'] = $payment['ysxpay_key']; // '22c531a0d83a46b0988ffdb038646b5b';

		// 页面跳转同步通知页面路径，要用 http://格式的完整路径，不允许加?id=123这类自定义参数
		$allscore_config['return_url'] = return_url(basename(__FILE__, '.php')); // 通知接收URL(本地测试时，服务器返回无法测试);
			
		// 服务器异步通知页面路径，要用 http://格式的完整路径，不允许加?id=123这类自定义参数
		$allscore_config['notify_url'] = return_url(basename(__FILE__, '.php')); // 通知接收URL(本地测试时，服务器返回无法测试);
			
		// ↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
			
		// 字符编码格式 目前支持 utf-8
		$allscore_config['input_charset'] = 'UTF-8';

		// 访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
		$allscore_config['transport'] = 'http';

		$allscore_config['AllscorePublicKey'] = 'key/allscore_public_key.pem';
		$allscore_config['MerchantPrivateKey'] = 'key/rsa_private_key.pem';

		$allscore_config['request_gateway'] = $payment['ysxpay_request_gateway']; // 网关地址
		$allscore_config['http_verify_url'] = $payment['ysxpay_http_verify_url']; // http通知验证地址
			
		// TODO　测试
		logResult('回调支付配置$allscore_config====' . json_encode($allscore_config));

		// 计算得出通知验证结果
		$allscoreNotify = new AllscoreNotify($allscore_config);

		$out_trade_no = $_REQUEST['outOrderId']; // 获取订单号

		// 同步回调,只做展示
		if($_GET['tradeStatus'] == '2'){ // 交易成功结束
			$log_id = explode('-', $out_trade_no);
			logResult('同步回调支付成功，订单为$log_id====' . $log_id[1]);
			// 调试用，写文本函数记录程序运行情况是否正常
			$verify_result = $allscoreNotify->verifyReturn();

			return true;
			echo "success"; // 请不要修改或删除

			exit();
		}

		// 异步回调，逻辑处理
		$verify_result = $allscoreNotify->verifyNotify();


		if($verify_result){ // 验证成功

			// ——请根据您的业务逻辑来编写程序

			//			$out_trade_no = $_REQUEST['outOrderId']; // 获取订单号
			$total_fee = $_REQUEST['transAmt']; // 获取总价格
			$subject = $_REQUEST['subject'];
			$body = $_REQUEST['body'];

			if($_REQUEST['tradeStatus'] == '2'){ // 交易成功结束
				/* 改变订单状态 */
				$log_id = explode('-', $out_trade_no);
				order_paid($log_id[1], 2);
				logResult('异步回调支付成功，订单为$log_id====' . $log_id[1]);

				return true;

				echo "success"; // 请不要修改或删除
					
			} else{
				echo "success"; // 其他状态判断。普通即时到帐中，其他状态不用判断，直接打印success。
			}
		} else{
			// 验证失败
			echo "fail";

			// 调试用，写文本函数记录程序运行情况是否正常
			// logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
			logResult('支付失败$_REQUEST====' . $verify_result);
			logResult('支付失败$_REQUEST====' . json_encode($_REQUEST));
			logResult('支付失败$_POST====' . json_encode($_POST));
			logResult('支付失败$_GET====' . json_encode($_GET));
		}
	}
}

/*
 * 商银信接口公用函数
 * 详细：该类是请求、通知返回两个文件所调用的公用函数核心处理文件
 */

class AllscoreSubmit{
	/**
	 * 生成要请求给商银信的参数数组
	 *
	 * @param $para_temp 请求前的参数数组
	 * @param $allscore_config 基本配置信息数组
	 * @return 要请求的参数数组
	 */
	function buildRequestPara($para_temp, $allscore_config){
		// 构造快捷支付接口
		$allscoreService = new AllscoreService($allscore_config);
		// 除去待签名参数数组中的空值和签名参数
		$para_filter = $allscoreService->paraFilter($para_temp);

		// 对待签名参数数组排序
		$para_sort = $allscoreService->argSort($para_filter);

		if($para_temp['signType'] == 'MD5'){

			// 生成签名结果
			$mysign = $allscoreService->buildMysign($para_sort, trim($allscore_config['key']));
		} else{
			// 生成签名结果
			$mysign = $allscoreService->buildMysignRSA($para_sort, trim($allscore_config['MerchantPrivateKey']));
		}

		// 签名结果与签名方式加入请求提交参数组中
		$para_sort['sign'] = $mysign;
		$para_sort['signType'] = $para_temp['signType'];

		return $para_sort;
	}

	/**
	 * 生成要请求给商银信的参数数组
	 *
	 * @param $para_temp 请求前的参数数组
	 * @param $allscore_config 基本配置信息数组
	 * @return 要请求的参数数组字符串
	 */
	function buildRequestParaToString($para_temp, $allscore_config){
		// 待请求参数数组
		$para = $this->buildRequestPara($para_temp, $allscore_config);

		// 把参数组中所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
		// 构造快捷支付接口
		$allscoreService = new AllscoreService($allscore_config);
		$request_data = $allscoreService->createLinkstring($para);

		return $request_data;
	}

	/**
	 * 生成要请求给商银信的URL地址
	 *
	 * @param $para_temp 请求前的参数数组
	 * @param $allscore_config 基本配置信息数组
	 * @return 要请求的URL地址
	 */
	function buildRequestUrl($gateway, $para_temp, $allscore_config){
		// 待请求参数数组
		$para = $this->buildRequestPara($para_temp, $allscore_config);

		// 把参数组中所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
		// 构造快捷支付接口
		$allscoreService = new AllscoreService($allscore_config);
		$request_data = $allscoreService->createLinkEncode($para);

		return $gateway . $request_data;
	}

	/**
	 * 构造提交表单HTML数据
	 *
	 * @param $para_temp 请求参数数组
	 * @param $gateway 网关地址
	 * @param $method 提交方式。两个值可选：post、get
	 * @param $button_name 确认按钮显示文字
	 * @return 提交表单HTML文本
	 */
	function buildForm($para_temp, $gateway, $method, $button_name, $allscore_config){
		// 待请求参数数组
		$para = $this->buildRequestPara($para_temp, $allscore_config);

		$sHtml = "<form id='allscoresubmit' name='allscoresubmit' action='" . $gateway . "' method='" . $method . "'>";

		foreach( $para as $key => $value){
			$sHtml .= "<input type='hidden' name='" . $key . "' value='" . $value . "'/>";
		}
		// submit按钮控件请不要含有name属性
		$sHtml = $sHtml . "<input type='submit' value='" . $button_name . "'></form>";

		// $sHtml = $sHtml."<script>document.forms['allscoresubmit'].submit();</script>";

		return $sHtml;
	}

	/**
	 * 构造自动提交表单HTML数据
	 *
	 * @param $para_temp 请求参数数组
	 * @param $gateway 网关地址
	 * @param $method 提交方式。两个值可选：post、get
	 * @param $button_name 确认按钮显示文字
	 * @return 提交表单HTML文本
	 */
	function buildAutoForm($para_temp, $gateway, $method, $button_name, $allscore_config){
		// 待请求参数数组
		$para = $this->buildRequestPara($para_temp, $allscore_config);

		$sHtml = "<form id='allscoresubmit' name='allscoresubmit' action='" . $gateway . "' method='" . $method . "'>";

		foreach( $para as $key => $value){
			$sHtml .= "<input type='hidden' name='" . $key . "' value='" . $value . "'/>";
		}
		// submit按钮控件请不要含有name属性
		$sHtml = $sHtml . "<input type='submit' value='" . $button_name . "'></form>";

		$sHtml = $sHtml . "<script>document.forms['allscoresubmit'].submit();</script>";

		return $sHtml;
	}
}

// 商银信接口公用函数 移动到service类中，否则后台配置出错 重复定义
class AllscoreService{
	var $allscore_config;
	/**
	 * 商银信网关地址
	 */
	function __construct($allscore_config){
		$this->allscore_config = $allscore_config;
	}
	function AllscoreService($allscore_config){
		$this->__construct($allscore_config);
	}


	/**
	 * 构造扫码提交地址
	 * @param $para_temp 请求参数数组
	 * @return 表单提交地址
	 */
	function createScankUrl($para_temp) {

		//生成提交地址
		$allscoreSubmit = new AllscoreSubmit();
		$ItemUrl = $allscoreSubmit->buildRequestUrl($this->allscore_config['request_gateway'],$para_temp,$this->allscore_config);
		logResult("ItemUrl222222=".$ItemUrl);
		return $ItemUrl;
	}

	/**
	 * 构造商银信其他接口
	 *
	 * @param $para_temp 请求参数数组
	 * @return 表单提交HTML信息
	 */
	function allscore_interface($para_temp){
		// 获取远程数据
		$allscoreSubmit = new AllscoreSubmit();
		$html_text = "";

		return $html_text;
	}

	/*
	 * 商银信接口公用函数 移动到service类中，否则后台配置出错 重复定义
	 * 详细：该类是请求、通知返回两个文件所调用的公用函数核心处理文件
	 */

	/**
	 * MD5验签
	 * @param privateKeyStr 私钥
	 * @param data 加密字符串
	 * @return String 密文数据
	 */
	function verifySign($para_temp , $sign , $key){

		//除去待签名参数数组中的空值和签名参数
		$para_filter = $this->paraFilter($para_temp);

		//对待签名参数数组排序
		$para_sort = $this->argSort($para_filter);

		//生成签名结果
		$mysign = $this->buildMysign($para_sort, $key);

		if ($mysign == $sign) {
			return true;
		} else {
			return false;
		}
	}



	// Xml 转 数组, 不包括根键
	function xmlToArray( $xml ){
		$arr = $this->xml_to_array($xml);
		$key = array_keys($arr);
		return $arr[$key[0]];
	}
	// Xml 转 数组, 包括根键
	function xml_to_array( $xml ){
		$reg = "/<(\\w+)[^>]*?>([\\x00-\\xFF]*?)<\\/\\1>/";
		if(preg_match_all($reg, $xml, $matches))
		{
			$count = count($matches[0]);
			$arr = array();
			for($i = 0; $i < $count; $i++)
			{
				$key= $matches[1][$i];
				$val = $this->xml_to_array( $matches[2][$i] );  // 递归
				if(array_key_exists($key, $arr))
				{
					if(is_array($arr[$key]))
					{
						if(!array_key_exists(0,$arr[$key]))
						{
							$arr[$key] = array($arr[$key]);
						}
					}else{
						$arr[$key] = array($arr[$key]);
					}
					$arr[$key][] = $val;
				}else{
					$arr[$key] = $val;
				}
			}
			return $arr;
		}else{
			return $xml;
		}
	}

	/**
	 * 生成签名结果
	 *
	 * @param $sort_para 要签名的数组
	 * @param $key 商银信分配给商户的密钥
	 * @param $sign_type 签名类型 默认值：MD5
	 * return 签名结果字符串
	 */
	function buildMysign($sort_para, $key){
		// 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
		$prestr = $this->createLinkstring($sort_para);
		// 把拼接后的字符串再与安全校验码直接连接起来
		$prestr = $prestr . $key;
		// 把最终的字符串签名，获得签名结果

		$mysgin =$this->signMD5($prestr);
		return $mysgin;
	}


	/**
	 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
	 *
	 * @param $para 需要拼接的数组 return 拼接完成以后的字符串
	 */
	function createLinkstring($para){
		$arg = "";
		while( list( $key, $val ) = each($para) ){
			$arg .= $key . "=" . $val . "&";
		}
		// 去掉最后一个&字符
		$arg = substr($arg, 0, count($arg) - 2);

		// 如果存在转义字符，那么去掉转义
		if(get_magic_quotes_gpc()){
			$arg = stripslashes($arg);
		}

		return $arg;
	}

	/**
	 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
	 *
	 * @param $para 需要拼接的数组 return 拼接完成以后的字符串
	 */
	function createLinkEncode($para){
		$arg = "";
		while( list( $key, $val ) = each($para) ){
			$arg .= $key . "=" . urlencode($val) . "&";
		}
		// 去掉最后一个&字符
		$arg = substr($arg, 0, count($arg) - 2);

		// 如果存在转义字符，那么去掉转义
		if(get_magic_quotes_gpc()){
			$arg = stripslashes($arg);
		}

		return $arg;
	}

	/**
	 * 除去数组中的空值和签名参数
	 *
	 * @param $para 签名参数组 return 去掉空值与签名参数后的新签名参数组
	 */
	function paraFilter($para){
		$para_filter = array();
		while( list( $key, $val ) = each($para) ){
			if($key == "sign" || $key == "signType" || $val == "")
			continue;
			else
			$para_filter[$key] = $para[$key];
		}
		return $para_filter;
	}
	/**
	 * 对数组排序
	 *
	 * @param $para 排序前的数组 return 排序后的数组
	 */
	function argSort($para){
		ksort($para);
		reset($para);
		return $para;
	}

	/**
	 * 签名字符串
	 *
	 * @param $prestr 需要签名的字符串
	 * @param $signType 签名类型 默认值：MD5
	 * return 签名结果
	 */
	function signMD5($prestr){
		$sign = '';
		$sign = md5($prestr);
		return $sign;
	}

	/**
	 * 写日志，方便测试（看网站需求，也可以改成把记录存入数据库）
	 * 注意：服务器需要开通fopen配置
	 *
	 * @param $word 要写入日志里的文本内容 默认值：空值
	 */
	function logResult($word = ''){
		//	$fp = fopen("log.txt", "a");
		$date = date('Ymd');
		$fp = fopen("log_{$date}.log", "a");
		flock($fp, LOCK_EX);
		//	fwrite($fp, "执行日期：" . strftime("%Y%m%d%H%M%S", time()) . "\n" . $word . "\n");

		$time =date('YmdHis') ;
		fwrite($fp, "执行时间： {$time} \n" . $word . "\n");
		flock($fp, LOCK_UN);
		fclose($fp);
	}



	/**
	 * 远程获取数据
	 * 注意：该函数的功能可以用curl来实现和代替。curl需自行编写。
	 * $url 指定URL完整路径地址
	 *
	 * @param $input_charset 编码格式。默认值：空值
	 * @param $time_out 超时时间。默认值：60 return 远程输出的数据
	 */
	function getHttpResponse($url, $input_charset = '', $time_out = "60"){
		$urlarr = parse_url($url);
		$errno = "";
		$errstr = "";
		$transports = "";
		$responseText = "";
		if($urlarr["scheme"] == "https"){
			$transports = "ssl://";
			$urlarr["port"] = "443";
		} else{
			$transports = "tcp://";
			$urlarr["port"] = "8090";
		}
		$fp = @fsockopen($transports . $urlarr['host'], $urlarr['port'], $errno, $errstr, $time_out);
		if(! $fp){
			die("ERROR: $errno - $errstr<br />\n");
		} else{
			if(trim($input_charset) == ''){
				fputs($fp, "POST " . $urlarr["path"] . " HTTP/1.1\r\n");
			} else{
				fputs($fp, "POST " . $urlarr["path"] . '?_input_charset=' . $input_charset . " HTTP/1.1\r\n");
			}
			fputs($fp, "Host: " . $urlarr["host"] . "\r\n");
			fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
			fputs($fp, "Content-length: " . strlen($urlarr["query"]) . "\r\n");
			fputs($fp, "Connection: close\r\n\r\n");
			fputs($fp, $urlarr["query"] . "\r\n\r\n");
			while( ! feof($fp) ){
				$responseText .= @fgets($fp, 1024);
			}
			fclose($fp);
			$responseText = trim(stristr($responseText, "\r\n\r\n"), "\r\n");

			return $responseText;
		}
	}

}

/*
 * 类名：AllscoreNotify
 * 功能：商银信通知处理类
 * 详细：处理商银信接口通知返回
 * 版本：1.0
 * 日期：2011-11-03
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究商银信接口使用，只是提供一个参考
 * ************************注意*************************
 * 调试通知返回时，可查看或改写log日志的写入TXT里的数据，来检查通知返回是否正常
 */
class AllscoreNotify{
	var $allscore_config;
	function __construct($allscore_config){
		$this->allscore_config = $allscore_config;
	}
	function AllscoreNotify($allscore_config){
		$this->__construct($allscore_config);
	}
	/**
	 * 针对notify_url验证消息是否是商银信发出的合法消息
	 *
	 * @return 验证结果
	 */
	function verifyNotify(){
		// 写日志记录
		$log_text = "回调返回值 验证结果  ============";
		logResult($log_text);
		// 添加GET参数
		// 		$_POST = $_POST ? $_POST : $_GET;
		if(empty($_POST)){ // 判断POST来的数组是否为空
			$log_text = "回调返回值 验证结果  no post============";
			logResult($log_text);
			return false;
		} else{
			$log_text = "回调返回值 验证结果  yes post============";
			logResult($log_text);
			// 生成签名结果
			$mysign = $this->getMysign($_POST);
			// 获取商银信远程服务器ATN结果（验证是否是商银信发来的消息）

			$log_text = "回调返回值 验证结果  yes post============111";
			logResult($log_text);

			$responseTxt = 'true';
			if(! empty($_POST["notifyId"])){
				$responseTxt = $this->getResponse($_POST["notifyId"]);
			}

			$log_text = "回调返回值 验证结果  yes post============666";
			logResult($log_text);

			// 写日志记录
			$log_text = "回调返回值 responseTxt=" . $responseTxt . "\n notify_url_log:sign=" . $_POST["sign"] . "&mysign=" . $mysign . ",";
			$log_text = $log_text . createLinkString($_POST);
			logResult($log_text);

			$log_text = "回调返回值 验证结果  yes post============777";
			logResult($log_text);
			// 验证
			// $responsetTxt的结果不是true，与服务器设置问题、商户号、notify_id一分钟失效有关
			// mysign与sign不等，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有关
			if(preg_match("/true$/i", $responseTxt) && $mysign == $_POST["sign"]){
				// if (preg_match("/true$/i",$responseTxt) && $mysign == $_REQUEST["sign"]) {
				$log_text = "回调返回值==匹配成功111111  ";
				return true;
			} else{
				return false;
			}
		}
	}

	/**
	 * 针对return_url验证消息是否是商银信发出的合法消息
	 *
	 * @return 验证结果
	 */
	function verifyReturn(){
		if(empty($_GET)){ // 判断GET来的数组是否为空
			return false;
		} else{
			// 生成签名结果
			$mysign = $this->getMysign($_GET);
			// 获取商银信远程服务器ATN结果（验证是否是商银信发来的消息）
			// echo $mysign;

			$responseTxt = 'true';
			if(! empty($_GET["notifyId"])){
				$responseTxt = $this->getResponse($_GET["notifyId"]);
			}

			// 写日志记录
			$log_text = "同步回调 responseTxt=" . $responseTxt . "\n notify_url_log:sign=" . $_GET["sign"] . "&mysign=" . $mysign . ",";
			$log_text = $log_text . createLinkString($_GET);
			logResult($log_text);

			// 验证
			// $responsetTxt的结果不是true，与服务器设置问题、商户号、notifyId一分钟失效有关
			// mysign与sign不等，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有关
			// TODO 屏蔽
			// 			if(preg_match("/true$/i", $responseTxt) && $mysign == $_GET["sign"]){
			// 				return true;
			// 			} else{
			// 				return false;
			// 			}

			// TODO
			return true;
		}
	}

	/**
	 * 根据反馈回来的信息，生成签名结果
	 *
	 * @param $para_temp 通知返回来的参数数组
	 * @return 生成的签名结果
	 */
	function getMysign($para_temp){
		// 构造快捷支付接口
		$allscoreService = new AllscoreService($allscore_config);
		
		// 除去待签名参数数组中的空值和签名参数
		$para_filter = $allscoreService->paraFilter($para_temp);

		// 对待签名参数数组排序
		$para_sort = $allscoreService->argSort($para_filter);
		
		// 生成签名结果
		$mysign = $allscoreService->buildMysign($para_sort, trim($this->allscore_config['key']));

		return $mysign;
	}

	/**
	 * 获取远程服务器ATN结果,验证返回URL
	 *
	 * @param $nnotifyId 通知校验ID
	 * @return 服务器ATN结果 验证结果集：
	 * invalid命令参数不对 出现这个错误，请检测返回处理中merchantId和key是否为空
	 * true 返回正确信息
	 * false 请检查防火墙或者是服务器阻止端口问题以及验证时间是否超过一分钟
	 */
	function getResponse($notify_id){
		$transport = strtolower(trim($this->allscore_config['transport']));
		$merchantId = trim($this->allscore_config['merchantId']);
		$veryfy_url = '';
		if($transport == 'https'){
			// 			$veryfy_url = $this->allscore_config['https_verify_url'];
			$veryfy_url = $this->allscore_config['http_verify_url'];
		} else{
			$veryfy_url = $this->allscore_config['http_verify_url'];
		}
		$veryfy_url = $veryfy_url . "merchantId=" . $merchantId . "&notifyId=" . $notify_id;

		//		var_dump($veryfy_url);
		// var_dump($veryfy_url);exit;
		ini_set('user_agent','Mozilla/5.0 (Windows NT 6.1; rv:14.0) Gecko/20100101 Firefox/14.0.2');
		$responseTxt = getHttpResponse($veryfy_url);

		return $responseTxt;
	}
}

?>