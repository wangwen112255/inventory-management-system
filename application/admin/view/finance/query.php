{extend name="base:base" /} {block name="body"} 

<div class="table-common">


    <form class="form-inline" id="financequery" action="{:url('query')}" method="get">
        <div class="search-box">
            <input size="16" type="text" class="form-control form_datetime" name="timea" value="{$Think.get.timea}" placeholder="创建开始日期">
            <i class="fa fa-arrows-h"></i>
            <input size="16" type="text" class="form-control form_datetime" name="timeb" value="{$Think.get.timeb}" placeholder="创建结束日期">


            <select name="b_id" class="form-control">
                <option value="">银行</option>
                <?php echo html_select(db('finance_bank')->column('name', 'id'), request()->get('b_id')) ?>
            </select>
            <select name="attn_id" class="form-control">
                <option value="">经办人</option>
                <?php echo html_select(db('system_user')->column('nickname', 'id'), request()->get('attn_id')) ?>
            </select>
            <input style="width: 150px;" type="text" class="form-control" name="remark" value="{$Think.get.remark}" placeholder="备注" />



            <span id="finance_category"> 
                <select class="form-control finance_type" name="selecttype" data-value="{$Think.get.selecttype}" data-first-title="类型" data-first-value="" onchange="$('#typeinput').val($(this).val())"></select>
                <select class="form-control finance_c_id input-medium" name="selectc_id" data-value="{$Think.get.selectc_id}" data-first-title="分类" data-first-value="" onchange="$('#c_idinput').val($(this).val())"></select>
            </span>
            <button type="submit" class="btn btn-primary" title="查询"><i class="fa fa-search"></i> 搜索</button>
            <button class="btn btn-success export" title="导出"><i class="fa fa-share-square"></i> 导出</button>    
            <button type="button" class="btn btn-default" 
                    id="print"
                    title="打印入库单" 
                    val="<?php echo url('prints/finance_list'); ?>" 
                    >
                <i class="fa fa-print"></i> 打印</button>
        </div>
    </form>


</div>
<p>
    <small><i class="fa fa-info-circle"></i> 查询到了<strong>{$count}</strong>个账务记录
        {if !empty($revenue)}收入(+)：<strong>{$revenue}</strong>{/if} 
        {if !empty($expenditure)}支出(-)：<strong>{$expenditure}</strong>{/if}
    </small>
</p>
{$tpl_list}
{$pages}
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
        $('.form_datetime').datetimepicker({lang: 'zh', format: 'Y-m-d', timepicker: false, closeOnDateSelect: true});
    });
</script> 
<script>
    $('.export').click(function () {
        var data = $('#financequery').serialize();
        var url = '<?php echo url('query'); ?>?' + data.toString() + '&export=1';
        location.href = url;
        return false;
    });
</script>
{/block}