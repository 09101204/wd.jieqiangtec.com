<?php
/**
 * [WECHAT 2017]
 * [WECHAT  a free software]
 */
defined('IN_IA') or exit('Access Denied');
if($do=='mass'){
	$id=intval($_GPC['id']);
	$send=pdo_get('mc_mass_record',array('id'=>$id));
	$media = pdo_get('wechat_attachment', array('uniacid' => $_W['uniacid'], 'id' => $send['attach_id']));
	if(empty($media)) {
		exit('�زĲ����ڻ��Ѿ�ɾ��');
	}
	$media_id = trim($media['media_id']);
	$acc = WeAccount::create();
	$data = $acc->fansSendAll($send['group'], $send['msgtype'], $media_id);
	if(is_error($data)){
		exit($data['message']);
	}
	pdo_update('mc_mass_record',array('status'=>0),array('id'=>$id));
	exit('mass success');
}
exit('end');

