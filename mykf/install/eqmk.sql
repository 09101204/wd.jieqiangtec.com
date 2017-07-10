-- --------------------------------------------------
--
-- eqmk SQL file for installation
--
-- --------------------------------------------------

DROP TABLE IF EXISTS eqmk_admin;
CREATE TABLE eqmk_admin (
  id int(11) NOT NULL auto_increment,
  username char(50) default NULL,
  `password` char(50) default NULL,
  lasttime datetime default NULL,
  thistime datetime default NULL,
  updatetime int(11) default '0',
  lastip char(50) default NULL,
  thisip char(50) default NULL,
  lastaddress char(50) default NULL,
  thisaddress char(50) default NULL,
  logincount int(11) default '0',
  style char(50) default NULL,
  grade int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_ads;
CREATE TABLE eqmk_ads (
  id int(11) NOT NULL auto_increment,
  admin char(50) default NULL,
  agent char(50) default NULL,
  companyid char(50) default NULL,
  ntype char(20) default NULL,
  thetext char(120) default NULL,
  theurl char(120) default NULL,
  addtime int(11) NOT NULL default '0',
  hits int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_agent;
CREATE TABLE eqmk_agent (
  id int(11) NOT NULL auto_increment,
  username char(50) default NULL,
  company char(120) default NULL,
  `password` char(50) default NULL,
  ntype char(20) default NULL,
  grade int(11) NOT NULL default '0',
  money double NOT NULL default '0',
  paymoney double NOT NULL default '0',
  prov char(20) default NULL,
  city char(20) default NULL,
  infotime int(11) NOT NULL default '0',
  infoip char(20) default NULL,
  infotype int(11) NOT NULL default '0',
  exptime int(11) NOT NULL default '0',
  lasttime datetime default NULL,
  thistime datetime default NULL,
  lastip char(20) default NULL,
  thisip char(20) default NULL,
  lastaddress char(80) default NULL,
  thisaddress char(80) default NULL,
  logincount int(11) NOT NULL default '0',
  style char(20) default NULL,
  content longtext NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_article;
CREATE TABLE eqmk_article (
  id int(11) NOT NULL auto_increment,
  ntype char(20) default NULL,
  title char(80) default NULL,
  content longtext,
  hits int(11) NOT NULL default '0',
  author char(50) default NULL,
  comefrom char(50) default NULL,
  addtime int(11) NOT NULL default '0',
  updatetime int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_book;
CREATE TABLE eqmk_book (
  id int(11) NOT NULL auto_increment,
  sort char(20) default NULL,
  realname char(50) default NULL,
  email char(120) default NULL,
  phone char(50) default NULL,
  im char(120) default NULL,
  co longtext,
  addtime int(11) NOT NULL default '0',
  companyid char(50) default NULL,
  workerid char(50) default NULL,
  clientid char(20) default NULL,
  addip char(20) default NULL,
  isadmin int(1) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_client;
CREATE TABLE eqmk_client (
  id int(11) NOT NULL auto_increment,
  companyid char(50) default NULL,
  username char(50) default NULL,
  workerid char(50) default NULL,
  clientid char(50) default NULL,
  `status` int(11) default '0',
  domains char(50) default NULL,
  comeurl char(255) default NULL,
  pagetitle char(200) default NULL,
  thispage char(255) default NULL,
  search char(50) default NULL,
  keyword char(50) default NULL,
  addtime int(11) default '0',
  lasttime int(11) default '0',
  updatetime int(11) NOT NULL default '0',
  ip char(50) default NULL,
  address char(50) default NULL,
  prov char(50) default NULL,
  browser char(50) default NULL,
  os char(50) default NULL,
  screen char(50) default NULL,
  systemlanguage char(50) default NULL,
  color char(50) default NULL,
  `charset` char(50) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_dialog;
CREATE TABLE eqmk_dialog (
  id int(11) NOT NULL auto_increment,
  companyid char(50) default NULL,
  workerid char(50) default NULL,
  clientid char(50) default NULL,
  time1 int(11) default '0',
  time2 int(11) default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_faq;
CREATE TABLE eqmk_faq (
  id int(11) NOT NULL auto_increment,
  companyid char(50) default NULL,
  title char(50) default NULL,
  content longtext,
  hits int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_function;
CREATE TABLE eqmk_function (
  id int(11) NOT NULL auto_increment,
  keyname char(20) default NULL,
  title char(50) default NULL,
  isused int(1) NOT NULL default '0',
  price double NOT NULL default '0',
  days int(11) default '0',
  content longtext,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_history;
CREATE TABLE eqmk_history (
  id int(11) NOT NULL auto_increment,
  companyid char(50) default NULL,
  workerid char(50) default NULL,
  workername char(50) default NULL,
  clientid char(50) default NULL,
  clientname char(50) default NULL,
  `action` char(50) default NULL,
  content longtext,
  addtime datetime default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_ipdata;
CREATE TABLE eqmk_ipdata (
  id int(11) NOT NULL auto_increment,
  startip bigint(11) NOT NULL default '0',
  endip bigint(11) NOT NULL default '0',
  address1 char(50) default NULL,
  address2 char(50) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_log;
CREATE TABLE eqmk_log (
  id int(11) NOT NULL auto_increment,
  agent char(50) default NULL,
  companyid char(50) default NULL,
  title char(50) default NULL,
  content longtext,
  addtime int(11) NOT NULL,
  ip char(20) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_message;
CREATE TABLE eqmk_message (
  id int(11) NOT NULL auto_increment,
  companyid char(50) default NULL,
  workerid char(50) default NULL,
  clientid char(50) default NULL,
  `action` char(50) default NULL,
  content longtext,
  addtime datetime default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_money;
CREATE TABLE eqmk_money (
  id int(11) NOT NULL auto_increment,
  agent char(50) default NULL,
  companyid char(50) default NULL,
  money double NOT NULL,
  content longtext NOT NULL,
  addtime int(11) NOT NULL default '0',
  ip char(20) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_myfunction;
CREATE TABLE eqmk_myfunction (
  id int(11) NOT NULL auto_increment,
  companyid char(50) default NULL,
  keyname char(50) default NULL,
  starttime int(11) NOT NULL default '0',
  exptime int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_nickname;
CREATE TABLE eqmk_nickname (
  id int(11) NOT NULL auto_increment,
  cid char(20) default NULL,
  wid char(20) default NULL,
  uid char(20) default NULL,
  usertype char(2) default NULL,
  nickname char(50) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_order;
CREATE TABLE eqmk_order (
  id int(11) NOT NULL auto_increment,
  title char(20) default NULL,
  buynum int(11) NOT NULL default '0',
  realname char(50) default NULL,
  email char(120) default NULL,
  phone char(50) default NULL,
  im char(120) default NULL,
  co longtext,
  addtime int(11) NOT NULL default '0',
  companyid char(50) default NULL,
  workerid char(50) default NULL,
  clientid char(20) default NULL,
  addip char(20) default NULL,
  isadmin int(1) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_package;
CREATE TABLE eqmk_package (
  id int(11) NOT NULL auto_increment,
  title char(80) default NULL,
  price double NOT NULL default '0',
  dayti char(80) default NULL,
  `day` int(11) NOT NULL default '0',
  content longtext,
  funs longtext,
  funcos longtext,
  addtime int(11) NOT NULL default '0',
  updatetime int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_phone;
CREATE TABLE eqmk_phone (
  id int(11) NOT NULL auto_increment,
  sort char(20) default NULL,
  realname char(50) default NULL,
  phone char(50) default NULL,
  co longtext,
  addtime int(11) NOT NULL default '0',
  companyid char(50) default NULL,
  workerid char(50) default NULL,
  clientid char(20) default NULL,
  addip char(20) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_pingfen;
CREATE TABLE eqmk_pingfen (
  id int(11) NOT NULL auto_increment,
  companyid char(50) default NULL,
  workerid int(11) NOT NULL default '0',
  clientid char(50) default NULL,
  fen int(11) NOT NULL default '0',
  ip char(20) default NULL,
  addtime int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_setting;
CREATE TABLE eqmk_setting (
  id int(11) NOT NULL auto_increment,
  tableindex int(11) NOT NULL default '0',
  upuser char(80) default NULL,
  agent char(50) default NULL,
  companyid char(80) default NULL,
  username char(50) default NULL,
  ntype int(1) NOT NULL default '0',
  package int(11) NOT NULL default '0',
  packtime int(11) NOT NULL default '0',
  `status` int(1) NOT NULL default '0',
  company char(120) default NULL,
  keywords char(255) default NULL,
  description char(255) default NULL,
  logo char(120) default NULL,
  dialogad char(120) default NULL,
  dialoglogo char(120) default NULL,
  dialoglogourl char(120) default NULL,
  infotype int(11) NOT NULL default '0',
  infotime int(11) NOT NULL default '0',
  infoip char(20) default NULL,
  exptime int(11) NOT NULL default '0',
  sortcount int(11) NOT NULL default '0',
  workercount int(11) NOT NULL default '0',
  money double NOT NULL default '0',
  paymoney double NOT NULL default '0',
  prov char(50) default NULL,
  city char(50) default NULL,
  infoprov char(20) default NULL,
  infocity char(20) default NULL,
  trade char(50) default NULL,
  hot int(11) NOT NULL default '0',
  talk int(11) NOT NULL default '0',
  `comment` int(11) NOT NULL default '0',
  online int(1) NOT NULL default '0',
  urlkg int(1) NOT NULL default '1',
  url char(255) default NULL,
  grade longtext,
  autoinvite int(1) NOT NULL default '1',
  Effect int(1) NOT NULL default '0',
  opennew int(1) NOT NULL default '0',
  delay int(11) NOT NULL default '5',
  `language` char(20) default NULL,
  invitetitle char(250) default NULL,
  invitecontent char(250) default NULL,
  dialogtitle char(250) default NULL,
  dialoginfotitle char(250) default NULL,
  autofaq int(11) NOT NULL default '0',
  allowpingfen int(11) NOT NULL default '0',
  dialogsort char(255) default NULL,
  companyinfo longtext,
  count_today_pv int(11) NOT NULL default '0',
  count_today_new int(11) NOT NULL default '0',
  count_today_ip int(11) NOT NULL default '0',
  count_yesterday_pv int(11) NOT NULL default '0',
  count_yesterday_new int(11) NOT NULL default '0',
  count_yesterday_ip int(11) NOT NULL default '0',
  count_max_pv int(11) NOT NULL default '0',
  count_max_pv_date int(11) NOT NULL default '0',
  count_max_new int(11) NOT NULL default '0',
  count_max_new_date int(11) NOT NULL default '0',
  count_max_ip int(11) NOT NULL default '0',
  count_max_ip_date int(11) NOT NULL default '0',
  count_total_pv int(11) NOT NULL default '0',
  count_total_new int(11) NOT NULL default '0',
  count_total_ip int(11) NOT NULL default '0',
  count_str_today longtext,
  count_str_yesterday longtext,
  count_str_month longtext,
  count_updatetime int(11) default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_style;
CREATE TABLE eqmk_style (
  id int(11) NOT NULL auto_increment,
  companyid char(50) default NULL,
  title char(50) default NULL,
  caption char(50) default NULL,
  posx char(50) default NULL,
  posy char(50) default NULL,
  x int(11) default '0',
  y int(11) default '0',
  iconstyle char(50) default NULL,
  liststyle char(50) default NULL,
  tipstyle char(50) default NULL,
  dialogstyle char(50) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_torder;
CREATE TABLE eqmk_torder (
  id int(11) NOT NULL auto_increment,
  companyid char(50) default NULL,
  torder char(50) default NULL,
  ntype char(50) default NULL,
  addtime int(11) NOT NULL default '0',
  endtime int(11) NOT NULL default '0',
  price double NOT NULL,
  content char(200) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_words;
CREATE TABLE eqmk_words (
  id int(11) NOT NULL auto_increment,
  companyid char(50) default NULL,
  workerid char(20) default NULL,
  ntype int(1) NOT NULL default '0',
  sort char(50) default NULL,
  words char(200) default NULL,
  addtime int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_worker;
CREATE TABLE eqmk_worker (
  id int(11) NOT NULL auto_increment,
  mq int(11) NOT NULL default '0',
  companyid char(50) default NULL,
  workerid char(50) default NULL,
  sortid int(11) default '0',
  grade longtext,
  username char(255) default NULL,
  nickname char(50) default NULL,
  realname char(80) default NULL,
  `password` char(50) default NULL,
  `status` char(50) default NULL,
  online int(11) default '0',
  lasttime datetime default NULL,
  thistime datetime default NULL,
  updatetime int(11) default '0',
  lastip char(50) default NULL,
  thisip char(50) default NULL,
  port char(50) default NULL,
  lastaddress char(50) default NULL,
  thisaddress char(50) default NULL,
  logincount int(11) default '0',
  style char(50) default NULL,
  isshow int(11) default '1',
  sex char(50) default NULL,
  city char(50) default NULL,
  phone char(50) default NULL,
  email char(50) default NULL,
  qq char(50) default NULL,
  content longtext,
  onlinetitle char(50) default NULL,
  onlinetip char(255) default NULL,
  offlinetitle char(50) default NULL,
  offlinetip char(255) default NULL,
  closetip char(50) default NULL,
  Favorite int(1) NOT NULL default '0',
  FavoriteUrl char(255) default NULL,
  FavoriteName char(255) default NULL,
  taxis int(11) default '0',
  token char(50) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS eqmk_workersort;
CREATE TABLE eqmk_workersort (
  id int(11) NOT NULL auto_increment,
  companyid char(50) default NULL,
  sort char(50) default NULL,
  taxis int(11) default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

INSERT INTO eqmk_function (id, keyname, title, isused, price, days, content) VALUES (1, 'smiley', '使用表情', 1, 10, 30, '在访客端发送表情');
INSERT INTO eqmk_function (id, keyname, title, isused, price, days, content) VALUES (2, 'file', '发送文件', 1, 10, 30, '允许访客发送文件给客服');
INSERT INTO eqmk_function (id, keyname, title, isused, price, days, content) VALUES (3, 'invite', '主动发起', 1, 10, 30, '主动发起对话，抓住每个潜在客户 ');
INSERT INTO eqmk_function (id, keyname, title, isused, price, days, content) VALUES (4, 'allworker', '无限座席', 1, 10, 30, '座席不受限制，咨询量不受限制');
INSERT INTO eqmk_function (id, keyname, title, isused, price, days, content) VALUES (5, 'selworker', '指定客服', 1, 10, 30, '支持指定客服提供咨询，例如：售前客服、技术咨询等');
INSERT INTO eqmk_function (id, keyname, title, isused, price, days, content) VALUES (6, 'changeworker', '客服转接', 1, 10, 30, '实现对话转接，聊天记录同步转出');
INSERT INTO eqmk_function (id, keyname, title, isused, price, days, content) VALUES (7, 'delad', '去底部广告', 1, 10, 30, '可以去除对话框底部广告，提升企业形象');
INSERT INTO eqmk_function (id, keyname, title, isused, price, days, content) VALUES (8, 'mylogo', '自定义LOGO', 1, 20, 30, '对话框LOGO可替换成自己的LOGO，展现公司专业形象');
INSERT INTO eqmk_function (id, keyname, title, isused, price, days, content) VALUES (9, 'super', '超级客服', 1, 20, 30, '使您的客服账号具有“分身”功能');