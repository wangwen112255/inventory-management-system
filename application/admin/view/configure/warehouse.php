{extend name="base:base" /}{block name="body"}  
<div class="table-common">
    <div class="left">
        <a data-toggle="modal" data-target="#modal" data-title="新增仓库" href="{:url('warehouse_add')}" title="新增仓库" class="btn btn-default"><i class="iconfont icon-tianjia"></i> 新增仓库</a>
    </div>
</div>
<p>
    <small><i class="iconfont icon-tishi"></i> 查询到了<strong>{$lists|count}</strong>个仓库</small>
</p>
{$tpl_list}
{/block}