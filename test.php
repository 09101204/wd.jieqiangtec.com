<?php
/**

 */
require './framework/bootstrap.inc.php';



//$host = $_SERVER['HTTP_HOST'];
//exit;
/**
 * 发送HTTP请求方法
 * @param  string $url    请求URL
 * @param  array  $params 请求参数
 * @param  string $method 请求方法GET/POST
 * @return array  $data   响应数据
 */


/*'id' => string '25' (length=2)
      'sid' => string '1' (length=1)
      'sname' => string 'admin' (length=5)
      'item_id' => string '25' (length=2)
      'push_id' => string '32' (length=2)
      'shop_id' => string '11' (length=2)
      'con_id' => string '5' (length=1)
      'rate' => string '20' (length=2)
      'cate_id' => string '0' (length=1)
      'cate_name' => string '珠宝配饰' (length=12)
      'bank_id' => string '1' (length=1)
      'bank_subid' => string '' (length=0)
      'user_id' => string 'cps平台' (length=9)
    */

/*$_SESSION['prom']['item_id'] = 25;
$_SESSION['prom']['order_id'] = 63;
$_SESSION['prom']['shop_id'] = '11';
$_SESSION['prom']['bank_id'] = '13';*/

//$res =  pdo_insert('stonefish_bigwheel_share', $insertshare);
//var_dump($res);exit;

//$_SESSION['prom']['id'] = '25';
//$_SESSION['prom']['sid'] = '1';
//$_SESSION['prom']['sname'] = 'admin';
//$_SESSION['prom']['item_id'] = '25';
//$_SESSION['prom']['push_id'] = '32';
//$_SESSION['prom']['shop_id'] = '11';
//$_SESSION['prom']['con_id'] = '5';
//$_SESSION['prom']['rate'] = '20';
//$_SESSION['prom']['cate_id'] = '0';
//$_SESSION['prom']['cate_name'] = '珠宝配饰';
//$_SESSION['prom']['bank_id'] = '1';
//$_SESSION['prom']['bank_subid'] = '';
//$_SESSION['prom']['user_id'] = 'cps平台';
//$_SESSION['prom']['m'] = 'desk';
//$_SESSION['prom']['a'] = 'buy';
//$_SESSION['prom']['status'] = '1';

//$_SESSION['prom']['id'] = '25';
$_SESSION['prom']['sid'] = '1';
$_SESSION['prom']['sname'] = 'admin';
$_SESSION['prom']['item_id'] = '25';
$_SESSION['prom']['push_id'] = '32';
$_SESSION['prom']['shop_id'] = '11';
$_SESSION['prom']['con_id'] = '5';
$_SESSION['prom']['rate'] = '20';
$_SESSION['prom']['cate_id'] = '0';
$_SESSION['prom']['cate_name'] = '珠宝配饰';
$_SESSION['prom']['bank_id'] = '1';
$_SESSION['prom']['bank_subid'] = '';
$_SESSION['prom']['user_id'] = 'cps平台';
$_SESSION['prom']['m'] = 'desk';
$_SESSION['prom']['a'] = 'buy';
$_SESSION['prom']['status'] = '1';
$_SESSION['prom']['order_id'] = $_GET['order_id']?:81;

error_log("\n\n 666".$opts[CURLOPT_URL], 3, 'data/logs/curl.txt');

$res = http_request('http://cps.adjyc.com/cps.php',$_SESSION['prom']);
//$res = http_request('http://cps.jieqiangtec.cn/cps.php',$_SESSION['prom']);

var_dump($_SESSION['prom']);
var_dump($res);exit;


//$result = http_request(CPS_API);
var_dump(CPS_API);exit;


if (!empty($host)) {
	$bindhost = pdo_fetch("SELECT * FROM ".tablename('site_multi')." WHERE bindhost = :bindhost", array(':bindhost' => $host));

    $sql = "SELECT * FROM ".tablename('site_multi')." WHERE bindhost = :bindhost";
    $rep =  array(':bindhost' => $host);
    $res = str_replace(':bindhost', (string)$host, $sql, $i);
    var_dump($res);exit;

	if (!empty($bindhost)) {
		header("Location: ". $_W['siteroot'] . 'app/index.php?i='.$bindhost['uniacid'].'&t='.$bindhost['id']);
		exit;
	}
}
WeUtility::logging('TODO debug2',  array('sql'=>$sql,'$params'=>$params));
exit;
var_dump("SELECT * FROM ".tablename('site_multi')." WHERE bindhost = :bindhost", array(':bindhost' => $host));
WeUtility::logging('debug',  array(1,2,3,4,5,6));
exit;
if($_W['os'] == 'mobile' && (!empty($_GPC['i']) || !empty($_SERVER['QUERY_STRING']))) {
	header('Location: ./app/index.php?' . $_SERVER['QUERY_STRING']);
} else {
	header('Location: ./web/index.php?' . $_SERVER['QUERY_STRING']);
}