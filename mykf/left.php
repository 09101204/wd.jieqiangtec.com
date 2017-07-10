<?php
$news=$db->record("article","id,title","ntype='news' order by updatetime desc",10);
$help=$db->record("article","id,title","ntype='help' order by updatetime desc",10);
?>