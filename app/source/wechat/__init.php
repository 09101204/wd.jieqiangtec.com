<?php
/**
 * weixin sharesale
 * Weizan isNOT a free software, it under the license terms, wiexin.
 */
defined('IN_IA') or exit('Access Denied');
checkauth();
load()->model('coupon');
load()->classs('coupon');
if(empty($_W['acid'])) {
	message('acid不存在', referer(), 'error');
}



