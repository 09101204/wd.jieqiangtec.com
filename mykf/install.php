<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
@set_time_limit(1000);
session_start();
set_magic_quotes_runtime(0);
if(PHP_VERSION < '4.1.0') {
	$_GET = &$HTTP_GET_VARS;
	$_POST = &$HTTP_POST_VARS;
}
define('IN_EQMK', TRUE);
define('EQMK_ROOT', '');

$installfile = basename(__FILE__);
$sqlfile = './install/eqmk.sql';
$lockfile = './eqmkdata/install.lock';
$attachdir = './uploadfile';
$attachurl = 'uploadfile';
$quit = FALSE;

@include './install/install.lang.php';
@include './install/global.func.php';
@include './config.inc.php';
@include './include/db_'.$dbtype.'.class.php';
$inslang = defined('INSTALL_LANG') ? INSTALL_LANG : '';
$version = @file_get_contents('version.txt').' '.$lang[$inslang];
if($headercharset) {
  header('Content-Type: text/html; charset='.$wcharset);
}

if(!defined('INSTALL_LANG') || !function_exists('instmsg') || !is_readable($sqlfile)) {
	exit("安装 明科网上客服系统 您必须上传所有文件，否则无法继续");
} elseif(!isset($dbhost)) {
	instmsg('config_nonexistence');
} elseif(!ini_get('short_open_tag')) {
	instmsg('short_open_tag_invalid');
} elseif(file_exists($lockfile)) {
	instmsg('lock_exists');
}

if(function_exists('instheader')) {
	instheader();
}

if(empty($charset) && in_array(strtolower($charset), array('gbk', 'big5', 'utf-8'))) {
	$charset = str_replace('-', '', $charset);
}

$action = $_POST['action'] ? $_POST['action'] : $_GET['action'];
if(in_array($action, array('check', 'config'))) {
	if(is_writeable('./config.inc.php')) {
		$writeable['config'] = result(1, 0);
		$write_error = 0;
	} else {
		$writeable['config'] = result(1, 0);
		$write_error = 1;
	}
}

if(!$action) {

	$eqmk_license = str_replace('  ', '&nbsp; ', $lang['license']);

?>
<tr><td><b><?=$lang['current_process']?> </b><font color="#0000EE"><?=$lang['show_license']?></font></td></tr>
<tr><td><hr noshade align="center" width="100%" size="1"></td></tr>
<tr><td><br>
<table width="90%" cellspacing="1" bgcolor="#6da0d5" border="0" align="center">
<tr><td class="altbg1">
<table width="99%" cellspacing="1" border="0" align="center">
<tr><td><?=$eqmk_license?></td></tr>
</table></td></tr></table>
</td></tr>
<tr><td align="center">
<br><form method="post" action="<?=$installfile?>">
<input type="hidden" name="action" value="check">
<input type="submit" name="submit" value="<?=$lang['agreement_yes']?>" style="height: 25">&nbsp;
<input type="button" name="exit" value="<?=$lang['agreement_no']?>" style="height: 25" onclick="javascript: window.close();">
</form></td></tr>
<?

} elseif($action == 'check') {

?>
<tr><td><b><?=$lang['current_process']?> </b><font color="#0000EE"> <?=$lang['check_config']?></font></td></tr>
<tr><td><hr noshade align="center" width="100%" size="1"></td></tr>
<tr><td><br>
<?php

	$msg = '';
	$curr_os = PHP_OS;

	if(!function_exists('mysql_connect')) {
		$curr_mysql = $lang['unsupport'];
		$msg .= "<li>$lang[mysql_unsupport]</li>";
		$quit = TRUE;
	} else {
		$curr_mysql = $lang['support'];
	}

	$curr_php_version = PHP_VERSION;
	if($curr_php_version < '4.0.6') {
		$msg .= "<li>$lang[php_version_406]</li>";
		$quit = TRUE;
	}

	if(@ini_get(file_uploads)) {
		$max_size = @ini_get(upload_max_filesize);
		$curr_upload_status = $lang['attach_enabled'].$max_size;
	} else {
		$curr_upload_status = $lang['attach_disabled'];
		$msg .= "<li>$lang[attach_disabled_info]</li>";
	}

	$curr_disk_space = intval(diskfreespace('.') / (1024 * 1024)).'M';

	$checkdirarray = array(
				'attachment' => './attachment',
				'eqmkdata' => './eqmkdata',
				'fcache' => './eqmkdata/cache'
			);

	foreach($checkdirarray as $key => $dir) {
		if(dir_writeable($dir)) {
			$writeable[$key] = result(1, 0);
		} else {
			$writeable[$key] = result(0, 0);
			$langkey = $key.'_unwriteable';
			$msg .= "<li>$lang[$langkey]</li>";
			$quit = TRUE;
		}
	}

	if($quit) {
		$submitbutton = '<input type="button" name="submit" value=" '.$lang['recheck_config'].' " style="height: 25" onclick="window.location=\'?action=check\'">';
	} else {
		$submitbutton = '<input type="submit" name="submit" value=" '.$lang['new_step'].' " style="height: 25">';
		$msg = $lang['preparation'];
	}

?>
<tr><td align="center">
<table width="80%" cellspacing="1" bgcolor="#6da0d5" border="0" align="center">
<tr bgcolor="#6da0d5"><td style="color: #FFFFFF; padding-left: 10px" width="32%"><?=$lang['tips_message']?></td>
</tr><tr>
<td class="message"><?=$msg?></td>
</tr></table><br>
<table width="80%" cellspacing="1" bgcolor="#6da0d5" border="0" align="center">
<tr class="header"><td></td><td><?=$lang['env_required']?></td><td><?=$lang['env_best']?></td><td><?=$lang['env_current']?></td>
</tr><tr class="option">
<td class="altbg1"><?=$lang['env_os']?></td>
<td class="altbg2"><?=$lang['unlimited']?></td>
<td class="altbg1">UNIX/Linux/FreeBSD</td>
<td class="altbg2"><?=$curr_os?></td>
</tr><tr class="option">
<td class="altbg1"><?=$lang['env_php']?></td>
<td class="altbg2">4.0.6+</td>
<td class="altbg1">4.3.5+</td>
<td class="altbg2"><?=$curr_php_version?></td>
</tr><tr class="option">
<td class="altbg1"><?=$lang['env_attach']?></td>
<td class="altbg2"3><?=$lang['unlimited']?></td>
<td class="altbg1"><?=$lang['enabled']?></td>
<td class="altbg2"><?=$curr_upload_status?></td>
</tr><tr class="option">
<td class="altbg1"><?=$lang['env_mysql']?></td>
<td class="altbg2"><?=$lang['support']?></td>
<td class="altbg1"><?=$lang['support']?></td>
<td class="altbg2"><?=$curr_mysql?></td>
</tr><tr class="option">
<td class="altbg1"><?=$lang['env_diskspace']?></td>
<td class="altbg2">10M+</td>
<td class="altbg1"><?=$lang['unlimited']?></td>
<td class="altbg2"><?=$curr_disk_space?></td>
</tr></table><br>
<table width="80%" cellspacing="1" bgcolor="#000000" border="0" align="center">
<tr class="header"><td width="33%"><?=$lang['check_catalog_file_name']?></td><td width="33%"><?=$lang['check_need_state']?></td><td width="33%"><?=$lang['check_currently_status']?></td></tr>
<tr class="option">
<td class="altbg1">config.inc.php</td>
<td class="altbg2"><?=$lang['readable']?></td>
<td class="altbg1"><?=$writeable['config']?></td>
</tr><tr class="option">
<td class="altbg1">./eqmkdata</td>
<td class="altbg2"><?=$lang['writeable']?></td>
<td class="altbg1"><?=$writeable['eqmkdata']?></td>
</tr><tr class="option">
<td class="altbg1">./eqmkdata/cache</td>
<td class="altbg2"><?=$lang['writeable']?></td>
<td class="altbg1"><?=$writeable['fcache']?></td>
</tr><tr class="option">
<td class="altbg1">./attachment</td>
<td class="altbg2"><?=$lang['writeable']?></td>
<td class="altbg1"><?=$writeable['attachment']?></td>
</tr></table></tr></td>
<tr><td align="center">
<br><form method="post" action="<?=$installfile?>">
<input type="hidden" name="action" value="config">
<input type="button" name="submit" value=" <?=$lang['old_step']?> " style="height: 25" onclick="window.location='<?=$installfile?>'">&nbsp;
<?=$submitbutton?>
</form></td></tr>
<?php

} elseif($action == 'config') {

?>
<tr><td><b><?=$lang['current_process']?> </b><font color="#0000EE"> <?=$lang['edit_config']?></font></td></tr>
<tr><td><hr noshade align="center" width="100%" size="1"></td></tr>
<tr><td><br>
<?php

	$inputreadonly = $write_error ? 'readonly' : '';
	$msg = '<li>'.$lang['config_comment'].'</li>';

	if($_POST['saveconfig']) {
		$msg = '';
		$dbhost = setconfig($_POST['dbhost']);
		$dbuser = setconfig($_POST['dbuser']);
		$dbpw = setconfig($_POST['dbpw']);
		$dbname = setconfig($_POST['dbname']);
		$adminemail = setconfig($_POST['adminemail']);
		$tablepre = setconfig($_POST['tablepre']);
		if(empty($dbname)) {
			$msg .= '<li>'.$lang['dbname_invalid'].'</li>';
			$quit = TRUE;
		} else {
			if(!@mysql_connect($dbhost, $dbuser, $dbpw)) {
				$errormsg = 'database_errno_'.mysql_errno();
				$msg .= '<li>'.$lang[$errormsg].'</li>';
				$quit = TRUE;
			} else {
				if(mysql_get_server_info() > '4.1') {
					mysql_query("CREATE DATABASE IF NOT EXISTS `$dbname` DEFAULT CHARACTER SET $charset");
				} else {
					mysql_query("CREATE DATABASE IF NOT EXISTS `$dbname`");
				}
				if(mysql_errno()) {
					$errormsg = 'database_errno_'.mysql_errno();
					$msg .= "'<li>$errormsg ".$lang[$errormsg].'</li>';
					$quit = TRUE;
				}

				mysql_close();
			}
		}

		if(strstr($tablepre, '.')) {
			$msg .= '<li>'.$lang['tablepre_invalid'].'</li>';
			$quit = TRUE;
		}

		if(!$quit){
			if(!$write_error) {
				$fp = fopen('./config.inc.php', 'r');
				$configfile = fread($fp, filesize('./config.inc.php'));
				fclose($fp);
        $homepage=preg_replace("/\/([a-zA-Z\.]{4,})$/","","http://".$_SERVER["SERVER_NAME"].$_SERVER['PHP_SELF'])."/";
				$configfile = preg_replace("/[$]homepage\s*\=\s*[\"'].*?[\"'];/is", "\$homepage = '$homepage';", $configfile);
				$configfile = preg_replace("/[$]dbhost\s*\=\s*[\"'].*?[\"'];/is", "\$dbhost = '$dbhost';", $configfile);
				$configfile = preg_replace("/[$]dbuser\s*\=\s*[\"'].*?[\"'];/is", "\$dbuser = '$dbuser';", $configfile);
				$configfile = preg_replace("/[$]dbpass\s*\=\s*[\"'].*?[\"'];/is", "\$dbpass = '$dbpw';", $configfile);
				$configfile = preg_replace("/[$]dbname\s*\=\s*[\"'].*?[\"'];/is", "\$dbname = '$dbname';", $configfile);
				$configfile = preg_replace("/[$]tbl\s*\=\s*[\"'].*?[\"'];/is", "\$tbl = '$tablepre';", $configfile);

				$fp = fopen('./config.inc.php', 'w');
				fwrite($fp, trim($configfile));
				fclose($fp);
			}
			redirect("$installfile?action=admin");
		}
	}

?>
<tr><td align="center">
<table width="80%" cellspacing="1" bgcolor="#000000" border="0" align="center">
<tr bgcolor="#3A4273"><td style="color: #FFFFFF; padding-left: 10px" width="32%"><?=$lang['tips_message']?></td>
</tr><tr>
<td class="message"><?=$msg?></td>
</tr></table><br>
<form method="post" action="<?=$installfile?>">
<table width="80%" cellspacing="1" bgcolor="#000000" border="0" align="center">
<tr class="header">
<td width="20%"><?=$lang['variable']?></td><td width="30%"><?=$lang['value']?></td><td width="50%"><?=$lang['comment']?></td>
</tr><tr>
<td class="altbg1">&nbsp;<span class="redfont"><?=$lang['dbhost']?></span></td>
<td class="altbg2"><input type="text" name="dbhost" value="<?=$dbhost?>" <?=$inputreadonly?> size="30"></td>
<td class="altbg1">&nbsp;<?=$lang['dbhost_comment']?></td>
</tr><tr>
<td class="altbg1">&nbsp;<?=$lang['dbuser']?></td>
<td class="altbg2"><input type="text" name="dbuser" value="<?=$dbuser?>" <?=$inputreadonly?> size="30"></td>
<td class="altbg1">&nbsp;<?=$lang['dbuser_comment']?></td>
</tr><tr>
<td class="altbg1">&nbsp;<?=$lang['dbpw']?></td>
<td class="altbg2"><input type="password" name="dbpw" value="<?=$dbpass?>" <?=$inputreadonly?> size="30"></td>
<td class="altbg1">&nbsp;<?=$lang['dbpw_comment']?></td>
</tr><tr>
<td class="altbg1">&nbsp;<?=$lang['dbname']?></td>
<td class="altbg2"><input type="test" name="dbname" value="<?=$dbname?>" <?=$inputreadonly?> size="30"></td>
<td class="altbg1">&nbsp;<?=$lang['dbname_comment']?></td>
</tr><tr>
<td class="altbg1">&nbsp;<span class="redfont"><?=$lang['tablepre']?></span></td>
<td class="altbg2"><input type="text" name="tablepre" value="<?=$tbl?>" <?=$inputreadonly?> size="30"></td>
<td class="altbg1">&nbsp;<?=$lang['tablepre_comment']?></td>
</tr></table><br>
<input type="hidden" name="action" value="config">
<input type="hidden" name="saveconfig" value="1">
<input type="button" name="submit" value=" <?=$lang['old_step']?> " style="height: 25" onclick="window.location='?action=check'">&nbsp;
<input type="submit" name="submit" value=" <?=$lang['new_step']?> " style="height: 25">
</form></td></tr>
<?php

} elseif($action == 'admin') {

?>
<tr><td><b><?=$lang['current_process']?> </b><font color="#0000EE"> <?=$lang['check_env']?></font></td></tr>
<tr><td><hr noshade align="center" width="100%" size="1"></td></tr>
<tr><td><br>
<?php

	$msg = '<li>'.$lang['add_admin'].'</li>';
	if(!@mysql_connect($dbhost, $dbuser, $dbpass)) {
		$errormsg = 'database_errno_'.mysql_errno();
		$msg .= '<li>'.$lang[$errormsg].'</li>';
		$quit = TRUE;
	} else {
		$curr_mysql_version = mysql_get_server_info();
		if($curr_mysql_version < '3.23') {
			$msg .= '<li>'.$lang['mysql_version_323'].'</li>';
			$quit = TRUE;
		}

		$sqlarray = array(
				'createtable' => 'CREATE TABLE cdb_test (test TINYINT (3) UNSIGNED)',
				'insert' => 'INSERT INTO cdb_test (test) VALUES (1)',
				'select' => 'SELECT * FROM cdb_test',
				'update' => 'UPDATE cdb_test SET test=\'2\' WHERE test=\'1\'',
				'delete' => 'DELETE FROM cdb_test WHERE test=\'2\'',
				'droptable' => 'DROP TABLE cdb_test'
			);

		foreach($sqlarray as $key => $sql) {
			mysql_select_db($dbname);
			mysql_query($sql);
			if(mysql_errno()) {
				$errnolang = 'dbpriv_'.$key;
				$msg .= '<li>'.$lang[$errnolang].'</li>';
				$quit = TRUE;
			}
		}

		$result = mysql_query("SELECT COUNT(*) FROM $tablepre"."worker");
		if($result) {
			$msg .= '<li><font color="#FF0000">'.$lang['db_not_null'].'</font></li>';
			$alert = " onSubmit=\"return confirm('$lang[db_drop_table_confirm]');\"";
		}
	}

	if($_POST['submit']) {

		$username = $_POST['username'];
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];

		if($username && $password1 && $password2) {
			if($password1 != $password2) {
				$msg .= '<li><font color="#FF0000">'.$lang['admin_password_invalid'].'</font></li>';
				$quit = TRUE;
			} elseif(strlen($username) > 15) {
				$msg = $lang['admin_username_invalid'];
			}
		} else {
			$msg .= '<li><font color="#FF0000">'.$lang['admin_invalid'].'</font></li>';
			$quit = TRUE;
		}

		if(!$quit){
			redirect("$installfile?action=install&username=".rawurlencode($username)."&password=".md5($password1));
		}

	}

?>
<tr><td align="center">
<table width="80%" cellspacing="1" bgcolor="#6da0d5" border="0" align="center">
<tr bgcolor="#3A4273"><td style="color: #FFFFFF; padding-left: 10px" width="32%"><?=$lang['tips_message']?></td></tr>
<tr><td class="message"><?=$msg?></td></tr></table><br>
</td></tr>
<tr><td align="center">
<form method="post" action="<?=$installfile?>" <?=$alert?>>
<table width="80%" cellspacing="1" bgcolor="#6da0d5" border="0" align="center">
<tr bgcolor="#6da0d5">
<td style="color: #FFFFFF; padding-left: 10px" colspan="2"><?=$lang['add_admin']?></td>
</tr><tr>
<td class="altbg1" width="20%">&nbsp;<?=$lang['username']?></td>
<td class="altbg2" width="80%">&nbsp;<input type="text" name="username" value="admin" size="30"></td>
</tr><tr>
<td class="altbg1">&nbsp;<?=$lang['password']?></td>
<td class="altbg2">&nbsp;<input type="password" name="password1" size="30"></td>
</tr><tr>
<td class="altbg1">&nbsp;<?=$lang['repeat_password']?></td>
<td class="altbg2">&nbsp;<input type="password" name="password2" size="30"></td>
</tr></table><br>
<input type="hidden" name="action" value="admin">
<input type="button" name="submit" value=" <?=$lang['old_step']?> " style="height: 25" onclick="window.location='?action=config'">&nbsp;
<input type="submit" name="submit" value=" <?=$lang['new_step']?> " style="height: 25">
</form></td></tr>
<?php

} elseif($action == 'install') {

	$username = htmlspecialchars($_GET['username']);
	$email = htmlspecialchars($_GET['email']);
	$password = htmlspecialchars($_GET['password']);

	$db = new db;

	$cron_pushthread_week = rand(1, 7);
	$cron_pushthread_hour = rand(1, 8);

	$extcredits = Array
		(
		1 => Array
			(
			'title' => $lang['init_credits_karma'],
			'showinthread' => '',
			'available' => 1
			),
		2 => Array
			(
			'title' => $lang['init_credits_money'],
			'showinthread' => '',
			'available' => 1
			)
		);
?>
<tr><td><b><?=$lang['current_process']?> </b><font color="#0000EE"> <?=$lang['start_install']?></font></td></tr>
<tr><td><hr noshade align="center" width="100%" size="1"></td></tr>
<tr><td align="center"><br>
<script type="text/javascript">
	function showmessage(message) {
		document.getElementById('notice').value += message + "\r\n";
	}
</script>
<textarea name="notice" style="width: 80%; height: 400px" readonly id="notice"></textarea>

<br><br>
<input type="button" name="submit" value=" <?=$lang['install_in_processed']?> " disabled style="height: 25" onclick="window.location='admin/manage.php'" id="laststep"><br><br>
<br>
</td></tr>
<?php
	instfooter();

	$fp = fopen($sqlfile, 'rb');
	$sql = fread($fp, filesize($sqlfile));
	fclose($fp);
  
	$tablepre=$tbl;
	runquery($sql);
  $db->query("INSERT INTO `{$tablepre}admin` (`username`, `password`, `thistime`, `updatetime`, `thisip`, `thisaddress`, `logincount`, `style`, `grade`) VALUES ('$username', '$password', '".(date('Y-m-d H:i:s'))."', 0, '$onlineip', '$onlineip', 1, 'default', 0)");
  $_SESSION["eqmk_administrator_username"]=$username;

	$yearmonth = date('Ym_', time());

	dir_clear('./eqmkdata/cache');

	@touch(EQMK_ROOT.$lockfile);

	echo '<script type="text/javascript">document.getElementById("laststep").disabled = false; </script>'."\r\n";
	echo '<script type="text/javascript">document.getElementById("laststep").value = \''.$lang['install_succeed'].'\'; </script>'."\r\n";
	echo '<iframe width="0" height="0" src="admin/manage.php"></iframe>';
}
?>