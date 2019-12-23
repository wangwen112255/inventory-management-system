{extend name="base:base" /}
{block name="body"}  
<div class="table-common">
    <div class="search-box">
        <form class="form-inline" action="{:url('product_relation')}" method="get">
            <input type="text" placeholder="识别码/产品名称" name="keyword" value="{$Think.get.keyword}" class="form-control" />
            <button type="submit" class="btn btn-primary " title="搜索"><i class="fa fa-search"></i> 搜索</button>
        </form>
    </div>
</div>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>识别码</th>
            <th>产品图片</th>
            <th>产品名称</th>
            <th>包材数量</th>
            <th>操作</th>
        </tr>
    </thead>
    <?php
    foreach ($lists as $key => $value) {
        ?>
        <tr>
            <td><?php echo $value['code'] ?></td>
            <td><img src="<?php echo img_resize($value['image'], 80, 80) ?>" class="img-thumbnail" /></td>
            <td><?php echo $value['name'] ?></td>
            <td><?php echo $value['bc_count'] > 0 ? $value['bc_count'] : '' ?></td>
            <td>
                <a class="btn btn-success btn-sm" href="<?php echo url('product_relation_edit', ['id' => $value['id']]) ?>"><i class="fa fa-cog"></i> 配置 </a>
            </td>
        </tr>
    <?php } ?>
</table>
{/block}
