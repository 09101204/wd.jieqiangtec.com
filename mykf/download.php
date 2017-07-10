<?php
include_once("include/common.inc.php");
$soft=$db->record("article","title,content","ntype='page_soft'",1);
$help=$db->record("article","id,title,updatetime","ntype='help' order by updatetime desc",9);
$Update=$db->record("article","id,title,updatetime","ntype='Update' order by updatetime desc",9);
$title=$title_=$soft[0]['title'];
$content=$soft[0]['content'];
include template('header');
include template('download');
include template('footer');
?>