{extend name="base:base" /} {block name="body"} 
<style>
    .nav>li>a{
        padding-top: 2px;
        padding-bottom:2px;
    }
    .nav{ margin-bottom: 0px;}
</style>
<div class="table-common">
    <form class="form-inline" action="{:url('stock_query')}" method="get">
        <div class="search-box">
            <input type="text" placeholder="ID/识别码/产品名称" name="keyword" value="{$Think.get.keyword}" class="form-control">
            <input type="text" class="form-control" style="width: 70px" name="lowesta" value="{$Think.get.lowesta}" placeholder="库存">
            <i class="fa fa-arrows-h"></i>
            <input type="text" class="form-control" style="width: 70px" name="lowestb" value="{$Think.get.lowestb}" placeholder="库存">
            <select name="warehouse" class="form-control">
                <option value="">所有仓库</option>
                <?php echo html_select($warehouse, input('get.warehouse')) ?>
            </select>
            <select name="c_id" class="form-control">
                <option value="">所有分类</option>
                <?php echo html_select(model('product_category')->lists_select_tree(), input('get.c_id')); ?>       
            </select>
            <select name="type" class="form-control">
                <option value="">类型</option>
                <?php echo html_select(config('_dict_product_type'), input('get.type')) ?>                
            </select>
            <button type="submit" class="btn btn-primary" title="查询"><i class="fa fa-search"></i> 搜索</button>
        </div>
        <div class="search-box">
            <ul class="nav nav-pills">
                <?php
                foreach ($warehouse as $key => $value) {
                    ?>
                    <li role="presentation" <?php
                    if (request()->get('warehouse') == $key) {
                        echo 'class="active"';
                    }
                    ?> ><a href="<?php echo url('stock_query', ['warehouse' => $key]) ?>"><?php echo $value ?></a></li>
                    <?php } ?>
            </ul>
        </div>
    </form>
</div>
<p>
    <small> 查询到了<strong>{$count}</strong>个库存记录</small>
</p>
<?php if (isset($lists) && count($lists) > 0) { ?>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th colspan="3" style="text-align:center" class="warning">仓库信息</th>
                <th colspan="6" style="text-align:center" class="success">产品信息</th>
            </tr>
            <tr>
                <th>ID</th>
                <th>仓库</th>
                <th>库存</th>
                <th>识别码</th>
                <th>产品名称</th>
                <th>产品分类</th>
                <th>产品类型</th>
                <th style="text-align:center">删除</th>
                <th style="text-align:center">操作</th>
            </tr>
        </thead>
        <tbody>
            {volist name="lists" id="var"}
            <tr>
                <td>{:sprintf("%06d",$var.inventory_id)}</td>
                <td>{$var.warehouse}</td>
                <td>
                    {elt name="var.quantity" value="$var.lowest"}
                    <span class="badge badge-important">{$var.quantity}</span>
                    {else/}
                    {$var.quantity}
                    {/elt}
                    {$var.unit_name}
                </td>
                <td>{$var.code}</td>
                <td>{$var.name}</td>
                <td>{$var.category}</td>
                <td>{$var.type}</td>
                <td style="text-align:center">
                    <?php if ($var['quantity'] == 0) { ?>
                        <a href="{:url('stock_delete',['id'=>$var.inventory_id])}" class="ajax-get confirm" title="删除"><i class="fa fa-remove"></i> 删除</a>
                    <?php } ?>
                </td>
                <td style="text-align:center">
                    <a data-toggle="modal" data-target="#modal" href="{:url('transfer_add',['id'=>$var.inventory_id])}" data-title="产品调出"  title="调出"><i class="fa fa-share"></i> 调出</a>
                    <a data-toggle="modal" data-target="#modal" href="{:url('scrapped_add',['id'=>$var.inventory_id])}" data-title="产品报废" title="报废"><i class="fa fa-trash"></i> 报废</a>
                    <a href="{:url('admin/configure/product_look',['id'=>$var.p_id, 'w_id'=>$var.w_id])}" data-title="产品查看" title="查看"><i class="fa fa-search"></i> 查看</a>
                </td>
            </tr>
            {/volist}
        </tbody>
    </table>
    {$pages}
<?php } else { ?>
    <p class="bg-warning center-block">   
        <i class="fa fa-exclamation-circle"></i> 暂时没有相关数据
    </p>
<?php } ?>
{/block}
