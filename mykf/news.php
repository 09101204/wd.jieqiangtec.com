<?php
include_once("include/common.inc.php");
$id=Char_Cv('id','get');
if($id && is_numeric($id)){
  if($news=$db->record('article','title,author,comefrom,content,updatetime',"id=$id",1)){
    $title=$title_=$news[0]['title'];
    $author=$news[0]['author'];
    $comefrom=$news[0]['comefrom'];
    $updatetime=date('Y-m-d H:i:s',$news[0]['updatetime']);
    $content=$news[0]['content'];
    $action='view';
  }
}
if(!$action){
  $News=$db->page("article","id,title,author,content,updatetime","ntype='news' order by updatetime desc");
  $title=$title_=$language['nav_news'];
  $action='list';
}
$help=$db->record("article","id,title,updatetime","ntype='help' order by updatetime desc",12);
$Update=$db->record("article","id,title,updatetime","ntype='Update' order by updatetime desc",12);
include template('header');
include template('news');
include template('footer');
?>