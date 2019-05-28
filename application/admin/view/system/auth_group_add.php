{extend name="base:base" /} {block name="body"} 
<div class="table-common">
    <div class="left">
        <a class="btn btn-default" href="javascript:history.back();"><i class="fa fa-angle-left"></i> 返回</a>
        <button type="submit" class="btn btn-primary ajax-post" target-form="form-horizontal"><i class="fa fa-save"></i> 保存</button>
    </div>
</div>
<form class="form-horizontal" action="<?php echo url('system/auth_group_add'); ?>" method="post">
    {$tpl_form}
    <div class="form-group">
        <label class="col-sm-2 control-label" for="input01">角色授权</label>
        <div class="col-sm-10">
            <table class="table table-striped" id="role_table2" >
                <?php
                foreach ($auth_rule_list as $key => $val) {
                    //continue;
                    echo ' <tr><th><input type="checkbox" 
				level="0"
				onclick="javascript:checknode(this);"> ' . $val['title'] . '</th></tr>';
                    echo '<tr><td>';
                    foreach ($val['child'] as $k2 => $v2) {
                        echo ' <div class="col-sm-2">
				<input type="checkbox" name="access[]" value="' . $v2['id'] . '"  
				 level="1"
				onclick="javascript:checknode(this);"> ' . $v2['title'] . $v2['remark'] . '
				</div>';
                    }
                    echo '</td></tr>';
                }
                ?>
            </table>
        </div>
    </div>
    　
</form>
{/block}
{block name="foot_js"}
<script type="text/javascript">
    //修改checkbox的attr为prop，以适应jquery 1.9+
    function checknode(obj) {
        var chk = $("input[type='checkbox']");
        var count = chk.length;
        var num = chk.index(obj);
        var level_top = level_bottom = chk.eq(num).attr('level');
        for (var i = num; i >= 0; i--) {
            var le = chk.eq(i).attr('level');
            if (eval(le) < eval(level_top)) {
                chk.eq(i).prop("checked", true);
                var level_top = level_top - 1;
            }
        }
        for (var j = num + 1; j < count; j++) {
            var le = chk.eq(j).attr('level');
            if (chk.eq(num).prop("checked") == true) {
                if (eval(le) > eval(level_bottom)) {
                    chk.eq(j).prop("checked", true);
                } else if (eval(le) == eval(level_bottom)) {
                    break;
                }
            } else {
                if (eval(le) > eval(level_bottom)) {
                    //chk.eq(j).removeAttr("checked");
                    chk.eq(j).prop("checked", false);
                } else if (eval(le) == eval(level_bottom)) {
                    break;
                }
            }
        }
    }
</script> 
{/block}