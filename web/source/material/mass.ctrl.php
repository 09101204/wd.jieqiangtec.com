<?php
/**
 * [WeiZan System] Copyright (c) 2014 WeiZan.Com
 * WeiZan is NOT a free software, it under the license terms, wiexin.
 */
defined('IN_IA') or exit('Access Denied');
uni_user_permission_check('mc_material_display');
$_W['page']['title'] = '定时群发-微信素材';
$dos = array('list', 'post', 'cron', 'modal', 'send');
$do = in_array($do, $dos) ? $do : 'list';

if($do == 'list') {
	set_time_limit(0);
	load()->model('cloud');
	$cloud = cloud_prepare();
	$cloud_error = 0;
	if(is_error($cloud)) {
		$cloud_error = 1;
	}
	$groups = pdo_fetch('SELECT * FROM ' . tablename('mc_fans_groups') . ' WHERE uniacid = :uniacid AND acid = :acid', array(':uniacid' => $_W['uniacid'], ':acid' => $_W['acid']));
	$groups = iunserializer($groups['groups']);
	$time = strtotime(date('Y-m-d'));
	$record = pdo_fetchall('SELECT * FROM ' . tablename('mc_mass_record') . ' WHERE uniacid = :uniacid AND sendtime >= :time ORDER BY sendtime ASC LIMIT 7', array(':uniacid' => $_W['uniacid'], ':time' => $time), 'sendtime');
	for($i = 0; $i < 7; $i++) {
		$time_key = date('Y-m-d', strtotime("+{$i} days", $time));
		$mass_old[$time_key] = array(
			'msgtype' => 'news',
			'group' => -1,
			'time' => $time_key,
			'status' => 1,
			'clock' => '20:00',
			'media' => array(
				'items' => array(
					array(
						'title' => '请选择素材'
					)
				)
			),
		);
	}

	$mass_new = array();
	if(!empty($record)) {
		foreach($record as &$li) {
			$time_key = date('Y-m-d', $li['sendtime']);
			$li['time'] = $time_key;
			$li['clock'] = date('H:i', $li['sendtime']);
			$li['media'] = pdo_get('wechat_attachment', array('id' => $li['attach_id']));
			$li['media']['attach'] = tomedia($li['media']['attachment']);
			if($li['msgtype'] == 'video') {
				$li['media']['attach']['tag'] = iunserializer($li['media']['tag']);
			} elseif($li['msgtype'] == 'news') {
				$li['media']['items'] = pdo_getall('wechat_news', array('attach_id' => $li['attach_id']));
				foreach($li['media']['items'] as &$row) {
					$row['thumb'] = media2local($row['thumb_media_id']);
				}
			}
			$li['media']['createtime_cn'] = date('Y-m-d H:i', $li['media']['createtime']);
			$li['media_id'] = $li['media']['media_id'];
			$mass_new[$time_key] = $li;
		}
		unset($record);
	}
	$mass = array_values((array_merge($mass_old, $mass_new)));
	template('material/mass');
}

if($do == 'post') {
	load()->func('cron');
	load()->model('cloud');
	$cloud = cloud_prepare();
	if(is_error($cloud)) {
		message($cloud, '', 'ajax');
	}
	set_time_limit(0);
	$records = pdo_fetchall('SELECT id, cron_id FROM ' . tablename('mc_mass_record') . ' WHERE uniacid = :uniacid AND sendtime >= :time AND status = 1 ORDER BY sendtime ASC LIMIT 8', array(':uniacid' => $_W['uniacid'], ':time' => strtotime(date('Y-m-d'))), 'id');
	if(!empty($records)) {
		foreach($records as $re) {
			if(!$re['cron_id']) {
				continue;
			}
			$corn_ids[] = $re['cron_id'];
		}
		if(!empty($corn_ids)) {
			$status = cron_delete($corn_ids);
			if(is_error($status)) {
				message(error(-1, '删除群发错误,请重新提交'), '', 'ajax');
			}
		}
		$ids = implode(',', array_keys($records));
		pdo_query('DELETE FROM ' . tablename('mc_mass_record') . " WHERE uniacid = :uniacid AND id IN ({$ids})", array(':uniacid' => $_W['uniacid']));
	}

	$groups = pdo_fetch('SELECT * FROM ' . tablename('mc_fans_groups') . ' WHERE uniacid = :uniacid AND acid = :acid', array(':uniacid' => $_W['uniacid'], ':acid' => $_W['acid']));
	$groups = iunserializer($groups['groups']);
	$groups['-1'] = array('name' => '全部粉丝', 'count' => '');

	$post = $_GPC['__input'];
	$mass = $post['data'];
	$message = '';
	$sended = array();
	foreach($mass as $key => $row) {
		if($row['media_id']) {
			if($row['id'] && (!$row['status'] || $row['sendtime'] < TIMESTAMP)) {
				$sended[] = $row['id'];
			} else {
				$row['sendtime'] = strtotime("{$row['time']} {$row['clock']}");
				if($row['sendtime'] <= TIMESTAMP) {
					$message .= "{$row['time']}的群发时间不合法,必须大于当前时间<br>";
				}
			}
		} else {
			unset($mass[$key]);
		}
	}
	if(empty($mass)) {
		message(error(-1, '没有设置群发'), '', 'ajax');
	}
	if(!empty($message)) {
		message(error(-1, $message), '', 'ajax');
	}

	$cron_status = 0;
	$message = '';
	foreach($mass as $row) {
		if(!empty($sended) && in_array($row['id'], $sended)) {
			continue;
		}
		$data = array(
			'uniacid' => $_W['uniacid'],
			'acid' => $_W['acid'],
			'groupname' => $groups[$row['group']]['name'],
			'group' => $row['group'],
			'attach_id' => $row['attach_id'],
			'media_id' => $row['media_id'],
			'fansnum' => $groups[$row['group']]['count'],
			'msgtype' => $row['msgtype'],
			'sendtime' => strtotime($row['time'] . " {$row['clock']}"),
			'createtime' => TIMESTAMP,
			'type' => 1,
			'status' => 1,
			'cron_id' => 0,
		);
		pdo_insert('mc_mass_record', $data);
		$insert_id = pdo_insertid();
		$cron = array(
			'uniacid' => $_W['uniacid'],
			'name' => $row['time'] . "微信群发任务",
			'filename' => 'mass',
			'type' => 1,
			'lastruntime' => $row['sendtime'],
			'extra' => $insert_id,
			'module' => 'task',
			'status' => 1,
		);
		$status = cron_add($cron);
		if(is_error($status)) {
			$message .= "{$row['time']}的群发任务同步到云服务失败,请手动同步<br>";
			$cron_status = 1;
		} else {
			pdo_update('mc_mass_record', array('cron_id' => $status), array('id' => $insert_id));
		}
	}
	if($cron_status) {
		message(error(-1000, $message), '', 'ajax');
	}
	message(error(0, 'success'), '', 'ajax');
}

if($do == 'cron') {
	$id = intval($_GPC['id']);
	$record = pdo_get('mc_mass_record', array('uniacid' => $_W['uniacid'], 'id' => $id));
	if(empty($record)) {
		message('群发任务不存在或已删除', referer(), 'error');
	}
	load()->func('cron');
	$cron = array(
		'uniacid' => $_W['uniacid'],
		'name' => date('Y-m-d', $record['sendtime']) . "微信群发任务",
		'filename' => 'mass',
		'type' => 1,
		'lastruntime' => $record['sendtime'],
		'extra' => $record['id'],
		'module' => 'task',
		'status' => 1
	);
	$status = cron_add($cron);
	if(is_error($status)) {
		message($status['message'], referer(), 'error');
	}
	pdo_update('mc_mass_record', array('cron_id' => $status), array('uniacid' => $_W['uniacid'], 'id' => $id));
	message('同步到云服务成功', referer(), 'success');
}

if($do == 'modal') {
	$type = trim($_GPC['type']);
	$condition = " WHERE uniacid = :uniacid AND type = :type AND model = :model AND media_id != ''";
	$params = array(':uniacid' => $_W['uniacid'], ':type' => $type, ':model' => 'perm');
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$limit = " ORDER BY createtime DESC LIMIT " . ($pindex - 1) * $psize . ", {$psize}";
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('wechat_attachment') . $condition, $params);
	$lists = pdo_fetchall('SELECT * FROM ' . tablename('wechat_attachment') . $condition . $limit, $params);
	if(!empty($lists)) {
		foreach($lists as &$row) {
			if($type == 'video') {
				$row['tag'] = iunserializer($row['tag']);
				$row['attach'] = tomedia($row['attachment'], true);
			} elseif($type == 'news') {
				$row['items'] = pdo_getall('wechat_news', array('uniacid' => $_W['uniacid'], 'attach_id' => $row['id']));
				if(!empty($row['items'])) {
					foreach($row['items'] as &$li) {
						$li['thumb'] = media2local($li['thumb_media_id']);
					}
				}
			} elseif($type == 'image') {
				$row['attach'] = tomedia($row['attachment'], true);
				$row['url'] = "url({$row['attach']})";
			} elseif($type == 'voice') {
				$row['attach'] = tomedia($row['attachment'], true);
			}
			$row['createtime_cn'] = date('Y-m-d H:i', $row['createtime']);
		}
	}
	$result = array(
		'list' => $lists,
		'pager' => pagination($total, $pindex, $psize, '', array('before' => '2', 'after' => '3', 'ajaxcallback'=>'null')),
	);
	message($result, '', 'ajax');
}

if($do == 'send') {
	$_W['page']['title'] = '群发记录-微信群发';
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$condition = ' WHERE `uniacid` = :uniacid AND `acid` = :acid';
	$pars = array();
	$pars[':uniacid'] = $_W['uniacid'];
	$pars[':acid'] = $_W['acid'];
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('mc_mass_record').$condition, $pars);
	$list = pdo_fetchall("SELECT * FROM ".tablename('mc_mass_record') . $condition ." ORDER BY `id` DESC LIMIT ".($pindex - 1) * $psize.','.$psize, $pars);
	$types = array('text' => '文本消息', 'image' => '图片消息', 'voice' => '语音消息', 'video' => '视频消息', 'news' => '图文消息');
	$pager = pagination($total, $pindex, $psize);
	template('material/send');
}


