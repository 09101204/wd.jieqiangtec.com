<?php
include("../include/common.inc.php");
$cid=$_SESSION["eqmk_worker_companyid"];
$username=$_SESSION["eqmk_worker_username"];
if($cid=='' || $username==''){
  header("location:../index.php");
  exit;
}else{
  print('<script type="text/javascript">top.location.href="manage.php"</script>');
}
?>