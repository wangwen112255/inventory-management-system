{extend name="base:base" /} {block name="body"} 
<div class="table-common">
    <form class="form-inline" action="{:url('sales_query')}" method="get">
        <input type="hidden" id="chartinput" name="chart" value="{$chart}" />
        <div class="search-box">
            <input size="16" type="text" class="datetime_search form-control" name="timea" value="{$Think.get.timea}" placeholder="创建开始日期">
            <i class="fa fa-arrows-h"></i>
            <input size="16" type="text" class="datetime_search form-control" name="timeb" value="{$Think.get.timeb}" placeholder="创建结束日期">
            <input size="16" type="text" placeholder="单号/识别码/产品名称" name="keyword" value="{$Think.get.keyword}" class="form-control">


            <?php if (empty($chart)) { ?>
                <input type="text" class="form-control" style="width: 140px;" name="express_num" value="{$Think.get.express_num}" placeholder="快递单号">
            <?php } ?>
            <input type="text" style="width: 120px;" placeholder="会员" name="nickname" value="{$Think.get.nickname}" class="form-control">
            <input type="text" style="width: 120px;" placeholder="会员电话" name="tel" value="{$Think.get.tel}" class="form-control">

            <select name="sales_type" class="form-control">
                <option value="">出库类型</option>
                <?php echo html_select(config('_dict_sales'), input('get.sales_type')); ?>
            </select>
            <select name="warehouse" class="form-control">
                <option value="">所有仓库</option>
                <?php echo html_select($warehouse, input('get.warehouse')); ?>       
            </select>

            <select name="c_id" class="form-control">
                <option value="">所有分类</option>
                <?php echo html_select($category, input('get.c_id')); ?>       
            </select>
            <select name="type" class="form-control">
                <option value="">类型</option>
                <?php echo html_select(config('_dict_product_type'), input('get.type')) ?>                
            </select>
            <select name="status" class="form-control">
                <option value="">状态</option>
                <option value="1"{eq name="Think.get.status" value="1"} selected{/eq}>已完成</option>
                <option value="-1"{eq name="Think.get.status" value="-1"} selected{/eq}>有退货</option>
                <option value="-2"{eq name="Think.get.status" value="-2"} selected{/eq}>已退货</option>
            </select>


            <div class="btn-group" data-toggle="buttons-radio">
                <button type="button" onclick="$('#chartinput').val(0); $('form').submit()" class="btn{:empty($chart)?' active':''} btn-default"><i class="fa fa-list-alt"></i> 出库订单</button>
                <button type="button" onclick="$('#chartinput').val(1); $('form').submit()" class="btn{$chart==='1'?' active':''} btn-default"><i class="fa fa-table"></i> 产品列表</button>
            </div>

            <button type="submit" class="btn btn-primary" title="查询"><i class="fa fa-search"></i> 查询</button>
            {if $chart==='1'}
            <button type="button" class="btn btn-default" title="打印销售订单" 
                    id="print"
                    val="<?php echo url('prints/orders_list') ?>" 
                    ><i class="fa fa-print"></i> 打印</button>
            {else/}
            <button class="btn btn-success export" title="导出"><i class="fa fa-file-excel-o"></i> 导出</button>
            {/if}
        </div>


    </form>
</div>
<p>
    <small> 查询到了<strong>{$count}</strong>个销售记录</small>
    <?php if (isset($count_sum)) { ?>
        <small> 总数量<strong>{$count_sum}</strong></small>
    <?php } ?>
</p>
<?php if (count($lists) == 0) { ?>
    <p class="bg-warning center-block">   
        <i class="fa fa-exclamation-circle"></i> 暂时没有相关数据
    </p>
<?php } else {
    ?>
    <?php if (empty($chart)) { ?>

        <table class="table table-hover table-striped">
            <thead>
                <tr><th style="width:20px"></th>
                    <th>订单编号</th>
                    <th>状态</th>
                    <th>快递</th>
                    <th>金额</th>
                    <th>创建日期</th>
                    <th>会员</th>
                    <th>发货日期</th>
                    <th>出库类型</th>
                    <th>状态</th>
                    <th>产品数量</th>
                    <th style="text-align:center">打印</th>
                    <th style="text-align:center">查看</th>
                    <th style="text-align:center">撤消</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lists as $key => $var) {
                    ?>

                    <tr{$var.status==='-1'?' class="warning"':($var.status==='-2'?' class="error"':'')} onclick="product_data('{$var.id}')">
                        <td class="product_dataplus" id="product_dataplus{$var.id}"><i class="fa fa-angle-double-right"></i></td>
                        <td>{$var.order_number}</td>
                        <td>{$var.status_text}</td>
                        <td>{$var.express_name|default='无'}{$var.express_num}</td>
                        <td>{$var.amount}</td>
                        <td>{$var.create_time}</td>
                        <td>{$var.nickname?:'<span class="label label-important">没有客户</span>'}</td>
                        <td>{$var.ship_time}</td>
                        <td>{$var.type}</td>
                        <td>  
                            {eq name="var.print" value="0"}
                            <span class="label label-warning">未打印</span>
                            {else/}
                            <span class="label label-success">已打印</span>
                            {/eq}
                        </td>
                        <td>{$var.count_data}</td>
                        <td style="text-align:center">
                            <a href="javascript:;" 
                               class="print"
                               title="打印订单{$var.id}"
                               num="{$var.order_number}"
                               val="<?php echo url('prints/orders_view', ['id' => $var['id']]) ?>" >
                                <i class="fa fa-print"></i> 打印</a>
                        </td>
                        <td style="text-align:center"><a href="{:url('sales_look',['id'=>$var.id])}" title="查看记录"><i class="fa fa-search"></i> 查看</a></td>
                        <td style="text-align:center">               
                            <a href="{:url('sales_undo',['id'=>$var.id])}" class="ajax-get confirm" title="撤销" ><i class="fa fa-reply-all"></i> 撤销</a>            
                        </td>
                    </tr>
                    <tr id="product_data{$var.id}" class="product_data" style="display:none">
                        <td colspan="14">
                            <table class="table table-bordered" style="margin-bottom:0px">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>状态</th>
                                        <th>数量</th>
                                        <th>退货</th>
                                        <th>购买金额</th>
                                        <th>实销价</th>
                                        <th>出库仓库</th>
                                        <th class="success">识别码</th>
                                        <th class="success">产品名称</th>
                                        <th class="success">产品单价</th>
                                        <th class="success">产品分类</th>
                                        <th class="success">产品类型</th>
                                        <th>退货</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($var['child'])) {
                                        foreach ($var['child'] as $key2 => $var2) {
                                            $var2['product_data'] = unserialize($var2['product_data']);
                                            ?>
                                            <tr>
                                                <td>{:sprintf("%06d",$var2.id)}</td>
                                                <td>{$var2.status_text}</td>
                                                <td>{$var2.quantity}</td>
                                                <td>{$var2.returns}</td>
                                                <td>{$var2.amount}</td>
                                                <td>{$var2.group_price}</td>
                                                <td>{$var2.warehouse}</td>
                                                <td class="success">{$var2.product_data.code}</td>
                                                <td class="success">{$var2.product_data.name}</td>
                                                <td class="success">{$var2.product_data.sales}</td>
                                                <td class="success">{$var2.product_data.category}</td>
                                                <td class="success">{$var2.product_data.product_type}</td>
                                                <td>
                                                    {if $var2.status>-2}
                                                    <a data-toggle="modal" data-target="#modal" href="{:url('sales_returns_add',['id'=>$var2.id])}" data-title="产品退货" title="退货"><i class="fa fa-reply"></i> 退货</a>
                                                    {/if}
                                                </td>
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
        <table class="table table-hover table-striped" style="margin-bottom:0px">
            <thead>
                <tr>
                    <th colspan="11" style="text-align:center;" class="warning">订单信息</th>
                    <th colspan="5" style="text-align:center" class="success">产品信息</th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>状态</th>
                    <th>数量</th>
                    <th>退货</th>
                    <th>购买金额</th>
                    <th>实销价</th>
                    <th>出库仓库</th>
                    <th>会员</th>
                    <th>创建人</th>
                    <th>创建时间</th>
                    <th>发货日期</th>
                    <th>识别码</th>
                    <th>产品名称</th>
                    <th>产品单价</th>
                    <th>产品分类</th>
                    <th>产品类型</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($lists as $key => $var) {
                    $var['product_data'] = unserialize($var['product_data']);
                    ?>
                    <tr>
                        <td>{:sprintf("%06d",$var.id)}</td>
                        <td>{$var.status_text}</td>
                        <td>{$var.quantity}</td>
                        <td>{$var.returns}</td>
                        <td>{$var.amount}</td>
                        <td>{$var.group_price}</td>
                        <td>{$var.warehouse}</td>
                        <td>{$var.nickname?:'<span class="label label-important">没有客户</span>'}</td>
                        <td>{$var.staff_nickname}</td>
                        <td>{$var.create_time}</td>
                        <td>{$var.ship_time}</td>
                        <td>{$var.product_data.code}</td>
                        <td>{$var.product_data.name}</td>
                        <td>{$var.product_data.sales}</td>
                        <td>{$var.product_data.category}</td>
                        <td>{$var.product_data.type}</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
<?php } ?>
{$pages}
{/block}
{block name="foot_js"}
<script type="text/javascript">
    // 展开列表
    function product_data(id) {
        $('.product_data').hide();
        $('.product_dataplus').html('<i class=\'fa fa-angle-double-right\'></i>');
        $('#product_data' + id).fadeIn();
        $('#product_dataplus' + id).html('<i class=\'fa fa-angle-double-down\'></i>');
    }
</script>
<script>
    $('.export').click(function () {
        //收集form表单数据
        var data = $('form').serialize();
        //console.log(data.toString());
        var url = '<?php echo url('sales_query'); ?>?' + data.toString() + '&export=1';
        //console.log(url);
        location.href = url;
        return false;
    });
</script>
{/block}
