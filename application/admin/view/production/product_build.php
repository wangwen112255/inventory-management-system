{extend name="base:base" /}
{block name="body"}  
<form class="form-inline" action="" method="POST">
    <table class="table table-hover">
        <tr>
            <th style="width:120px;line-height:30px;text-align:right">加工产品</th>
            <td>
                <input type="text" name="code" placeholder="产品识别码或搜索" class="form-control" id="autocomplete">
                <input type="hidden" name="product_id" id="product_id" value="{$Think.post.product_id}" />
                <span class="check-tips"><strong>{$Think.post.code}</strong></span>
            </td>
        </tr>
        <?php
        if (!empty($products)) {
            foreach ($products as $key => $val) {
                ?>
                <tr id="tabletbody{$key}">
                    <td colspan="2">
                        <table class="table table-hover table-striped" style="margin-bottom:0px">
                            <tbody>
                                <tr>
                                    <th style="width:120px;line-height:30px;text-align:right">识别码</th>
                                    <td style="width:120px;line-height:30px;">
                                        <?php echo $val['code']; ?>
                                    </td>
                                    <th style="width:120px;line-height:30px;text-align:right">产品</th>
                                    <td style="width:120px;line-height:30px;">
                                        <input type="hidden" name="product_ids[{$key}]" value="<?php echo $val['id']; ?>" />
                                        <?php echo $val['name']; ?>
                                    </td>
                                    <th style="width:120px;line-height:30px;text-align:right">倍数</th>
                                    <td style="width:120px;line-height:30px;">
                                        <?php echo $val['multiple']; ?>
                                    </td>
                                    <th style="width:100px;line-height:30px;text-align:right">出货仓库<font color="#ff0000">*</font></th>
                                    <td>
                                        <select name="product_warehouse[{$key}]" class="form-control" required>
                                            <option value="">请选择</option>
                                            <?php
                                            $pw = isset($_POST['product_warehouse'][$key]) ? $_POST['product_warehouse'][$key] : 0;
                                            foreach ($val['warehouse'] as $vars) {
                                                if ($pw == $vars['id'] || $vars['default'] == 1) {
                                                    echo '<option value="' . $vars['id'] . '"  selected >' . $vars['name'] . '   [' . $vars['quantity'] . ']</option>';
                                                } else {
                                                    echo '<option value="' . $vars['id'] . '"   >' . $vars['name'] . '   [' . $vars['quantity'] . ']</option>';
                                                }
                                            }
                                            ?>
                                        </select><button type="button" class="btn btn-default" onclick="$('#tabletbody{$key}').empty()"><i class="fa fa-remove"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            <?php } ?>   
        <?php } ?>
        <tr>
            <th style="line-height:30px;text-align:right">加工日期</th>
            <td><input type="text" class="form-control" id="build_time" name="build_time" value="{$Think.post.build_time?:date('Y-m-d H:i')}" placeholder="生产日期"></td>
        </tr>
        <tr>
            <th style="line-height:30px;text-align:right">加工数量</th>
            <td><input name="quantity" type="number" class="form-control"  value="{$Think.post.quantity}" /></td>
        </tr>
        <tr>
            <th style="line-height:30px;text-align:right">加入仓库</th>
            <td>
                <select name="warehouse_id" class="form-control">
                    <?php echo html_select($product_warehouse, input('post.warehouse_id')); ?>
                </select>
            </td>
        </tr>
        <tr>
            <th style="line-height:30px;text-align:right">备注</th>
            <td><textarea name="remark"  class="form-control" style="height:80px;width:400px;">{$Think.post.remark}</textarea></td>
        </tr>
        <tr>
            <td style="line-height:30px;text-align:right"></td>
            <td>
                <button type="submit" class="btn btn-primary ajax-post" target-form="form-inline" onclick="$('form').attr('action', '<?php echo url('product_build_submit'); ?>');"><i class="fa fa-save"></i> 生产</button> 
            </td>
        </tr>
    </table>
</form>
{/block}
{block name="foot_js"} 
<!--加载时间框--> 
<script>
    $(function () {
        $('#build_time').datetimepicker(
                {lang: 'zh', format: 'Y-m-d H:i', timepicker: true, step: 5, closeOnDateSelect: true});
    });</script> 
<!--加载时间框END-->
<script type="text/javascript">
    $(function () {
        $('#autocomplete').autocomplete({
            serviceUrl: "{:url('json/product', ['type'=>[1,2]])}",
            onSelect: function (suggestion) {
                $('#product_id').val(suggestion.id);
                $('form').attr('action', "{:url('product_build')}");
                $('form').submit();
            }
        });
    });
</script>
{/block}