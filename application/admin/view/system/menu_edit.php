{extend name="base:base" /}{block name="body"}  
<div class="table-common">
    <div class="left">
        <a class="btn btn-default" href="javascript:history.back();"><i class="fa fa-angle-left"></i> 返回</a>
    </div>
</div>
<form method="post" class="form-horizontal" action="{:url('menu_edit')}">
    <input type="hidden" name="id" value="{$Think.get.id}" />
    {$tpl_form}
    <div class="form-group form-actions">
        <div class="col-sm-offset-2 col-sm-5">
            <button type="submit" class="btn btn-primary btn_submit ajax-post" target-form="form-horizontal"><i class="fa fa-save"></i> 保存</button>
        </div>
</form>
{/block}
