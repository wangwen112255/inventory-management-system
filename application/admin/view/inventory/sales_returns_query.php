{extend name="base:base" /} {block name="body"} 
<div class="table-common">
    <div class="search-box">
        <form class="form-inline" action="{:url('sales_returns_query')}" method="get">
            
            <input size="16" type="text" class="datetime_search form-control" name="timea" value="{$Think.get.timea}" placeholder="创建开始日期">
            <i class="fa fa-arrows-h"></i>
            <input size="16" type="text" class="datetime_search form-control" name="timeb" value="{$Think.get.timeb}" placeholder="创建结束日期">
            
            <input type="text" placeholder="订单号" name="order_number" value="{$Think.get.order_number}" class="form-control">
            <input type="text" placeholder="识别码/产品名称" name="keyword" value="{$Think.get.keyword}" class="form-control">
            
            
            <button type="submit" class="btn btn-primary" title="查询"><i class="fa fa-search"></i> 搜索</button>
        </form>
    </div>
</div>
<p>
    <small> 查询到了<strong>{$count}</strong>个退货记录</small>
</p>
<?php if (count($lists) == 0) { ?>
    <p class="bg-warning center-block">   
        <i class="fa fa-exclamation-circle"></i> 暂时没有相关数据
    </p>
<?php } else { ?>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>退货日期</th>
                <th>会员</th>
                <th>操作人</th>
                <th>退货数量</th>
                <th>入库</th>
                <th>出库</th>
                <th>产品识别码</th>
                <th>产品名称</th>
                <th>产品分类</th>
                <th>产品备注</th>
                <th style="text-align:center">订单</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($lists as $key => $var) {
                $var['product_data'] = unserialize($var['product_data']);
                ?>
                <tr>
                    <td>{:sprintf("%06d",$var.id)}</td>
                    <td>{$var.create_time}</td>
                    <td>{$var.member_nickname}</td>
                    <td>{$var.nickname}</td>
                    <td>{$var.quantity}</td>
                    <td>{$var.name}</td>
                    <td>{$var.name2}</td>
                    <td>{$var.product_data.code}</td>
                    <td>{$var.product_data.name}</td>
                    <td>{$var.product_data.category}</td>
                    <td title="{$var.remark}">{$var.remark}</td>
                    <td style="text-align:center"><a class="btn btn-primary btn-sm" href="{:url('sales_look',['id'=>$var.order_id])}" title="查看产品"><i class="fa fa-search"></i> 查看</a></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    {$pages}
<?php } ?>
{/block}
