<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<style type="text/css">
.dirName{color:#0000ff;cursor:pointer}
span.ms{color:gray;font-style: italic}
.checkdirA{color:gray}
.checkdirB{color:green}
.checkdirC{color:red}
</style>
<input type="button" value="优化全部数据表" onclick="optimizeall()" style="line-height:30px;height:30px;font-weight:bold"> 
<input type="button" value="修复全部数据表" onclick="repairall()" style="line-height:30px;height:30px;font-weight:bold"><br /><br />
<table width="720" border="0" cellspacing="1" cellpadding="0" class="list">
<tr align="center">
<th height="20" width="150">数据表名称</th>
<th width="300">部分字段</th>
<th width="60">记录数</th>
<th width="170">操作</th>
<th width="100"></th>
</tr>
<?
$tables_query = $db->query('show tables');
while ($tables = $db->fetch_array($tables_query)) {
if(substr($tables[0],0,strlen($tbl))!=$tbl)continue;
$table=substr($tables[0],strlen($tbl)-strlen($tables[0]));
$result=$db->query("SHOW FIELDS FROM ".$tables[0]);
$fieldlist=array();
while($data=mysql_fetch_array($result)) {
  $fieldlist[]=$data['Field'];
}
$result=$db->query("select id from ".$tables[0]);
$count=$result ? mysql_num_rows($result) : 0;
unset($fieldlist[0]);
?>
<tr align="center">
<td align="left" height="20" style="color:#0000ff"><?=$tables[0]?></td>
<td align="left" style="color:#666666"><?=FormatCharLen(implode(',',$fieldlist),65)?></td>
<td><?=$count?></td>
<td>
  <a href="?action=viewtable&table=<?=$tables[0]?>" target="_blank">结构</a>
  <a href="javascript:settable('table_<?=$tables[0]?>','optimize','<?=$tables[0]?>')">优化</a>
  <a href="javascript:settable('table_<?=$tables[0]?>','repair','<?=$tables[0]?>')">修复</a>
  <a href="javascript:settable('table_<?=$tables[0]?>','truncate','<?=$tables[0]?>')">清空</a>
</td>
<td id="table_<?=$tables[0]?>" class="checkdirA"></td>
</tr>
<?}?>
</table>
<script type="text/javascript" src="../include/javascript/common.js"></script>
<script type="text/javascript" src="../include/javascript/ajax.js"></script>
<script type="text/javascript">
function optimizeall(){
  var tags=document.getElementsByTagName('td');
  for(i=0;i<tags.length;i++){
    if(tags[i].id.substr(0,6)=='table_'){
      settable(tags[i].id,'optimize',tags[i].id.substr(6,tags[i].id.length-6));
    }
  }
}
function repairall(){
  var tags=document.getElementsByTagName('td');
  for(i=0;i<tags.length;i++){
    if(tags[i].id.substr(0,6)=='table_'){
      settable(tags[i].id,'repair',tags[i].id.substr(6,tags[i].id.length-6));
    }
  }
}
function settable(obj,ntype,table){
  var obj=$(obj);
  obj.className='checkdirA';
  obj.innerHTML='正在执行...';
  var x=new Ajax('HTML','');
  switch(ntype){
    case'optimize':
      x.post("save.php?action=optimize","table="+table,function(s){
        if(s=='Y'){
          obj.className='checkdirB';
          obj.innerHTML='优化成功';
        }else{
          obj.className='checkdirC';
          obj.innerHTML='优化失败';
        }
      });
      break;
    case'repair':
      x.post("save.php?action=repair","table="+table,function(s){
        if(s=='Y'){
          obj.className='checkdirB';
          obj.innerHTML='修复成功';
        }else{
          obj.className='checkdirC';
          obj.innerHTML='修复失败';
        }
      });
      break;
    case'truncate':
      if(!confirm("您确定要清空"+table+"表吗？")){
        return;
      }
      x.post("save.php?action=truncate","table="+table,function(s){
        if(s=='Y'){
          obj.className='checkdirB';
          obj.innerHTML='数据已清除';
        }else{
          obj.className='checkdirC';
          obj.innerHTML='清除失败';
        }
      });
      break;
  }
}
function delsqlbakfile(file){
  if(confirm("您确定要删除备份文件“"+file+"”吗？")){
    window.location.href="save.php?action=delsqlbak&file="+file;
  }
}
</script>
<?include("footer.php");?>