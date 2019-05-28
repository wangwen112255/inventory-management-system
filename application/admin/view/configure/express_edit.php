<div class="panel panel-default">
    <div class="panel-heading">快递编辑
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" action="{:url('express_edit')}"  method="POST" >
            <input type="hidden" name="id" value="{$Think.get.id}" />
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">名称<font color="red">*</font></label>
                <div class="col-sm-10 form-inline">
                    <input type="text" name="name" value="{$var.name}"  class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary ajax-post" target-form="form-horizontal"><i class="fa fa-save"></i> 保存</button>                 
                </div>
            </div>
        </form>
    </div>
</div>
