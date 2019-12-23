{extend name="base:base" /} 
{block name="body"} 
<div class="table-common">
    <div class="left">
        <a href="{:url('product_add')}" title="新增产品" class="btn btn-default"><i class="fa fa-plus-circle"></i> 新增产品</a>
    </div>
    <div class="left">
        <form class="form-inline" action="{:url('product')}" method="get">
            <input type="text" placeholder="识别码/产品名称" name="keyword" value="{$Think.get.keyword}" class="form-control">
            <select name="c_id" class="form-control">
                <option value="">所有分类</option>
                <?php echo html_select(model('product_category')->lists_select_tree(), input('get.c_id')) ?>
            </select>
            <select name="type" class="form-control">
                <option value="">类型</option>
                <?php echo html_select(config('_dict_product_type'), input('get.type')) ?>
            </select>
            
            <button type="submit" class="btn btn-primary" title="查询"><i class="fa fa-search"></i> 搜索</button>
        </form>
    </div>
</div>
<p>
    <small> 查询到了<strong>{$count}</strong>个产品记录</small>
</p>
{$tpl_list}
{$pages}
{/block}
