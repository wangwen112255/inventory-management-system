{extend name="base:base" /} {block name="body"} 
<div class="table-common">
    <form class="form-inline" action="{:url('storage_query')}" method="get">
        <input type="hidden" id="chartinput" name="chart" value="{$chart}" />
        <div class="search-box">            
            <input size="16" type="text" class="datetime_search form-control" name="timea" value="{$Think.get.timea}" placeholder="创建开始日期">
            <i class="fa fa-arrows-h"></i>
            <input size="16" type="text" class="datetime_search form-control" name="timeb" value="{$Think.get.timeb}" placeholder="创建结束日期">

            <input type="text" placeholder="单号/识别码/产品名称" name="keyword" value="{$Think.get.keyword}" class="form-control">

             
            <select name="warehouse" class="form-control">
                <option value="">所有仓库</option>
                <?php echo html_select($warehouse, input('get.warehouse')) ?>                
            </select>
            <select name="supplier" class="form-control">
                <option value="">所有供应商</option>
                <?php 
                echo html_select(db('product_supplier')->column('id,company'), input('get.supplier'))
                ?>                
            </select>
            <select name="c_id" class="form-control">
                <option value="">所有分类</option>
                <?php echo html_select($category, input('get.c_id')); ?>       
            </select>
            <select name="type" class="form-control">
                <option value="">类型</option>
                <?php echo html_select(config('_dict_product_type'), input('get.type')) ?>                
            </select>
            
            <div class="btn-group" data-toggle="buttons-radio">
                <button type="button" onclick="$('#chartinput').val(0); $('form').submit()" class="btn {:empty($chart)?' active':''} btn-default"><i class="fa fa-list-alt"></i> 入库订单</button>
                <button type="button" onclick="$('#chartinput').val(1); $('form').submit()" class="btn-default btn {$chart==='1'?' active':''}"><i class="fa fa-table"></i> 产品列表</button>
            </div>

            <button type="submit" class="btn btn-primary" title="查询"><i class="fa fa-search"></i> 搜索</button>
            {if $chart==='1'}
            <button type="button" class="btn btn-default" 
                    id="print"
                    title="打印入库单" 
                    val="<?php echo url('prints/storage_list'); ?>" 
                    >
                <i class="fa fa-print"></i> 打印</button>
            {/if}
        </div>


    </form>
</div>
<p>
    <small> 查询到了<strong>{$count}</strong>个入库记录</small>
    <?php if (isset($count_sum)) { ?>
        <small> 总数量<strong>{$count_sum}</strong></small>
    <?php } ?>
</p>
<?php if (isset($lists) && count($lists) > 0) { ?>
    <?php if (empty($chart)) { ?>
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th style="width:20px"></th>
                    <th>编号</th>
                    <th>入库数量</th>
                    <th>金额</th>
                    <th>入库日期</th>
                    <th>入库人</th>
                    <th>供应商</th>
                    <th>入库类型</th>
                    <th>备注</th>
                    <th style="text-align:center">打印</th>
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
                        <td onclick="product_data('{$var.id}')">{$var.quantity}</td>
                        <td onclick="product_data('{$var.id}')">{$var.amount}</td>
                        <td onclick="product_data('{$var.id}')">{$var.create_time}</td>
                        <td onclick="product_data('{$var.id}')">{$var.nickname}</td>
                        <td onclick="product_data('{$var.id}')">{$var.company}</td>
                        <td onclick="product_data('{$var.id}')">{$var.type}</td>
                        <td onclick="product_data('{$var.id}')" title="{$var.remark}">{$var.remark}</td>
                        <td style="text-align:center">
                            <a href="javascript:;" 
                               class="print"
                               val="<?php echo url('prints/storage_view', ['id' => $var['id']]) ?>"
                               num="<?php echo $var['order_number']; ?>"                       
                               title="打印{$var.id}">
                                <i class="fa fa-print"></i> 打印</a></td>
                        <td style="text-align:center">
                            <a href="{:url('storage_undo',['id'=>$var.id])}" class="ajax-get confirm" title="撤销" ><i class="fa fa-reply-all"></i> 撤销</a>
                        </td>
                    </tr>
                    <tr id="product_data{$var.id}" class="product_data" style="display:none">
                        <td colspan="11">
                            <table class="table table-hover table-striped table-bordered" style="margin-bottom:0px">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>仓库</th>
                                        <th>数量</th>
                                        <th>金额</th>
                                        <th>库存</th>
                                        <th>单位</th>
                                        <th>识别码</th>
                                        <th>产品名称</th>
                                        <th>成本价</th>
                                        <th>产品类型</th>
                                        <th>产品分类</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($var['child'])) {
                                        foreach ($var['child'] as $key2 => $var2) {

                                            $var2['product_data'] = unserialize($var2['product_data']);
                                            ?>
                                            <tr>
                                                <td>{:sprintf("%06d",$var2.id)}</td>
                                                <td>{$var2.warehouse}</td>
                                                <td>{$var2.quantity}</td>
                                                <td>{$var2.amount}</td>
                                                <td>{$var2.inventory_quantity}</td>
                                                <td>{$var2.unit_name}</td>
                                                <td>{$var2.code}</td>
                                                <td>{$var2.name}</td>
                                                <td>{$var2.purchase}</td>
                                                <td>{$var2.product_data.product_type}</td>
                                                <td>{$var2.product_data.category}</td>
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
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th colspan="7" style="text-align:center" class="warning">仓库信息</th>
                    <th colspan="5" style="text-align:center" class="success">产品信息</th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>仓库</th>
                    <th>入库</th>
                    <th>库存</th>
                    <th>单位</th>
                    <th>入库日期</th>
                    <th>入库人</th>
                    <th>识别码</th>
                    <th>产品名称</th>
                    <th>产品类型</th>
                    <th>产品分类</th>
                    <th>供应商</th>
                </tr>
            </thead>
            <tbody>
                {volist name="lists" id="var"}
                <tr>
                    <td>{:sprintf("%06d",$var.id)}</td>
                    <td>{$var.name}</td>
                    <td>{$var.quantity}</td>
                    <td>{$var.inventory_quantity}</td>
                    <td>{$var.unit_name}</td>
                    <td>{$var.create_time}</td>
                    <td>{$var.storage_nickname}</td>
                    <td>{$var.code}</td>
                    <td>{$var.name}</td>
                    <td>{$var.type}</td>
                    <td>{$var.category}</td>
                    <td>{$var.company}</td>
                </tr>
                {/volist}
            </tbody>
        </table>
    <?php } ?>    
    {$pages}
<?php } else { ?>
    <p class="bg-warning center-block">   
        <i class="fa fa-exclamation-circle"></i> 暂时没有相关数据
    </p>
<?php } ?>
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