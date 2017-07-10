<?php
define('INSTALL_LANG', 'SC_2');

$lang = array
(
	'SC_2' => '企业版',

	'username' => '管理员账号:',
	'password' => '管理员密码:',
	'repeat_password' => '重复密码:',
	'admin_email' => '管理员 Email:',

	'succeed' => '成功',
	'enabled' => '允许',
	'writeable' => '可写',
	'readable' => '可读',
	'unwriteable' => '不可写',
	'yes' => '可',
	'no' => '不可',
	'unlimited' => '不限',
	'support' => '支持',
	'unsupport' => '<span class="redfont">不支持</span>',
	'old_step' => '上一步',
	'new_step' => '下一步',
	'tips_message' => '提示信息',
	'return' => '返回',

	'env_os' => '操作系统',
	'env_php' => 'PHP 版本',
	'env_mysql' => 'MySQL 支持',
	'env_attach' => '附件上传',
	'env_diskspace' => '磁盘空间',
	'env_dir_writeable' => '目录写入',

	'init_log' => '初始化记录',
	'clear_dir' => '清空目录',
	'select_db' => '选择数据库',
	'create_table' => '建立数据表',

	'install_wizard' => '安装向导',
	'current_process' => '当前状态:',
	'show_license' => '明科在线客服 用户许可协议',
	'agreement_yes' => '我同意',
	'agreement_no' => '我不同意',
	'check_config' => '检查配置文件状态',
	'check_catalog_file_name' => '目录文件名称',
	'check_need_status' => '所需状态',
	'check_currently_status' => '当前状态',
	'edit_config' => '浏览/编辑当前配置',
	'variable' => '设置选项',
	'value' => '当前值',
	'comment' => '注释',
	'dbhost' => '数据库服务器:',
	'dbhost_comment' => '数据库服务器地址, 一般为 localhost',
	'dbuser' => '数据库用户名:',
	'dbuser_comment' => '数据库账号用户名',
	'dbpw' => '数据库密码:',
	'dbpw_comment' => '数据库账号密码',
	'dbname' => '数据库名:',
	'dbname_comment' => '数据库名称',
	'email' => '系统 Email:',
	'email_comment' => '用于发送程序错误报告',
	'tablepre' => '表名前缀:',
	'tablepre_comment' => '同一数据库安装多客服系统时可改变默认',
	'tablepre_prompt' => '除非您需要在同一数据库安装多个 客服系统,否则,强烈建议您不要修改表名前缀。',

	'recheck_config' => '重新检查设置',
	'check_env' => '检查当前服务器环境',
	'env_required' => '明科客服系统 所需配置',
	'env_best' => '明科客服系统 最佳配置',
	'env_current' => '当前服务器',
	'install_note' => '安装向导提示',
	'add_admin' => '设置管理员账号',
	'start_install' => '开始安装 明科客服系统',
	'dbname_invalid' => '数据库名为空，请填写数据库名称',
	'admin_username_invalid' => '用户名空, 长度超过限制或包含非法字符。',
	'admin_password_invalid' => '两次输入密码不一致。',
	'admin_invalid' => '您的信息没有填写完整。',

	'config_comment' => '请在下面填写您的数据库账号信息, 通常情况下不需要修改红色选项内容。',
	'config_unwriteable' => '安装向导无法写入配置文件, 请核对现有信息, 如需修改, 请通过 FTP 将改好的 config.inc.php 上传。',

	'database_errno_2003' => '无法连接数据库，请检查数据库是否启动，数据库服务器地址是否正确',
	'database_errno_1044' => '无法创建新的数据库，请检查数据库名称填写是否正确',
	'database_errno_1045' => '无法连接数据库，请检查数据库用户名或者密码是否正确',

	'dbpriv_createtable' => '没有CREATE TABLE权限，无法安装',
	'dbpriv_insert' => '没有INSERT权限，无法安装',
	'dbpriv_select' => '没有SELECT权限，无法安装',
	'dbpriv_update' => '没有UPDATE权限，无法安装',
	'dbpriv_delete' => '没有DELETE权限，无法安装',
	'dbpriv_droptable' => '没有DROP TABLE权限，无法安装',

	'php_version_406' => '您的 PHP 版本小于 4.0.6, 无法使用 明科客服系统。',
	'attach_enabled' => '允许/最大尺寸 ',
	'attach_enabled_info' => '您可以上传附件的最大尺寸: ',
	'attach_disabled' => '不允许上传附件',
	'attach_disabled_info' => '附件上传或相关操作被服务器禁止。',
	'mysql_version_323' => '您的 MySQL 版本低于 3.23，安装无法继续进行。',
	'mysql_unsupport' => '您的服务器不支持MySql数据库，无法安装明科客服系统',
	'attach_unwriteable' => '附件目录(默认是 ./uploadfile)属性非 777 或无法写入，附件上传功能将无法使用。',
	'cache_unwriteable' => '数据缓存目录(./eqmkdata/cache)属性非 777 或无法写入，安装无法继续进行。',
	'tablepre_invalid' => '您指定的数据表前缀包含点字符(".")，请返回修改。',
	'db_invalid' => '指定的数据库不存在, 系统也无法自动建立, 无法安装 明科客服系统。',
	'db_auto_created' => '指定的数据库不存在, 但系统已成功建立, 可以继续安装。',
	'db_not_null' => '数据库中已经安装过 明科客服系统, 继续安装会清空原有数据。',
	'db_drop_table_confirm' => '继续安装会清空全部原有数据，您确定要继续吗?',
	'install_in_processed' => '正在安装...',
	'install_succeed' => '恭喜您明科在线客服安装成功，点击登陆客服管理后台',

	'license' => '<p class="subtitle">企业版授权协议 适用于企业版购买用户

<p>版权所有 (c) 2006-2007，河北明科在线<br>
保留所有权利。

<p>感谢您选择 明科在线客服系统。希望我们的努力能为您提供一个高效快速和功能强大的网上客服解决方案。


<p>河北明科在线为 明科在线客服 产品的开发商。官方网站网址为 http://www.eqmk.com。


<p>本授权协议适用且仅适用于 明科在线客服 企业版，河北明科在线拥有对本授权协议的最终解释权。

<ul type="I">
<p><li><b>协议许可的权利</b>
<ul type="1">
<li>您可以在完全遵守本最终用户授权协议的基础上，将本软件应用于非商业用途，而不必支付软件版权授权费用。
<li>您可以在协议规定的约束和限制范围内修改 明科在线客服 源代码(如果被提供的话)或界面风格以适应您的网站要求。
<li>获得商业授权之后，您可以将本软件应用于商业用途，同时依据所购买的授权类型中确定的技术支持期限、技术支持方式和技术支持内容，
自购买时刻起，在技术支持期限内拥有通过指定的方式获得指定范围内的技术支持服务。商业授权用户享有反映和提出意见的权力，相关意见
将被作为首要考虑，但没有一定被采纳的承诺或保证。
</ul>

<p><li><b>协议规定的约束和限制</b>
<ul type="1">
<li>未获商业授权之前，不得将本软件用于商业用途（包括但不限于企业网站、经营性网站、以营利为目或实现盈利的网站）。购买商业授权请登陆http://www.eqmk.com参考相关说明。
<li>不得对本软件或与之关联的商业授权进行出租、出售、抵押或发放子许可证。
<li>无论如何，即无论用途如何、是否经过修改或美化、修改程度如何，只要使用 明科在线客服 的整体或任何部分，未经书面许可，客服后台、对话框以及客服管理软件中
的 河北明科在线或www.eqmk.com 的链接都必须保留，而不能清除或修改。
<li>禁止在 明科在线客服 的整体或任何部分基础上以发展任何派生版本、修改版本或第三方版本用于重新分发。
<li>如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回，并承担相应法律责任。
</ul>

<p><li><b>有限担保和免责声明</b>
<ul type="1">
<li>本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的。
<li>用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未购买产品技术服务之前，我们不承诺提供任何形式的技术支持、使用担保，
也不承担任何因使用本软件而产生问题的相关责任。
<li>河北明科在线不对使用本软件的用途承担责任。
</ul>
</ul>

<p>有关 明科在线客服 最终用户授权协议、商业授权与技术服务的详细内容，均由 河北明科在线 官方网站独家提供。河北明科在线拥有在不
事先通知的情况下，修改授权协议和服务价目表的权力，修改后的协议或价目表对自改变之日起的新授权用户生效。

<p>电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和等同的法律效力。您一旦开始安装 明科在线客服，即被视为完全理解并接受
本协议的各项条款，在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本授权协议并构成侵权，
我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。',

	'preparation' => '<li>将压缩包中 明科客服系统 目录下全部文件和目录上传到服务器。</li><li>如果您使用非 WINNT 系统请修改以下属性：<br>&nbsp; &nbsp; <b>./uploadfile</b> 目录 777;&nbsp; &nbsp; <b>./eqmkdata</b> 目录 777;<br><b>&nbsp; &nbsp; ./eqmkdata/cache</b> 目录 777;&nbsp; &nbsp;<br></li><li>确认 URL 中 /uploadfile 可以访问服务器目录 ./uploadfile 内容。</li><li>如果config.inc.php文件不可写，请自行修改该文件上传到明科客服系统根目录下。</li>',

);

$msglang = array(

	'lock_exists' => '您已经安装过明科客服系统，为了保证客服系统数据安全，请手动删除 install.php 文件 和 ./install 文件夹下的所有文件，如果您想重新安装，请删除 eqmkdata/install.lock 文件，再次运行安装文件。',
	'short_open_tag_invalid' => '对不起，请将 php.ini 中的 short_open_tag 设置为 On，否则无法继续安装明科客服系统。',
	'database_nonexistence' => '您的 ./include/db_'.$dbtype.'.class.php 不存在, 无法继续安装, 请用 FTP 将该文件上传后再试。',
	'config_nonexistence' => '您的 config.inc.php 不存在, 无法继续安装, 请用 FTP 将该文件上传后再试。',

);

?>