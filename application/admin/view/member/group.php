{extend name="base:base" /} {block name="body"} 
<div class="table-common">
    <div class="left">
        <form class="form-inline" action="{:url('member/group')}" method="get">
            <a data-toggle="modal" data-target="#modal" data-title="新增会员分组"
               href="{:url('group_add')}"  title="新增分组" class="btn btn-default"><i class="iconfont icon-tianjia"></i> 新增分组</a>
            <a href="{:url('group_price')}"  title="销价管理" class="btn btn-default"><i class="iconfont icon-jiagebaohu"></i> 销价管理</a>
        </form>
    </div>
</div>
<p>
    <small><i class="iconfont icon-tishi"></i> 查询到了<strong>{:count($lists)}</strong>个分类</small>
</p>
{$tpl_list}
{/block} 
