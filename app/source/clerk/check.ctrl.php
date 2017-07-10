<?php
/**
 * [WEIXIN System] Copyright (c) 2015 012WZ.COM
 * WeiZan is NOT a free software, it under the license terms, wiexin.
 */
defined('IN_IA') or exit('Access Denied');
$dos = array('check');
$do = in_array($do, $dos) ? $do : 'check';

if($do == 'check') {
	template('clerk/check');
}