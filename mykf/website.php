<?php
include_once("include/common.inc.php");
$sortby=Char_Cv('sortby','get');
if(!$sortby)$sortby='status';

$title=$language['nav_website'];

$Sort_By[]=array('list_state.gif','status','website_sortby_state');
$Sort_By[]=array('list_hot.gif','hot','website_sortby_hot');
$Sort_By[]=array('list_num.gif','talk','website_sortby_talk');
$Sort_By[]=array('list_forum.gif','comment','website_sortby_comment');
$Sort_By[]=array('list_new.gif','id','website_sortby_new');
foreach($Sort_By as $v){
  $SortBy.=' <img src="images/'.$tpldir.'/'.$v[0].'"> '.($sortby==$v[1]?'<span style="color:#e65a00;font-weight:bold">'.$language[$v[2]].'</span>':'<a href="?sortby='.$v[1].'">'.$language[$v[2]].'</a>');
}

$website=$db->page('setting','company,companyid,description,logo,prov,city,trade,hot,talk,comment,online','status=1 order by '.$sortby.' desc',10,'sortby='.$sortby);
include_once("left.php");
include template('header');
include template('website');
include template('footer');
?>