{extend name="base:base" /}{block name="body"}  
<div class="table-common">
    <div class="left">
        <form class="form-inline" action="{:url('unit')}" method="get">
            <a data-toggle="modal" data-target="#modal" data-title="新增单位" href="<?php echo url('unit_add') ?>" title="新增单位" class="btn btn-default">
                <i class="fa fa-plus-circle"></i> 新增单位</a>
        </form>
    </div>
</div>
<p>
    <small> 查询到了<strong>{$lists|count}</strong>个单位</small>
</p>
{$tpl_list}
{/block}