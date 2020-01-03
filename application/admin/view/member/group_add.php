<div class="panel panel-default">
    <div class="panel-heading">会员分组添加
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="panel-body">

        <form class="form-horizontal" action="{:url('group_add')}" method="post">
            {$tpl_form}
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary ajax-post"  target-form="form-horizontal"><i class="iconfont icon-tubiao_tijiao"></i> 保存</button>                 
                </div>
            </div>
        </form>

    </div>
</div>