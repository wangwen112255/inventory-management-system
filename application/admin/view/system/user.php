{extend name="base:base" /}
{block name="body"}  
<div class="table-common">
    <div class="left">
        <a class="btn btn-default" href="<?php echo url('user_add'); ?>"><i class="fa fa-plus-circle"></i> 添加</a>
    </div>
</div>
{$tpl_list}
{$pages}
{/block}