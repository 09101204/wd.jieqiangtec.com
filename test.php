<?php
/**

 */
require './framework/bootstrap.inc.php';
$host = $_SERVER['HTTP_HOST'];


$_SESSION['prom']['item_id'] = 25;
$_SESSION['prom']['order_id'] = 63;

$_SESSION['prom']['shop_id'] = '11';

$_SESSION['prom']['m'] = 'desk';
$_SESSION['prom']['a'] = 'buy';
$_SESSION['prom']['bank_id'] = '13';

$_SESSION['prom']['status'] = '1';

$res = http_request('http://cps.adjyc.com/cps.php',$_SESSION['prom']);
var_dump($res);
exit;


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