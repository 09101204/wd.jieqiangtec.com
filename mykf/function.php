<?php
include_once("include/common.inc.php");
$func=$db->record("article","title,content","ntype='page_func'",1);
$help=$db->record("article","id,title,updatetime","ntype='help' order by updatetime desc",12);
$Update=$db->record("article","id,title,updatetime","ntype='Update' order by updatetime desc",12);
$title=$title_=$func[0]['title'];
$content=$func[0]['content'];
include template('header');
include template('page');
include template('footer');
?>