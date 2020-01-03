{extend name="base:base" /}{block name="body"}  
<div class="table-common">
    <div class="left">
        <form class="form-inline" action="{:url('unit')}" method="get">
            <a data-toggle="modal" data-target="#modal" data-title="新增单位" href="<?php echo url('unit_add') ?>" title="新增单位" class="btn btn-default">
                <i class="iconfont icon-tianjia"></i> 新增单位</a>
        </form>
    </div>
</div>
<p>
    <small><i class="iconfont icon-tishi"></i> 查询到了<strong>{$lists|count}</strong>个单位</small>
</p>
{$tpl_list}
{/block}