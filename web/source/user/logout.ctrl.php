<?php
/**
 * [WEIXIN System] Copyright (c) 2015 012WZ.COM
 * WeiZan is NOT a free software, it under the license terms, wiexin.
 */
defined('IN_IA') or exit('Access Denied');
isetcookie('__session', '', -10000);

$forward = $_GPC['forward'];
if(empty($forward)) {
	$forward = './?refersh';
}
header('Location:' . url('account/welcome'));
