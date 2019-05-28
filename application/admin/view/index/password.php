{extend name="base:base" /}
{block name="body"}  
<ul class="nav nav-tabs">
    <li role="presentation" class="active"><a href="#">密码修改</a></li> 
</ul>
<form class="form-horizontal" method="post" action="<?php echo url('password'); ?>">
    <fieldset>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="repassword">新密码<font color="red">*</font></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="password" name="password">
            </div>
        </div>
        <div class="form-group form-actions">
            <div class="col-sm-offset-2 col-sm-5">
                <button type="submit" class="btn btn-primary ajax-post"  target-form="form-horizontal">更新</button>
            </div>
        </div>
    </fieldset>
</form>
{/block}