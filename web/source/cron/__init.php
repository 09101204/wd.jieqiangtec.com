<?php
/**
 * [WeiZan System] Copyright (c) 2014 WeiZan.Com
 * WeiZan is NOT a free software, it under the license terms, wiexin.
 */
if($action != 'entry') {
	define('FRAME', 'setting');
	$frames = buildframes(array(FRAME));
	$frames = $frames[FRAME];
}
