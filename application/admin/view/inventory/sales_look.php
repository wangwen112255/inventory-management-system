{extend name="base:base" /} {block name="body"} 
<div class="text-left">
    <a href="javascript:history.back(-1);" title="返回" class="btn btn-default"><i class="fa fa-angle-left"></i> 返回</a>
    <a href="javascript:;" 
       class="print btn btn-default"
       title="打印订单{$one.id}"
       num="{$one.order_number}"
       val="<?php echo url('prints/orders_view', ['id' => $one['id']]) ?>"        >
        <i class="fa fa-print"></i> 打印</a>
</div>
<hr>

<div class="container">
    <table class="table table-hover">
        <tr>
            <td rowspan="4" align="center" valign="middle" style="text-align:center"><span id="code"></span></td>
            <th style="text-align:right">订单号</th>
            <td>{$one.order_number}</td>
            <th style="text-align:right">创建人</th>
            <td>{$one.staff_nickname}</td>
            <th style="text-align:right">创建日期</th>
            <td>{$one.create_time}</td>
        </tr>
        <tr>
            <th style="text-align:right"><span style="text-align:right">客户</span></th>
            <td>{$one.nickname?:'<span class="label label-important">没有客户</span>'}</td>
            <th style="text-align:right">金额</th>
            <td>{$one.amount}</td>
            <th style="text-align:right">产品数量</th>
            <td>{$one.count_data}</td>
        </tr>
        <tr>
            <th style="text-align:right">地址</th>
            <td>{$one.express_addr}</td>
            <th style="text-align:right">快递公司</th>
            <td>{$one.express_name}</td>
            <th style="text-align:right">快递单号</th>
            <td>{$one.express_num}</td>
        </tr>
        <tr>
            <th style="text-align:right">出库日期</th>
            <td>{$one.ship_time}</td>
            <th style="text-align:right">备注</th>
            <td colspan="3">{$one.remark}</td>
        </tr>
    </table>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th colspan="5" style="text-align:center" class="warning">订单信息</th>
                <th colspan="5" style="text-align:center" class="success">产品信息</th>
            </tr>
            <tr>
                <th>状态</th>
                <th>数量</th>
                <th>购买金额</th>
                <th>出库仓库</th>
                <th>识别码</th>
                <th>产品名称</th>
                <th>产品单价</th>
                <th>产品分类</th>
                <th>产品类型</th>
                <th>产品规格</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $quantity = 0;
            $amount = 0;
            $sales = 0;
            foreach ($orders as $key => $val) {
                $val['product_data'] = unserialize($val['product_data']);
                $quantity += $val['quantity'];
                $amount += $val['amount'];
                $sales += $val['product_data']['sales'];
                ?>
                <tr>
                    <td>{$val.status}</td>
                    <td>{$val.quantity}</td>
                    <td>{$val.amount}</td>
                    <td>{$val.warehouse}</td>
                    <td>{$val.product_data.code}</td>
                    <td>{$val.product_data.name}</td>
                    <td>{$val.product_data.sales}</td>
                    <td>{$val.product_data.category}</td>
                    <td>{$val.product_data.type}</td>
                    <td>{$val.product_data.format}</td>
                </tr>
            <?php } ?>
        </tbody>
        <thead>
            <tr><th></th>
                <th>{$quantity}</th>
                <th>{$amount}</th>
                <th></th>
                <th></th>
                <th></th>
                <th>{$sales}</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
    </table>     
    <hr />
    <form  class="form-inline express_update" action="{:url('sales_look_info_update',['id'=>$one.id])}" method="get">
        <select name="express_id" class="form-control">
            <option value="">选择</option>
            {volist name="express_lists" id="varr"}
            <option value="{$varr.id}" {eq name="$varr.id" value="$one.express_id"} selected{/eq} >{$varr.name}</option>
            {/volist}
        </select>
        <input size="20" type="text" class="form-control" name="express_num" value="{$one.express_num}" placeholder="快递单号">        
        <input size="80" type="text" class="form-control" name="express_addr" value="{$one.express_addr}" placeholder="快递地址">        
        <button type="submit" class="btn btn-primary ajax-post" target-form="express_update">更新快递信息</button>
    </form>
</div>
{/block}   
{block name="foot_js"} 
<script type="text/javascript" src="__PUBLIC__/libs/qrcode/jquery.qrcode.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#code").qrcode({
            width: 80,
            height: 80,
            text: "{$one.order_number}"
        });
    });
</script>{/block}