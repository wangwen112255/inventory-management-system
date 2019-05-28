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
    </style>
    <div class="col-sm-6">
    <fieldset>
        <legend>系统信息</legend>
<!--        <p class="bg-info">
            你当前看到的是木马牛进销存系统的演示版本，欢迎联系我们进行私人定制<br>
            <strong>ＱＱ交流群：</strong>688920281 <br>
        </p>-->
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
