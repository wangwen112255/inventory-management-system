{extend name="base:base" /} {block name="body"} 
<!-- 应用列表 -->
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>备份名称</th>
            <th>卷数</th>
            <th>压缩</th>
            <th>数据大小</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($lists as $data) { ?>
            <tr>
                <td><?php echo date('Ymd-His', $data['time']); ?></td>
                <td><?php echo $data['part']; ?></td>
                <td><?php echo $data['compress']; ?></td>
                <td><?php echo format_bytes($data['size']); ?></td>
                <td>-</td>
                <td class="action">
                    <a class="btn btn-primary btn-sm db-import" href="<?php echo url('import?time=' . $data['time']); ?>"> <i class="fa fa-mail-forward"></i> 还原</a>&nbsp;
                    <a class="btn btn-danger btn-sm ajax-get confirm" href="<?php echo url('del?time=' . $data['time']); ?>"> <i class="fa fa-remove"></i> 删除</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<!-- /应用列表 -->
</div>
{/block} 
{block name="foot_js"} 
<script type="text/javascript">
    $(".db-import").click(function () {
        var self = this, status = ".";
        $.get(self.href, success, "json");
        window.onbeforeunload = function () {
            return "正在还原数据库，请不要关闭！"
        }
        return false;
        function success(result) {
            if (result.code) {
                if (result.data.gz) {
                    result.msg += status;
                    if (status.length === 5) {
                        status = ".";
                    } else {
                        status += ".";
                    }
                }
                $(self).parent().prev().text(result.msg);
                if (result.data.part) {
                    $.get(self.href,
                            {"part": result.data.part, "start": result.data.start},
                            success,
                            "json"
                            );
                } else {
                    window.onbeforeunload = function () {
                        return null;
                    }
                }
            } else {
                updateAlert(result.msg, 'alert-danger');
            }
        }
    });
    window.updateAlert = function (text, c) {
        toastr.info(text);
    };
</script>
{/block} 