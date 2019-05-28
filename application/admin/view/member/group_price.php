{extend name="base:base" /} {block name="body"} 
<div class="table-common">
    <div class="left">
        <a class="btn btn-default" href="<?php echo url('member/group') ?>"><i class="fa fa-angle-left"></i> 返回列表</a>
        <button type="submit" class="btn btn-primary ajax-post" target-form="form-horizontal"><i class="fa fa-save"></i> 保存</button>
    </div>
</div>
<form class="form-horizontal" action="{:url('group_price')}" method="post">
    <div class="table-responsive">
        <table class="table table-hover text-nowrap" id="bank_list">
            <thead>
                <tr>
                    <th>识别码</th>
                    <th>产品名称</th>
                    <th>销售价</th>
                    <?php foreach ($m_group as $key2 => $val2) {
                        ?>
                        <th style="text-align:center"><?php echo $val2['name'] ?></th>
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
                            <td style="text-align:center">
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
    </div>

</form>
{/block} 