<!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MMNO进销存</title>
        <!-- Bootstrap -->
        <link href="__PUBLIC__/libs/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="__PUBLIC__/libs/jquery/1.9.1/jquery.min.js"></script>
        <link href="__PUBLIC__/libs/font-awesome/4.2.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
        <!--[if IE 7]>
        <link rel="stylesheet" href="__PUBLIC__/libs/font-awesome/4.2.0/css/font-awesome-ie7.min.css">
        <![endif]-->
        <link rel="stylesheet" href="__STATIC__/admin/login/login.css" />        
        <style>input:-webkit-autofill {
                -webkit-box-shadow: 0 0 0px 1000px white inset;
                border: 1px solid #CCC!important;
            }
            .login_form2{
                margin:20px 30px 20px 20px; 
            }
            .logo{
                font-style: italic;
            }
        </style>
    </head>
    <body>
        <div id="mainBody">
            <div id="cloud1" class="cloud"></div>
            <div id="cloud2" class="cloud"></div>
        </div>
<!--      <div class="logintop"> <span><i class="fa fa-flag"></i> 欢迎登录管理平台</span></div>-->
        <div class="loginbody"></div>
        <div class="loginbox ">
            <div class="title">
                <div class="logo"><i class="fa fa-soundcloud fa-lg"></i> MMNO进销存 </div>
                <div class="info"></div>
            </div>
            <form class="login_form" action="{:url('login')}" method="post"  autocomplete="off" >
                <div class="form">
                    <div class="inputs">
                        <div><span><strong>账号：</strong></span>
                            <input id="username" name="username" value="superadmin" required="" type="text" autocomplete="off" placeholder="请输入您的账号">
                        </div>
                        <div><span><strong>密码：</strong></span>
                            <input id="password" name="password" required="" type="password" value="" placeholder="请输入您的密码">
                        </div>
                    </div>
                    <div class="actions">
                        <input id="submit" target-form="login_form" class="ajax-post" value="登录" type="submit" >        
                        <input class="checkbox " name="rember_password" id="rm" type="checkbox" checked=""  > 保持登录一周             
                    </div>
                </div>
            </form>
        </div>
        <!--<div class="common_footer">Powered By <a href="http://www.zencmf.com/" target="_blank">ZEN（禅意）CMF</a></div>-->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="__PUBLIC__/libs/jquery/1.9.1/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="__PUBLIC__/libs/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </body>
</html>
<!--动画效果-->
<script src="__STATIC__/admin/login/cloud.js" type="text/javascript"></script>
<!-- 提示组件-->
<link href="__PUBLIC__/libs/toastr/toastr.min.css" rel="stylesheet">
<script type="text/javascript" src="__PUBLIC__/libs/toastr/toastr.min.js"></script>
<script>
    toastr.options = {
        "closeButton": true,
        "positionClass": "toast-bottom-center"
    }
</script>
<!--自定义的一些JS函数--> 
<script src="__STATIC__/admin/js/init.js"></script>