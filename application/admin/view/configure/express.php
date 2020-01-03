{extend name="base:base" /}{block name="body"}  
<div class="table-common">
    <div class="left">
        <form class="form-inline" action="{:url('express')}" method="get">
            <a data-toggle="modal" data-target="#modal" href="<?php echo url('express_add') ?>" data-title="新增快递" title="新增快递" class="btn btn-default">
                <i class="iconfont icon-tianjia"></i> 新增快递</a>
        </form>
    </div>
</div>
<p>
    <small><i class="iconfont icon-tishi"></i> 查询到了<strong>{$lists|count}</strong>个快递</small>
</p>
{$tpl_list}
{/block}