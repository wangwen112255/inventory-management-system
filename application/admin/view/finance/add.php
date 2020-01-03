{extend name="base:base" /} {block name="body"}
<form class="form-horizontal" action="{:url('add')}" method="post">
    <div class="form-group form-inline">
        <label class="col-sm-2 control-label"></label>
        <div class="col-sm-6">
            <h3>新增财务</h3> 
        </div>
    </div>
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
    <div class="form-group form-inline">
        <label class="col-sm-2 control-label"></label>
        <div class="col-sm-6">
            <button type="submit" class="btn btn-primary ajax-post" target-form="form-horizontal"><i class="iconfont icon-tubiao_tijiao"></i> 保存</button>
        </div>
    </div>
</form>
{/block}
{block name="foot_js"}
<script type="text/javascript">
    
    
    $(function () {
        $('#finance_category').cxSelect({
            selects: ['finance_type', 'finance_c_id'],
            url: "{:url('json/finance_category')}",
            nodata: "none",
            jsonValue: "v",
        });
        post_sisyphus();
    });
    
    
    $(function () {
        $('.form_datetime').datetimepicker({lang: 'zh', format: 'Y-m-d H:i', timepicker: true, step: 5, closeOnDateSelect: true});
    });
</script> 
{/block}
