<?php
/**
 * [WEIXIN System] Copyright (c) 2015 012WZ.COM
 * WeiZan is NOT a free software, it under the license terms, wiexin.
 */

define('FRAME', 'mc');
$frames = buildframes(array('mc'));
$frames = $frames['mc'];

if($controller == 'wechat') {
	if(in_array($action, array('manage', 'card'))) {
		define('ACTIVE_FRAME_URL', url('wechat/manage'));
	}
}
