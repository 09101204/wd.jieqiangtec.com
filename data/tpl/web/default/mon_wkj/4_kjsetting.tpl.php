<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="main">


	<form action="" method="post" class="form-horizontal form">

	<div class="panel panel-default">
		<div class="panel-heading">
			微砍价设置
		</div>
		<div class="panel-body">

			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">AppId：</label>
				<div class="col-sm-9 col-xs-12">
					<input type="text" name="appid" class="form-control" value="<?php  echo $kjsetting['appid'];?>" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">AppSecret:</label>
				<div class="col-sm-9 col-xs-12">
					<input type="text" name="appsecret" class="form-control" value="<?php  echo $kjsetting['appsecret'];?>" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">商户号:</label>
				<div class="col-sm-9 col-xs-12">
					<input type="text" name="mchid" class="form-control" value="<?php  echo $kjsetting['mchid'];?>" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">商户秘钥:</label>
				<div class="col-sm-9 col-xs-12">
					<input type="text" name="shkey" class="form-control" value="<?php  echo $kjsetting['shkey'];?>" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
				<div class="col-sm-9 col-xs-12">
					<p/>
					<input name="submit" type="submit" value="提交" class="btn btn-primary span3" />
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
				</div>
			</div>

			</div>

		</div>




<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>