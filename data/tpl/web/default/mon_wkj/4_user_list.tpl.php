<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<div class="main">
    <ul class="nav nav-tabs">
        <li ><a href="<?php  echo $this->createWebUrl('kjManage');?>">活动管理</a></li>

        <li class="active" > <a href="<?php  echo $this->createWebUrl('joinUser',array('kid'=>$kid));?>">参加用户管理</a></li>


    </ul>





    <div class="panel panel-info">
        <div class="panel-heading"><?php  echo $wkj['title'];?> 参与用户</div>
        <div class="panel-body">
            <form action="./index.php" method="post" class="form-horizontal" role="form">

                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="m" value="<?php echo MON_WKJ;?>" />
                <input type="hidden" name="do" value="JoinUser" />
                <input type="hidden" name="kid" value="<?php  echo $kid;?>" />


                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">昵称</label>
                    <div class="col-sm-8 col-lg-9">
                        <input class="form-control" name="keyword" id="" type="text"
                               value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入昵称搜索">
                    </div>
                    <div class=" col-xs-12 col-sm-2 col-lg-2">
                        <button class="btn btn-primary pull-left span2"
                                style='margin-left: 95px;'>
                            <i class="icon-search icon-large"></i> 搜索
                        </button>
                    </div>
                </div>

            </form>
        </div>




    </div>



    <a class="btn btn-default" href="<?php  echo $this->createWebUrl('udownload',array('kid'=>$kid))?>"><i class="icon-download-alt"></i>导出用户信息</a>
    <div class="panel panel-default">
        <div class="table-responsive panel-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th style="width:150px;">openid</th>
                    <th style="width:100px;">昵称</th>
                    <th style="width:50px;">头像</th>
                    <th style="width:50px;">砍后价格</th>
                    <th style="width:100px;">注册时间</th>
                    <th style="width:100px;">ip</th>
                    <th style="width:150px;">操作</th>
                </tr>
                </thead>
                <tbody>


                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr>
                    <td><?php  echo $row['openid'];?></td>
                    <td><?php  echo $row['nickname'];?></td>
                    <td><img src="<?php  echo $row['headimgurl'];?>" height="50px" width="50px"></td>
                    <td><?php  echo $row['price'];?></td>
                    <td><?php  echo date("Y-m-d H:i",$row['createtime'])?></td>
                    <td><?php  echo $row['ip'];?></td>
                    <td >


                        <a class="btn" rel="tooltip" href="<?php  echo $this->createWebUrl('helpFirend',array('kid'=>$row['kid'],'uid'=>$row['id']));?>" title="帮助用户"><i class="glyphicon glyphicon-th-list"></i>帮砍好友</a>
                        <a href="<?php  echo $this->createWebUrl('joinUser', array( 'id' => $row['id'], 'op' => 'delete'))?>"
                           onclick="return confirm('此操作不可恢复，确认删除？');return false;" title="删除"
                           class="btn btn-small"><i class="glyphicon glyphicon-remove"></i>删除</a>
                    </td>
                </tr>
                <?php  } } ?>


                </tbody>


            </table>
            <?php  echo $pager;?>
        </div>
    </div>










</div>





<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>