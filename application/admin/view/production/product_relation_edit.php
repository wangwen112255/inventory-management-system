{extend name="base:base" /}
{block name="body"}  


<div class="table-common">

    <div class="left">
        <a class="btn btn-default" href="<?php echo url('product_relation') ?>"><i class="fa fa-angle-left"></i>返回</a>
        <button type="submit" class="btn btn-primary ajax-post" target-form="form-inline" 
                onclick="$('form').attr('action', '<?php echo url('product_relation_edit_submit', ['id' => input('get.id')]); ?>');"><i class="fa fa-save"></i> 保存</button>
    </div>
</div>
<div class="row">    
    <div class="col-sm-12">

        <form class="form-inline" action="{:url('product_relation_edit',['id'=>$Think.get.id])}" method="post" >

            <div style="margin-bottom: 20px;">
                <input type="text" name="code" placeholder="包材搜索" class="form-control" id="autocomplete">
                <input type="hidden" name="product_ids[]" id="product_id" value="" />
            </div>
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>识别码</th>
                        <th>包材名称</th>
                        <th>消耗倍数</th>
                        <th>删除</th>
                    </tr>
                </thead>
                <?php
                if (!empty($products))
                    foreach ($products as $key => $value) {
                        $key = $value['id'];
                        ?>
                        <tr id="tabletbody{$key}">
                            <td>
                                <?php echo $value['code'] ?>
                            </td>
                            <td>
                                <input type="hidden" name="product_ids[{$key}]" value="<?php echo $value['id']; ?>" />
                                <?php echo $value['name'] ?>
                            </td>
                            <td>
                                <input type="text" style="width: 80px;" 
                                       name="multiple[{$key}]" 
                                       value="<?php echo isset($_POST['multiple'][$key]) ? $_POST['multiple'][$key] : $value['multiple']; ?>"
                                       placeholder="倍数" class="form-control text-center"  >
                            </td>
                            <td>
                                <button type="button" class="btn btn-default btn-sm" onclick="$('#tabletbody{$key}').empty()"><i class="fa fa-remove"></i> 删除</button>
                            </td>
                        </tr>
                    <?php } ?>
            </table>
        </form>
    </div>
</div>


{/block}
{block name="foot_js"}
<script type="text/javascript">
    $(function () {
        $('#autocomplete').autocomplete({
            serviceUrl: "{:url('json/product', ['type'=>[3]])}",
            onSelect: function (suggestion) {
                $('#product_id').val(suggestion.id);
                $('form').submit();
            }
        });
    });
</script>
{/block}