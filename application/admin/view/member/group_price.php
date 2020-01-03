{extend name="base:base" /} {block name="body"} 
<div class="table-common">
    <div class="left">
        <a class="btn btn-default" href="<?php echo url('member/group') ?>"><i class="iconfont icon-flow"></i> 返回列表</a>
        <button type="submit" class="btn btn-primary ajax-post" target-form="form-horizontal"><i class="iconfont icon-tubiao_tijiao"></i> 保存</button>
    </div>
</div>
<style>
    th,td{ text-align: center;}
</style>
<form class="form-horizontal" action="{:url('group_price')}" method="post">

    <table class="table table-hover table-striped" data-toggle="table" id="table">
        <thead>
            <tr>
                <th>识别码</th>
                <th>产品名称</th>
                <th>出库价</th>
                <?php foreach ($m_group as $key2 => $val2) {
                    ?>
                    <th><?php echo $val2['name'] ?></th>
                <?php }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($p_list as $key => $val) {
                ?>
                <tr>
                    <td>
                        <?php echo $val['code']; ?>
                    </td>
                    <td>
                        <?php echo $val['name']; ?>
                    </td>

                    <td>
                        <?php echo sprintf("%1\$.2f", $val['sales']); ?>
                    </td>
                    <?php foreach ($m_group as $key2 => $val2) {
                        ?>
                        <td>
                            <input type="text" class="form-control center-block text-center"
                                   style="width: 70px" name="g_price[<?php echo $val['id']; ?>][<?php echo $val2['id']; ?>]"
                                   value="<?php
                                   if (isset($price[$val['id']])) {
                                       if (isset($price[$val['id']][$val2['id']])) {
                                           echo( sprintf("%1\$.2f", $price[$val['id']][$val2['id']]));
                                       } else {
                                           echo 0;
                                       }
                                   } else {
                                       echo 0;
                                   }
                                   ?>"
                                   />
                        </td>
                    <?php }
                    ?>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>


</form>
{/block} 

{block name="foot_js"}

<link rel="stylesheet" href="__PUBLIC__/libs/bootstrap-table/bootstrap-table.min.css">
<script src="__PUBLIC__/libs/bootstrap-table/bootstrap-table.min.js"></script>

<!-- 固定列所需的js和css(bootstrap-table-fixed-columns) -->
<link rel="stylesheet" type="text/css" href="__PUBLIC__/libs/bootstrap-table/bootstrap-table-fixed-columns.css">
<script src="__PUBLIC__/libs/bootstrap-table/bootstrap-table-fixed-columns.js"></script>


<script>
    $(function () {
         $("#table").bootstrapTable('destroy').bootstrapTable({
                            height: $(window).height() - 100,
                    fixedColumns: true, 
                    fixedNumber: 3 //固定列数
            });

        $(window).resize(function () {
            $('#table').bootstrapTable('resetView');
        });
    });

</script>

{/block}