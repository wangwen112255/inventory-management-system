<!DOCTYPE HTML>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-urlA-Compatible" content="IE=edge">
        <title><?php echo config('base.title') ?></title>   
        <!-- Set render engine for 360 browser -->
        <meta name="renderer" content="webkit">
        <link href="__PUBLIC__/libs/bui/css/bs3/dpl-min.css" rel="stylesheet" type="text/css" />
        <link href="__PUBLIC__/libs/bui/css/bs3/bui-min.css" rel="stylesheet" type="text/css" />
        <link href="__PUBLIC__/libs/bui/css/main.css" rel="stylesheet" type="text/css" />
        <link href="__PUBLIC__/libs/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!--[if IE 7]>
        <link rel="stylesheet" href="__PUBLIC__/libs/fontawesome/4.2.0/css/font-awesome-ie7.min.css">
        <![endif]-->
    </head>
    <body>
        <div class="header">
            <div class="dl-title"><img src="__PUBLIC__/libs/bui/img/logo.png"></div>
            <div class="dl-main-nav">
                <div class="dl-log">
                    欢迎您，
                    <span class="dl-log-user">
                        <a href="#" id="user_info_update"><?php echo @$user_auth['nickname'] ?: $user_auth['username']; ?></a>
                    </span> 
                    <a href="<?php echo url('admin/everyone/logout'); ?>" title="退出系统" class="dl-log-quit" onclick="return confirm('确定退出系统吗？');">[退出]</a> 
                </div>
                <ul id="J_Nav"  class="nav-list ks-clear">
                    <!--主菜单-->
                    <?php
                    $i = 0;
                    foreach ($menu_list_group as $key => $value) {
                        if ($value['pid'] == 0) {
                            ++$i;
                        }
                        ?>
                        <li class="nav-item <?php
                        if ($i == 1) {
                            echo 'dl-selected';
                        }
                        ?>">
                            <div class="nav-item-inner"><i class="fa <?php echo $value['icon']; ?> fa-lg"></i> <?php echo $value['name']; ?></div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="content">
            <ul id="J_NavContent" class="dl-tab-conten">
            </ul>
        </div>
        <script type="text/javascript" src="__PUBLIC__/libs/bui/js/jquery-1.8.1.min.js"></script> 
        <script type="text/javascript" src="__PUBLIC__/libs/bui/js/bui-min.js"></script> 
        <!-- 如果不使用页面内部跳转，则下面 script 标签不需要,同时不需要引入 common/page -->
        <!--<script type="text/javascript" src="__PUBLIC__/bui/js/config.js"></script> -->

    </body>
</html>
<script>
BUI.use('common/main', function () {
    var config = <?php echo $menu_list; ?>;
    new PageUtil.MainPage({
        modulesConfig: config
    });
});
$(function () {
    $('#user_info_update').click(function () {
        var url = "<?php echo url('admin/index/password'); ?>";
        top.topManager.openPage({
            id: 'test1',
            href: url,
            title: '用户资料'
        });
    });
});
</script>