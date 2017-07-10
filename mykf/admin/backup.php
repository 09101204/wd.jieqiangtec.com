<style type="text/css">
<!--
BODY {BACKGROUND-IMAGE:url(../images/mainbg.gif);}
BODY,TD,TH,A,INPUT,TEXTAREA,SELECT {FONT-SIZE:9pt; FONT-FAMILY: 宋体,Verdana,Arial,Helvetica,sans-serif;}
form{margin: 0; padding: 0}
body, table, tr, td, select, textarea {font:12px/1.3em simsun 宋体 arial;color:#464646;word-break:break-all;word-wrap:break-word;scrollbar-face-color:#DDDDDD;scrollbar-highlight-color: #CCCCCC;scrollbar-shadow-color: #CCCCCC;scrollbar-3dlight-color: #F5F5F5;scrollbar-darkshadow-color: #F5F5F5;scrollbar-track-color: #F0F0F0;scrollbar-arrow-color: #FFFFFF;margin-left: 0px}
TABLE.List {
	BORDER-RIGHT: 0px; PADDING-RIGHT: 4px; BORDER-TOP: 0px; PADDING-LEFT: 4px; PADDING-BOTTOM: 4px; BORDER-LEFT: 0px; PADDING-TOP: 4px; BORDER-BOTTOM: 0px; BACKGROUND-COLOR: #CECECE
}
TABLE.List TH {
	COLOR: #414141; HEIGHT: 24px; BACKGROUND-COLOR: #EEEEEE
}
TABLE.List TD {
	PADDING-LEFT: 5px; LINE-HEIGHT: 20px; BACKGROUND-COLOR: #FFFFFF
}
TABLE.List TD A:link {
	COLOR: #333333; TEXT-DECORATION: underline
}
TABLE.List TD A:visited {
	COLOR: #333333; TEXT-DECORATION: underline
}
TABLE.List TD A:hover {
	COLOR: #ff0000; TEXT-DECORATION: underline
}
-->
</style>
<?
include("../config.inc.php");
global $mysqlhost, $mysqluser, $mysqlpwd, $mysqldb;
$mysqlhost=$dbhost; //host name
$mysqluser=$dbuser;                //login name
$mysqlpwd=$dbpass;                //password
$mysqldb=$dbname;          //name of database
$mysqlpass="eqmkdata/sqlbaks";         

include("mydb.php");
$d=new dbback($mysqlhost,$mysqluser,$mysqlpwd,$mysqldb);
mysql_query("set names utf8");
/*--------------界面--------------*/if(!$_POST['act']){/*----------------------*/
$msgs[]="服务器备份目录为$mysqlpass";
$msgs[]="对于较大的数据表，强烈建议使用分卷备份";
$msgs[]="只有选择备份到服务器，才能使用分卷备份功能";
show_msg($msgs);
?>
<form name="form1" method="post" action="backup.php">
    <table width="90%" align="center" border="0" cellpadding='0' cellspacing='1' class="list">
      <tr align="center" class='header'><th colspan="2">数据备份</th></tr>
      <tr><td colspan="2">备份方式</td></tr>
      <tr><td><input type="radio" name="bfzl" value="quanbubiao" checked>          备份全部数据</td><td>备份全部数据表中的数据到一个备份文件</td></tr>
      <tr><td><input type="radio" name="bfzl" value="danbiao">备份单张表数据 
          <select name="tablename"><option value="">请选择</option>
            <?
    $d->query("show table status from $mysqldb");
    while($d->nextrecord()){
    echo "<option value='".$d->f('Name')."'>".$d->f('Name')."</option>";}
    ?>
          </select></td><td>备份选中数据表中的数据到单独的备份文件</td></tr>
      <tr><td colspan="2">使用分卷备份</td></tr>
      <tr><td colspan="2"><input type="checkbox" name="fenjuan" value="yes">
          分卷备份 <input name="filesize" type="text" size="10">K</td></tr>
      <tr><td colspan="2">选择目标位置</td></tr>
      <tr><td colspan="2"><input type="radio" name="weizhi" value="server" checked>备份到服务器</td></tr><tr class="cells"><td colspan='2'> <input type="radio" name="weizhi" value="localpc">
          备份到本地</td></tr>
      <tr><td colspan="2" align='center'><input type="submit" name="act" value="备份当前数据库" style="line-height:30px;height:30px;font-weight:bold"></td></tr>
    </table></form>
<?
/*-------------界面结束-------------*/}/*---------------------------------*/
/*----*/else{/*--------------主程序-----------------------------------------*/
if($_POST['weizhi']=="localpc"&&$_POST['fenjuan']=='yes')
{$msgs[]="只有选择备份到服务器，才能使用分卷备份功能";
show_msg($msgs); pageend();}
if($_POST['fenjuan']=="yes"&&!$_POST['filesize'])
{$msgs[]="您选择了分卷备份功能，但未填写分卷文件大小";
show_msg($msgs); pageend();}
if($_POST['weizhi']=="server"&&!writeable("../$mysqlpass"))
{$msgs[]="备份文件存放目录'$mysqlpass'不可写，请修改目录属性";
show_msg($msgs); pageend();}

/*----------备份全部表-------------*/if($_POST['bfzl']=="quanbubiao"){/*----*/
/*----不分卷*/if(!$_POST['fenjuan']){/*--------------------------------*/
if(!$tables=$d->query("show table status from $mysqldb"))
{$msgs[]="读数据库结构错误"; show_msg($msgs); pageend();}
$sql="";
while($d->nextrecord($tables))
{
$table=$d->f("Name");
$sql.=make_header($table);
$d->query("select * from $table");
$num_fields=$d->nf();
while($d->nextrecord())
{$sql.=make_record($table,$num_fields);}
}
$filename=date("Ymdhis",time())."_all.sql";
if($_POST['weizhi']=="localpc") down_file($sql,$filename);
elseif($_POST['weizhi']=="server")
{if(write_file($sql,$filename))
$msgs[]="全部数据表数据备份完成,生成备份文件'$mysqlpass/$filename'";
else $msgs[]="备份全部数据表失败";
show_msg($msgs);
pageend();
}
/*-----------------不要卷结束*/}/*-----------------------*/
/*-----------------分卷*/else{/*-------------------------*/
if(!$_POST['filesize'])
{$msgs[]="请填写备份文件分卷大小"; show_msg($msgs);pageend();}
if(!$tables=$d->query("show table status from $mysqldb"))
{$msgs[]="读数据库结构错误"; show_msg($msgs); pageend();}
$sql=""; $p=1;
$filename=date("Ymd",time())."_all";
while($d->nextrecord($tables))
{
$table=$d->f("Name");
$sql.=make_header($table);
$d->query("select * from $table");
$num_fields=$d->nf();
while($d->nextrecord())
{$sql.=make_record($table,$num_fields);
if(strlen($sql)>=$_POST['filesize']*1000){
     $filename.=("_v".$p.".sql");
     if(write_file($sql,$filename))
     $msgs[]="全部数据表-卷-".$p."-数据备份完成,生成备份文件'$mysqlpass/$filename'";
     else $msgs[]="备份表-".$_POST['tablename']."-失败";
     $p++;
     $filename=date("Ymd",time())."_all";
     $sql="";}
}
}
if($sql!=""){$filename.=("_v".$p.".sql");  
if(write_file($sql,$filename))
$msgs[]="全部数据表-卷-".$p."-数据备份完成,生成备份文件'$mysqlpass/$filename'";}
show_msg($msgs);
/*---------------------分卷结束*/}/*--------------------------------------*/
/*--------备份全部表结束*/}/*---------------------------------------------*/

/*--------备份单表------*/elseif($_POST['bfzl']=="danbiao"){/*------------*/
if(!$_POST['tablename'])
{$msgs[]="请选择要备份的数据表"; show_msg($msgs); pageend();}
/*--------不分卷*/if(!$_POST['fenjuan']){/*-------------------------------*/
$sql=make_header($_POST['tablename']);
$d->query("select * from ".$_POST['tablename']);
$num_fields=$d->nf();
while($d->nextrecord())
{$sql.=make_record($_POST['tablename'],$num_fields);}
$filename=date("Ymd",time())."_".$_POST['tablename'].".sql";
if($_POST['weizhi']=="localpc") down_file($sql,$filename);
elseif($_POST['weizhi']=="server")
{if(write_file($sql,$filename))
$msgs[]="表-".$_POST['tablename']."-数据备份完成,生成备份文件'$mysqlpass/$filename'";
else $msgs[]="备份表-".$_POST['tablename']."-失败";
show_msg($msgs);
pageend();
}
/*----------------不要卷结束*/}/*------------------------------------*/
/*----------------分卷*/else{/*--------------------------------------*/
if(!$_POST['filesize'])
{$msgs[]="请填写备份文件分卷大小"; show_msg($msgs);pageend();}
$sql=make_header($_POST['tablename']); $p=1; 
$filename=date("Ymd",time())."_".$_POST['tablename'];
$d->query("select * from ".$_POST['tablename']);
$num_fields=$d->nf();
while ($d->nextrecord()) 
{ 
    $sql.=make_record($_POST['tablename'],$num_fields);
      if(strlen($sql)>=$_POST['filesize']*1000){
     $filename.=("_v".$p.".sql");
     if(write_file($sql,$filename))
     $msgs[]="表-".$_POST['tablename']."-卷-".$p."-数据备份完成,生成备份文件'$mysqlpass/$filename'";
     else $msgs[]="备份表-".$_POST['tablename']."-失败";
     $p++;
     $filename=date("Ymd",time())."_".$_POST['tablename'];
     $sql="";}
}
if($sql!=""){$filename.=("_v".$p.".sql");  
if(write_file($sql,$filename))
$msgs[]="表-".$_POST['tablename']."-卷-".$p."-数据备份完成,生成备份文件'$mysqlpass/$filename'";}
show_msg($msgs);
/*----------分卷结束*/}/*--------------------------------------------------*/
/*----------备份单表结束*/}/*----------------------------------------------*/

/*---*/}/*-------------主程序结束------------------------------------------*/

function write_file($sql,$filename)
{
$re=true;
if(!@$fp=fopen("../eqmkdata/sqlbaks/".$filename,"w+")) {$re=false; echo "failed to open target file";}
if(!@fwrite($fp,$sql)) {$re=false; echo "failed to write file";}
if(!@fclose($fp)) {$re=false; echo "failed to close target file";}
return $re;
}

function down_file($sql,$filename)
{
ob_end_clean();
header("Content-Encoding: none");
header("Content-Type: ".(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ? 'application/octetstream' : 'application/octet-stream'));
   
header("Content-Disposition: ".(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ? 'inline; ' : 'attachment; ')."filename=".$filename);
   
header("Content-Length: ".strlen($sql));
header("Pragma: no-cache");
   
header("Expires: 0");
echo $sql;
$e=ob_get_contents();
ob_end_clean();
}

function writeable($dir)
{

if(!is_dir($dir)) {
@mkdir($dir, 0777);
}

if(is_dir($dir)) 
{

if($fp = @fopen("$dir/test.test", 'w'))
    {
@fclose($fp);
@unlink("$dir/test.test");
$writeable = 1;
} 
else {
$writeable = 0;
}

}

return $writeable;

}

function make_header($table)
{global $d;
$sql="DROP TABLE IF EXISTS ".$table."\n";
$d->query("show create table ".$table);
$d->nextrecord();
$tmp=preg_replace("/\n/","",$d->f("Create Table"));
$sql.=$tmp."\n";
return $sql;
}

function make_record($table,$num_fields)
{global $d;
$comma="";
$sql .= "INSERT INTO ".$table." VALUES(";
for($i = 0; $i < $num_fields; $i++) 
{$sql .= ($comma."'".mysql_escape_string($d->record[$i])."'"); $comma = ",";}
$sql .= ")\n";
return $sql;
}

function show_msg($msgs)
{
$title="提示：";
echo "<table width='90%' align='center' border='0' cellpadding='0' cellspacing='1' class='list'>";
echo "<tr><th>".$title."</th></tr>";
echo "<tr><td><br><ul>";
while (list($k,$v)=each($msgs))
{
echo "<li>".$v."</li>";
}
echo "</ul></td></tr></table><br>";
}

function pageend()
{
exit();
}
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
?>