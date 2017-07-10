<?php
include_once("include/common.inc.php");
$title=$company .' - '.$language['home'];
$index_content=$db->record("article","title,content","ntype='index'");
$news=$db->record("article","id,title,updatetime","ntype='news' order by updatetime desc",9);
$help=$db->record("article","id,title,updatetime","ntype='help' order by updatetime desc",9);
$Update=$db->record("article","id,title,updatetime","ntype='Update' order by updatetime desc",12);
include template('header');
include template('index');
include template('footer');
?>