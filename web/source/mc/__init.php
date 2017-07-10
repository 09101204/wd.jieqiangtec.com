<?php
/**
 * weixin sharesale
 * wiexin, it under the license terms, wiexin.
 */
if ($do == 'oauth' || $action == 'credit' || $action == 'passport' || $action == 'uc') {
	define('FRAME', 'setting');
} else {
	define('FRAME', 'mc');
}

if($action == 'stat') {
	define('ACTIVE_FRAME_URL', url('mc/trade'));
}
$frames = buildframes(array(FRAME));
$frames = $frames[FRAME];
