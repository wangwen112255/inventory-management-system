{extend name="base:base" /}{block name="body"}  
<form class="form-inline" action="{:url('product_category')}" method="get">
    <a data-toggle="modal" data-target="#modal" href="{:url('product_category_add')}" data-title="新增产品类" title="新增产品类" class="btn btn-default"><i class="iconfont icon-tianjia"></i> 新增分类</a>
</form>
<hr>
<p>
    <small><i class="iconfont icon-tishi"></i> 查询到了<strong>{$lists|count}</strong>个分类</small>
</p>
{$tpl_list}
{/block}