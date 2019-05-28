{extend name="base:base" /}{block name="body"}  
<div class="table-common">
    <div class="left">
        <a href="{:url('warehouse_add')}" title="新增仓库" class="btn btn-default"><i class="fa fa-plus-circle"></i> 新增仓库</a>
    </div>
</div>
<p>
    <small> 查询到了<strong>{$lists|count}</strong>个仓库</small>
</p>
{$tpl_list}
{/block}