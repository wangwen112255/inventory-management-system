{extend name="base:base" /}
{block name="body"}  
<style>
    legend{
        padding-bottom: 15px;
    }
    .bg-info{
        padding: 1em;
        line-height: 2;
    }

    .panel{
        padding: 0px 10px;
        margin-bottom: 20px;
        background-color: #fff;
        border: 1px solid #E6E8EB;
        cursor: pointer;
    }
    .panel:hover{
        background-color: #f1f1f1;
    }
    .panel-body{
        text-align: center;
    }
    .panel-body .quick-common{
        font-size: 1.2em;
        padding: 10px 0;
    }
    .panel-body i.iconfont{
        font-size: 3em;
    }
</style>

<div class="col-lg-3 col-md-6">
    <div class="panel panel-white">
        <div class="panel-body" data-module="inventory" data-action="storage">
            <i class="iconfont icon-ruku"></i>
            <div class="quick-common">入库</div>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-6">
    <div class="panel panel-white">
        <div class="panel-body" data-module="inventory" data-action="sales">
            <i class="iconfont icon-chuku"></i>
            <div class="quick-common">出库</div>

        </div>
    </div>
</div>
<div class="col-lg-3 col-md-6">
    <div class="panel panel-white">
        <div class="panel-body" data-module="inventory" data-action="stock_query">
            <i class="iconfont icon-kucun"></i>
            <div class="quick-common">库存</div>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-6">
    <div class="panel panel-white">
        <div class="panel-body" data-module="production" data-action="product_build">
            <i class="iconfont icon-shengchanguanli"></i>
            <div class="quick-common">生产</div>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <fieldset>
        <legend>系统信息</legend>
        <p class="bg-info hidden">
            你当前看到的是<strong>木马牛进销存系统</strong>的演示版本，如有任何疑问请加群咨询<br>
            <strong>ＱＱ交流群：</strong>688920281 <br>
        </p>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td>Thinkphp版本</td>
                    <td>{$config.thinkphp_ver}</td>
                </tr>
                <tr>
                    <td>网站域名</td>
                    <td>{$config.url}</td>
                </tr>
                <tr>
                    <td>网站目录</td>
                    <td>{$config.document_root}</td>
                </tr>
                <tr>
                    <td>服务器操作系统</td>
                    <td>{$config.server_os}</td>
                </tr>
                <tr>
                    <td>服务器端口</td>
                    <td>{$config.server_port}</td>
                </tr>
                <tr>
                    <td>服务器IP</td>
                    <td>{$config.server_ip}</td>
                </tr>
                <tr>
                    <td>WEB运行环境</td>
                    <td>{$config.server_soft}</td>
                </tr>
                <tr>
                    <td>MySQL数据库版本</td>
                    <td>{$config.mysql_version}</td>
                </tr>
                <tr>
                    <td>运行PHP版本</td>
                    <td>{$config.php_version}</td>
                </tr>
                <tr>
                    <td>最大上传限制</td>
                    <td>{$config.max_upload_size}</td>
                </tr>
                <tr>
                    <td>当前系统时间</td>
                    <td><?php echo date('Y-m-d H:i:s') ?></td>
                </tr>
            </tbody>
        </table>
    </fieldset>
</div>
{/block}
{block name="foot_js"}
<script>
    $(function () {
        $('.panel-body').click(function () {          
            if (top.topManager) {
                //打开左侧菜单中配置过的页面
                top.topManager.openPage({
                    moduleId: $(this).data('module'),
                    id: $(this).data('action')
                });
            }
        });
    })
</script>
{/block}