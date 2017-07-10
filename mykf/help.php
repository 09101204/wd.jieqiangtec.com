<?php
include_once("include/common.inc.php");
$id=Char_Cv('id','get');
if($id && is_numeric($id)){
  if($help=$db->record('article','title,author,comefrom,content,updatetime',"id=$id",1)){
    $title=$title_=$help[0]['title'];
    $author=$help[0]['author'];
    $comefrom=$help[0]['comefrom'];
    $updatetime=date('Y-m-d H:i:s',$help[0]['updatetime']);
    $content=$help[0]['content'];
    $action='view';
  }
}
if(!$action){
  $Help=$db->page("article","id,title,author,content,updatetime","ntype='help' order by updatetime desc");
  $title=$title_=$language['nav_help'];
  $action='list';
}
$news=$db->record("article","id,title,updatetime","ntype='news' order by updatetime desc",12);
$Update=$db->record("article","id,title,updatetime","ntype='Update' order by updatetime desc",12);
include template('header');
include template('help');
include template('footer');
?>