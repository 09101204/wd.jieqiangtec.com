<?php

//微信科技 by QQ:800083075 http://www.012wz.com/
global $_W, $_GPC;
$limitsum = $cfg['ThechartsSum'];
		if (empty($limitsum)) {$limitsum = 30;}
//$list = pdo_fetchall("SELECT member.*,(select fs.avatar from " . tablename('mc_members') . " fs, " . tablename('mc_mapping_fans') . "  bfs where bfs.openid=member.from_user and fs.uid=bfs.uid and avatar<>'' limit 1) avatar,(select fsc.credit1 from " . tablename('mc_members') . " fsc, " . tablename('mc_mapping_fans') . "  bfsc where bfsc.openid=member.from_user and fsc.uid=bfsc.uid limit 1) credit1 FROM " . tablename('wwx_fxxt_member') . " member WHERE member.uniacid = :uniacid and member.nickname<>'' order by credit1 desc limit {$limitsum} ", array(':uniacid' => $_W['uniacid']));
$list = pdo_fetchall("SELECT a.* from " . tablename('mc_members') . " a inner join " . tablename('mc_mapping_fans') . " b on a.uid=b.uid where a.uniacid = :uniacid order by  a.credit2 desc limit {$limitsum} ", array(':uniacid' => $_W['uniacid']));
//print_r('<pre>');print_r($list);exit;
include $this->template('member/phb_ye');