{extend name="base:base" /}
{block name="body"} 
<input size="16" type="text" class="datetime_search form-control" name="timea" value="{$Request.get.timea}" placeholder="创建开始日期">
<i class="fa fa-arrows-h"></i>
<input size="16" type="text" class="datetime_search form-control" name="timeb" value="{$Request.get.timeb}" placeholder="创建结束日期">
<a class="btn btn-primary ajax-get" href="<?php echo url('fsdafa') ?>">发送</a>
{/block}