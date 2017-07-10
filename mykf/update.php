<?php
include_once("include/common.inc.php");
$id=Char_Cv('id','get');
if($id && is_numeric($id)){
  if($update=$db->record('article','title,author,comefrom,content,updatetime',"id=$id",1)){
    $title=$title_=$update[0]['title'];
    $author=$update[0]['author'];
    $comefrom=$update[0]['comefrom'];
    $updatetime=date('Y-m-d H:i:s',$update[0]['updatetime']);
    $content=$update[0]['content'];
    $action='view';
  }
}
if(!$action){
  $update=$db->page("article","id,title,author,content,updatetime","ntype='update' order by updatetime desc");
  $title=$title_=$language['nav_update'];
  $action='list';
}
$news=$db->record("article","id,title,updatetime","ntype='news' order by updatetime desc",9);
$help=$db->record("article","id,title,updatetime","ntype='help' order by updatetime desc",9);
include template('header');
include template('update');
include template('footer');
?>