{extend name="base:base" /} {block name="body"} 
<div class="table-common">  
    <div class="left">
        <a id="export" class="btn btn-primary" href="javascript:;" autocomplete="off"><i class="fa fa-save"></i> 立即备份</a>
        <a id="optimize" class="btn btn-primary ajax-get" href="<?php echo url('optimize') ?>" autocomplete="off"><i class="fa fa-recycle"></i> 优化表</a>
        <a id="repair" class="btn btn-primary  ajax-get" href="<?php echo url('repair') ?>" autocomplete="off"><i class="fa fa-wrench"></i> 修复表</a>
    </div>
</div> 

<!-- 应用列表 -->
<form id="export-form" method="post" action="{:url('export')}">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th><input class="check-all" checked="chedked" type="checkbox" value=""></th>
                <th>表名</th>
                <th>数据量</th>
                <th>数据大小</th>
                <th>创建时间</th>
                <th>备份状态</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lists as $table) { ?>
                <tr>
                    <td class="num">
                        <input class="ids" checked="chedked" type="checkbox" name="tables[]" value="<?php echo $table['name']; ?>">
                    </td>
                    <td><?php echo $table['name']; ?></td>
                    <td><?php echo $table['rows']; ?></td>
                    <td><?php echo format_bytes($table['data_length']); ?></td>
                    <td><?php echo $table['create_time']; ?></td>
                    <td class="info">未备份</td>
                    <td class="action">
                        <a class="ajax-get no-refresh" href="<?php echo url('optimize?tables=' . $table['name']); ?>">优化表</a>&nbsp;
                        <a class="ajax-get no-refresh" href="<?php echo url('repair?tables=' . $table['name']); ?>">修复表</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th><input class="check-all" checked="chedked" type="checkbox" value=""></th>
                <th>表名</th>
                <th>数据量</th>
                <th>数据大小</th>
                <th>创建时间</th>
                <th>备份状态</th>
                <th>操作</th>
            </tr>
        </tfoot>
    </table>
</form>
<!-- /应用列表 -->
</div>
{/block} 
{block name="foot_js"} 
<script type="text/javascript">
    $(function () {
        var $form = $("#export-form"), $export = $("#export"), tables;
        $optimize = $("#optimize"), $repair = $("#repair");
        $optimize.add($repair).click(function () {
            var that = this;
            $(that).addClass('disabled').attr('autocomplete', 'off').prop('disabled', true);
            $.post(this.href, $form.serialize(), function (data) {
                if (data.code) {
                    updateAlert(data.msg, 'alert-success');
                } else {
                    updateAlert(data.msg, 'alert-danger');
                }
                setTimeout(function () {
                    $('#top-alert').find('button').click();
                    $(that).removeClass('disabled').prop('disabled', false);
                }, 1500);
            }, "json");
            return false;
        });
        $export.click(function () {
            var that = this;
            $export.parent().children().addClass("disabled");
            $export.html("正在发送备份请求...");
            $.post(
                    $form.attr("action"),
                    $form.serialize(),
                    function (result) {
                        if (result.code) {
                            tables = result.data.tables;
                            $export.html(result.msg + "开始备份，请不要关闭本页面！");
                            backup(result.data.tab);
                            window.onbeforeunload = function () {
                                return "正在备份数据库，请不要关闭！"
                            }
                        } else {
                            updateAlert(result.msg, 'alert-danger');
                            $export.parent().children().removeClass("disabled");
                            $export.html("立即备份");
                            setTimeout(function () {
                                $('#top-alert').find('button').click();
                                $(that).removeClass('disabled').prop('disabled', false);
                            }, 1500);
                        }
                    },
                    "json"
                    );
            return false;
        });
        function backup(tab, status) {
            status && showmsg(tab.id, "开始备份...(0%)");
            $.get($form.attr("action"), tab, function (result) {
                if (result.code) {
                    showmsg(tab.id, result.msg);
                    if (!$.isPlainObject(result.data.tab)) {
                        $export.parent().children().removeClass("disabled");
                        $export.html("备份完成，点击重新备份");
                        window.onbeforeunload = null;
                    }
                    if (typeof (result.data.tab) != "undefined") {
                        backup(result.data.tab, tab.id != result.data.tab.id);
                    }
                } else {
                    updateAlert(result.msg, 'alert-danger');
                    $export.parent().children().removeClass("disabled");
                    $export.html("立即备份");
                    setTimeout(function () {
                        $('#top-alert').find('button').click();
                        //  $(that).removeClass('disabled').prop('disabled',false);
                    }, 1500);
                }
            }, "json");
        }
        function showmsg(id, msg) {
            $form.find("input[value=" + tables[id] + "]").closest("tr").find(".info").html(msg);
        }
    });
    window.updateAlert = function (text, c) {
        toastr.info(text);
    };
</script>
{/block} 