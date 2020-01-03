{extend name="base:base" /} {block name="body"} 
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
            <button type="submit" class="btn btn-primary" title="查询"><i class="iconfont icon-sousuo"></i> 搜索</button>
            <button class="btn btn-success export" title="导出"><i class="iconfont icon-excel"></i> 导出</button>
        </div>

        <div class="btn-group search-box" data-toggle="buttons-radio">
            <?php
            foreach ($warehouse as $key => $value) {
                ?>
                <button type="button" onclick="location.href = '<?php echo url('stock_query', ['warehouse' => $key]) ?>'" class="btn  btn-default <?php
                if (request()->get('warehouse') == $key) {
                    echo ' active ';
                }
                ?>"><i class="fa fa-list-alt"></i> <?php echo $value ?></button>
                    <?php } ?>
        </div>

    </form>
</div>
<p>
    <small><i class="iconfont icon-tishi"></i> 查询到了<strong>{$count}</strong>个库存记录</small>
</p>
<?php if (isset($lists) && count($lists) > 0) { ?>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th colspan="3" style="text-align:center" class="warning">仓库信息</th>
                <th colspan="7" style="text-align:center" class="success">产品信息</th>
            </tr>
            <tr>
                <th>ID</th>
                <th>仓库</th>
                <th>库存</th>
                <th>识别码</th>
                <th>产品名称</th>
                <th>图片</th>
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
                <td><img src="<?php echo img_resize($var['image'], 100, 100) ?>" /></td>
                <td>{$var.category}</td>
                <td>{$var.type}</td>
                <td style="text-align:center">
                    <?php if ($var['quantity'] == 0) { ?>
                        <a href="{:url('stock_delete',['id'=>$var.inventory_id])}" class="ajax-get confirm" title="删除"><i class="iconfont icon-shanchu"></i> 删除</a>
                    <?php } ?>
                </td>
                <td style="text-align:center">
                    <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal" href="{:url('transfer_add',['id'=>$var.inventory_id])}" data-title="产品调出"  title="调出"><i class="iconfont icon-tiaobochuku"></i> 调出</a>
                    <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal" href="{:url('scrapped_add',['id'=>$var.inventory_id])}" data-title="产品报废" title="报废"><i class="iconfont icon-baofeishebei"></i> 报废</a>
                    <a class="btn btn-primary btn-sm" href="{:url('admin/configure/product_look',['id'=>$var.p_id, 'w_id'=>$var.w_id])}" data-title="产品查看" title="查看"><i class="iconfont icon-sousuo"></i> 查看</a>
                </td>
            </tr>
            {/volist}
        </tbody>
    </table>
    {$pages}
<?php } else { ?>
    <p class="bg-warning center-block">   
        <i class="iconfont icon-wushuju"></i> 暂时没有相关数据
    </p>
<?php } ?>
{/block}

{block name="foot_js"}
<script>
    $('.export').click(function () {
        //收集form表单数据
        var data = $('form').serialize();
        var url = '<?php echo url('stock_query'); ?>?' + data.toString() + '&export=1';
        location.href = url;
        return false;
    });
</script>
{/block}
