{extend name="base:base" /}
{block name="body"}  
<div class="table-common">
    <div class="search-box">
        <form class="form-inline" action="{:url('product_build_query')}" method="get">
            <input size="16" type="text" class="datetime_search form-control" name="timea" value="{$Think.get.timea}" placeholder="创建开始日期">
            <i class="fa fa-arrows-h"></i>
            <input size="16" type="text" class="datetime_search form-control" name="timeb" value="{$Think.get.timeb}" placeholder="创建结束日期">
            <input type="text" placeholder="识别码/产品名称" name="keyword" value="{$Think.get.keyword}" class="form-control" />
            <button type="submit" class="btn btn-primary " title="搜索"><i class="fa fa-search"></i> 搜索</button>
        </form>
    </div>
</div>
<p>
    <small> 查询到了<strong>{$count}</strong>个入库记录</small>
</p>
<?php if (isset($lists) && count($lists) > 0) { ?>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th style="width:20px"></th>
                <th>编号</th>
                <th>生产的产品</th>
                <th>生产数量</th>
                <th>生产日期</th>        
                <th>备注</th>
                <th style="text-align:center">撤销</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($lists as $key => $var) {
                ?>
                <tr>
                    <td onclick="product_data('{$var.id}')" class="product_dataplus" id="product_dataplus{$var.id}" style="cursor: pointer"><i class="fa fa-angle-double-right"></i></td>
                    <td onclick="product_data('{$var.id}')">{$var.order_number}</td>
                    <td onclick="product_data('{$var.id}')">{$var.product_title}</td>
                    <td onclick="product_data('{$var.id}')">{$var.quantity}</td>
                    <td onclick="product_data('{$var.id}')">{$var.build_time}</td>
                    <td onclick="product_data('{$var.id}')" title="{$var.remark}">{$var.remark}</td>
                    <td style="text-align:center">
                        <a href="{:url('product_build_undo',['id'=>$var.id])}" class="btn btn-warning btn-sm ajax-get confirm" title="撤销" ><i class="fa fa-reply-all"></i> 撤销</a>
                    </td>
                </tr>
                <tr id="product_data{$var.id}" class="product_data" style="display:none">
                    <td colspan="10">
                        <table class="table table-hover table-striped table-bordered" style="margin-bottom:0px">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>包材名称</th>
                                    <th>来自哪个仓库</th>
                                    <th>消耗数量</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($var['child'])) {
                                    foreach ($var['child'] as $key2 => $var2) {
                                        ?>
                                        <tr>
                                            <td>{:sprintf("%06d",$var2.id)}</td>
                                            <td>{$var2.product_title}</td>
                                            <td>{$var2.warehouse_title}</td>
                                            <td>{$var2.quantity}</td>                                           
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <p class="bg-warning center-block">   
        <i class="fa fa-exclamation-circle"></i> 暂时没有相关数据
    </p>
<?php } ?>
{$pages}
{/block}
{block name="foot_js"} 
<script type="text/javascript">
    function product_data(id) {
        $('.product_data').hide();
        $('.product_dataplus').html('<i class=\'fa fa-angle-double-right\'></i>');
        $('#product_data' + id).fadeIn();
        $('#product_dataplus' + id).html('<i class=\'fa fa-angle-double-down\'></i>');
    }
</script>
{/block}