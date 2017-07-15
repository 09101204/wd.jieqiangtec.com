<?php
/**

 */
require './framework/bootstrap.inc.php';
$host = $_SERVER['HTTP_HOST'];


if (!empty($host)) {
	$bindhost = pdo_fetch("SELECT * FROM ".tablename('site_multi')." WHERE bindhost = :bindhost", array(':bindhost' => $host));
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