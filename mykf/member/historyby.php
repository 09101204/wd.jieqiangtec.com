<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");?>
<input type="button" name="button" onclick="location.href='member.php?action=history'" value=" 高级查询 ">
<script type="text/javascript" src="../include/javascript/title.js"></script>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="20%">客户编号</th>
<th width="8%">谈话次数</th>
<th width="20%">开始时间</th>
<th width="20%">结束时间</th>
<th width="10%">操作</th>
</tr>
<?foreach($dialog[0] as $r){
$dialog_=$db->record("history","min(addtime),max(addtime),count(id)","companyid='$cid' and clientid='".$r["clientid"]."'");
$time1=$dialog_[0][0];
$time2=$dialog_[0][1];
$count=$dialog_[0][2];
$c=$db->record('client',"clientid,browser,os,prov,systemlanguage,color,screen,charset,thispage,comeurl,ip,address,keyword,search","companyid='$cid' and clientid=".$r["clientid"],1);
$c=$c[0];
?><tr align="center">
<td height="20" title="<div style='text-align:left'>访客编号：<?=$r["clientid"]?><br />IP地址：<?=$c["ip"]?><br />地理位置：<?=$c["address"]?><br />最后页面：<?=$c["thispage"]?><br />来路地址：<?=$c["comeurl"]?><br />操作系统：<?=$c["os"]?></div>"><?=$r["clientid"]?></td>
<td><?=$isread?><?=$count?></b></td>
<td><?=$isread?><?=$time1?></b></td>
<td><?=$isread?><?=$time2?></b></td>
<td>
<a href="?action=viewhistory&clientid=<?=$r["clientid"]?>">查看</a>
<?if($grade=="all"){?><a href="javascript:if(confirm('您确定要删除此记录吗？')){location.href='save.php?action=delhistory&clientid=<?=$r["clientid"]?>&page=<?=char_Cv("page","get")?>'}"><font color=blue><?=$language["del"]?></font></a><?}else{?>删除<?}?></td>
</tr>
<?}?></table>
<?=$dialog[1]?><?include("footer.php");?>