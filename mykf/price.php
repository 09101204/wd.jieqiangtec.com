<?php
include_once("include/common.inc.php");
$price=$db->record("function","title,price,days,content","isused=1");
$help=$db->record("article","id,title,updatetime","ntype='help' order by updatetime desc",12);
$Update=$db->record("article","id,title,updatetime","ntype='Update' order by updatetime desc",12);
$title=$title_=$language['nav_price'];
include template('header');
include template('price');
include template('footer');
?>