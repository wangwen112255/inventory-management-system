{extend name="base:base" /} {block name="body"} 
<div class="table-common">
    <div class="search-box">
        <form class="form-inline" action="{:url('scrapped_query')}" method="get">

            <input size="16" type="text" class="datetime_search form-control" name="timea" value="{$Think.get.timea}" placeholder="创建开始日期">
            <i class="fa fa-arrows-h"></i>
            <input size="16" type="text" class="datetime_search form-control" name="timeb" value="{$Think.get.timeb}" placeholder="创建结束日期">

            <input type="text" placeholder="识别码/产品名称" name="keyword" value="{$Think.get.keyword}" class="form-control">

            <select name="warehouse" class="form-control">
                <option value="">所有仓库</option>
                <?php echo html_select($warehouse, input('get.jin_id')) ?> 
            </select>
            <select name="c_id" class="form-control">
                <option value="">所有分类</option>
                <?php echo html_select($category, input('get.c_id')) ?>
            </select>
            <select name="type" class="form-control">
                <option value="">类型</option>
                <?php echo html_select(config('_dict_product_type'), input('get.type')) ?>                
            </select>
            <button type="submit" class="btn btn-primary" title="查询"><i class="fa fa-search"></i> 搜索</button>
        </form>
    </div>
</div>
<p>
    <small> 查询到了<strong>{$count}</strong>个报废记录</small>
</p>
<?php if (count($lists) == 0) { ?>
    <p class="bg-warning center-block">   
        <i class="fa fa-exclamation-circle"></i> 暂时没有相关数据
    </p>
<?php } else { ?>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th colspan="5" style="text-align:center" class="warning">仓库信息</th>
                <th colspan="5" style="text-align:center" class="success">产品信息</th>
            </tr>
            <tr>
                <th>ID</th>
                <th>创建日期</th>
                <th>操作人</th>
                <th>仓库</th>
                <th>数量</th>
                <th>识别码</th>
                <th>产品名称</th>
                <th>产品分类</th>
                <th>产品类型</th>
                <th>备注</th>
            </tr>
        </thead>
        <tbody>
            {volist name="lists" id="var"}
            <tr>
                <td>{:sprintf("%06d",$var.id)}</td>
                <td>{$var.create_time}</td>
                <td>{$var.nickname}</td>
                <td>{$var.warehouse}</td>
                <td>{$var.quantity}</td>
                <td>{$var.code}</td>
                <td>{$var.name}</td>
                <td>{$var.category}</td>
                <td>{$var.type}</td>
                <td title="{$var.remark}">{$var.remark}</td>
            </tr>
            {/volist}
        </tbody>
    </table>
    {$pages}
<?php } ?>
{/block}
