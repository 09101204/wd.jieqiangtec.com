<?php
$PriceOne=array('月',30);
$ListUserPrice=array(0.1,0.3);
if($timezone=='')$timezone=0;
if(!$freeday)$freeday=7;
if(!$default_icon)$default_icon='004';
if(!$default_workersort)$default_workersort='客户咨询';
if(!$default_worker)$default_worker='在线客服';
if(!$default_sortcount || !is_numeric($default_sortcount) || $default_sortcount<1)$default_sortcount=1;
if(!$default_workercount || !is_numeric($default_workercount) || $default_workercount<1)$default_workercount=1;
if(!$price_sort || !is_numeric($price_sort) || $price_sort<0)$price_sort=20;
if(!$price_worker || !is_numeric($price_worker) || $price_worker<0)$price_worker=10;
if(!$price_days1 || !is_numeric($price_days1) || $price_days1<0)$price_days1=10;
if(!$price_days2 || !is_numeric($price_days2) || $price_days2<0)$price_days2=50;
if(!$price_allfun || !is_numeric($price_allfun) || $price_allfun<0)$price_allfun=100;
$MQStart=100000;
?>