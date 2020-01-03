{extend name="base:base" /} {block name="body"} 
<div class="table-common">
    <div class="left">
        <a class="btn btn-default" href="<?php echo url('category_add', ['type' => 0]); ?>"><i class="iconfont icon-tianjia"></i> 添加支出</a>
        <a class="btn btn-default" href="<?php echo url('category_add', ['type' => 1]); ?>"><i class="iconfont icon-tianjia"></i> 添加收入</a>
    </div>
    <div class="left">
        <form class="form-inline" action="{:url('category')}" method="get">            
            <select name="type" class="form-control">
                <option value="">全部</option>
                <option value="1"{eq name="Think.get.type" value="1"} selected{/eq}>收入</option>
                <option value="0"{eq name="Think.get.type" value="0"} selected{/eq}>支出</option>
            </select>
            <button type="submit" class="btn btn-primary" title="查询账务分类"><i class="iconfont icon-sousuo"></i> 搜索</button>
        </form>
    </div>
</div>
{$tpl_list}
{/block}
