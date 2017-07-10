<?php
class db{
	var $version = '';
	var $querynum = 0;
	var $link;
	
  function db(){
    global $dbhost,$dbuser,$dbpass,$dbname,$pconnect,$charset;
		$func = empty($pconnect) ? 'mysql_connect' : 'mysql_pconnect';
		if(!$this->link = @$func($dbhost, $dbuser, $dbpass)) {
			die('Can not connect to MySQL server');
		} else {
			if($this->version() > '4.1') {
				global $charset, $dbcharset;
				$dbcharset = !$charset && in_array(strtolower($wcharset), array('gbk', 'big5', 'utf-8')) ? str_replace('-', '', $wcharset) : $charset;
				$serverset = $charset ? 'character_set_connection='.$charset.', character_set_results='.$charset.', character_set_client=binary' : '';
				$serverset .= $this->version() > '5.0.1' ? ((empty($serverset) ? '' : ',').'sql_mode=\'\'') : '';
				$serverset && mysql_query("SET $serverset", $this->link);
			}
			$dbname && @mysql_select_db($dbname, $this->link);
		}
		
    register_shutdown_function(array(&$this, 'close'));
  }
  
  function close(){
    mysql_close($this->link);
  }
  
	function version() {
		if(empty($this->version)) {
			$this->version = mysql_get_server_info($this->link);
		}
		return $this->version;
	}

	function error() {
		return (($this->link) ? mysql_error($this->link) : mysql_error());
	}

	function errno() {
		return intval(($this->link) ? mysql_errno($this->link) : mysql_errno());
	}
  
  function query($sql,$type='') {
		global $debug, $starttime, $sqldebug, $sqlspenttimes;

		$func = $type == 'UNBUFFERED' && @function_exists('mysql_unbuffered_query') ?
			'mysql_unbuffered_query' : 'mysql_query';
		if(!($query = $func($sql, $this->link))) {
			if(in_array($this->errno(), array(2006, 2013)) && substr($type, 0, 5) != 'RETRY') {
				$this->close();
				require EQMK_ROOT.'./config.inc.php';
				$this->db();
				$this->query($sql, 'RETRY'.$type);
			} elseif($type != 'SILENT' && substr($type, 5) != 'SILENT') {
				die('MySQL Query Error<br />'.$sql);
			}
		}

		$this->querynum++;
		return $query;
  }
  
  function fetch_array($sql) {
    return mysql_fetch_array($sql);
  }
  
  function rows($table,$vars="") {
    global $tbl;
    $table = $tbl.$table;
    if($vars){
      $vars = "where $vars";
    }
    $result=$this->query("select id from $table $vars");
    return $result ? mysql_num_rows($result) : 0;
  }
  
  function insert($table,$key,$value) {
    global $tbl;
    $table = $tbl.$table;
    $v=explode("|",$value);
    for($i=0;$i<count($v);$i++){
      $xxx.="\"".(substr($v[$i],0,7)=="content" ? $_POST[$v[$i]] :$v[$i])."\"";
      if($i<count($v)-1)$xxx.=",";
    }
    $this->query("insert into $table ($key)values($xxx)");
  }
  function update($table,$key,$value,$vars) {
    global $tbl;
    $table = $tbl.$table;
    if($vars){
      $vars = "where $vars";
    }
    $k=explode(",",$key);
    $v=explode("|",$value);
    for($i=0;$i<count($k);$i++){
      $xxx.=$k[$i]."=\"".(substr($v[$i],0,7)=="content" ? $_POST[$v[$i]] :$v[$i])."\"";
      if($i<count($k)-1)$xxx.=",";
    }
    $this->query("update $table set $xxx $vars");
  }
  function delete($table,$vars) {
    global $tbl;
    $table = $tbl.$table;
    if($vars){
      $vars = "where $vars";
    }
    $this->query("delete from $table $vars");
  }
  function select($table,$key,$vars=""){
    global $tbl;
    $table = $tbl.$table;
    if($vars){
      $vars = "where $vars";
    }
    $result=$this->query("select $key from $table $vars");
    if(!$result){
      return false;
    }else{
      $rs=mysql_fetch_array($result);
      return $rs[0];
    }
  }
  function record($table,$key,$vars="",$limit=""){
    global $tbl;
    $table = $tbl.$table;
    if($vars){
      $vars = "where $vars";
    }
    if($limit){
      $limit = "limit $limit";
    }
    $k=explode(",",$key);
    $record = Array();
    $result=$this->query("select $key from $table $vars $limit");
    $j=0;
    if(!$result){
      return false;
    }
    while($eqmk=$this->fetch_array($result)){
      for($i=0;$i<count($k);$i++){
        $temp = $eqmk[$i];
        $record[$j][$k[$i]]=$temp;
       // $record[$j][$i]=$temp;
      }
      $j++;
    }
    return $record;
  }
  function page($table,$key,$vars="",$maxperpage=20,$strs=""){
    global $tbl;
    $table_=$table;
    $vars_=$vars;
    $pagename = $_SERVER['PHP_SELF'];
    $table = $tbl.$table;
    if($vars){
      $vars = "where $vars";
    }
    if($limit){
      $limit = "limit $limit";
    }
    $j=0;
    $thispage=Char_Cv("page","get");
    if ($thispage=="" || !is_numeric($thispage)){
      $thispage=1;
    }
    $thispage=intval($thispage);
    $sql="select $key from $table $vars $limit";
    $result=$this->query($sql);
    $totalput=$this->rows($table_,$vars_);
    if (($totalput %$maxperpage)==0){
      $PageCount=intval($totalput /$maxperpage);
    }else{
      $PageCount=intval($totalput /$maxperpage+1);
    } 
    if ($thispage>$PageCount){
      $thispage=$PageCount;
    }
    if ($thispage>1){
      mysql_data_seek($result,$maxperpage*($thispage-1));
    }
    $k=explode(",",$key);
    $record = Array();
    while($eqmk=$this->fetch_array($result)){
      for($i=0;$i<count($k);$i++){
        $temp = $eqmk[$i];
        $record[$j][$k[$i]]=$temp;
        $record[$j][$i]=$temp;
      }
      $j++;
      if ($j>=$maxperpage){
        break;
      }
    }
    $ms="";
    for ($k=1; $k<=$PageCount; $k=$k+1){
      if ($k==$thispage){
        $ms=$ms.$k." "."\r\n";
      }else{
        $ms=$ms."<a href='".$pagename."?page=".$k."&".$strs."'><u><font color=blue>[".$k."]</font></u></a> "."\r\n";
      }
    }
    $pagelist="<div align=\"center\">".$ms."</div>";
    if(Trim($ms)=="1"){
      $pagelist="";
    }
    return array($record,$pagelist,$totalput);
  }
  
	function insert_id() {
		return ($id = mysql_insert_id($this->link)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
	}
}
?>