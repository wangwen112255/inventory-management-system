{extend name="base:base" /} {block name="body"} 
<div class="table-common">
    <div class="left">
        <button type="submit" class="btn btn-primary ajax-post" target-form="form-horizontal"><i class="fa fa-save"></i> 保存</button>
    </div>
</div>
<form class="form-horizontal" action="{:url('add')}" method="post">
    <div class="form-group form-inline">
        <label class="col-sm-2 control-label">账务分类</label>
        <div class="col-sm-6" id='finance_category'>
            <select class="form-control finance_type" name="type" required>
                <option>选择类型</option>
            </select>
            <select class="form-control input-medium finance_c_id" name="c_id">
                <option>选择分类</option>
            </select>
        </div>
    </div>
    {$tpl_form}
</form>
{/block}
{block name="foot_js"}
<script type="text/javascript">
    $(document).ready(function () {
        $('#finance_category').cxSelect({
            selects: ['finance_type', 'finance_c_id'],
            url: "{:url('json/finance_category')}",
            nodata: "none",
            jsonValue: "v",
        });
        post_sisyphus();
    });
</script>   
<script>
    $(function () {
        $('.form_datetime').datetimepicker(
                {lang: 'zh', format: 'Y-m-d H:i', timepicker: true, step: 5, closeOnDateSelect: true});
    });
</script> 
{/block}
