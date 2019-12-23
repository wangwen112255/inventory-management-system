{extend name="base:base" /} {block name="body"} 
<div class="table-common">
    <div class="left">
        <a data-toggle="modal" data-target="#modal" data-title="新增供应商" href="{:url('supplier_add')}" title="新增供应商" class="btn btn-default"><i class="fa fa-plus-circle"></i> 新增供应商</a>
    </div>
    <div class="left">
        <form class="form-inline" action="{:url('supplier')}" method="get">
            <input type="text" placeholder="供应商名称/联系人姓名" name="keyword" value="{$Think.get.keyword}" class="form-control">
            <button type="submit" class="btn btn-primary" title="查询"><i class="fa fa-search"></i> 搜索</button>
        </form>
    </div>
</div>
<p>
    <small> 查询到了<strong>{:count($lists)}</strong>个供应商</small>
</p>
{$tpl_list}
{/block}
