{extend name="base:base" /}
{block name="body"}  
<style>
    td.title {background:#f9f9f9; font-weight:bold;}
</style>
<div class="table-common">     
    选择一个目录
    <?php
    foreach ($folder as $key => $val) {
        echo '<a href="' . url('node_parse', array('dir' => $val)) . '">' . $val . '</a>  | ';
    }
    ?>
    <a class="btn btn-primary ajax-get no-refresh" href="<?php echo url('node_refresh') ?>">导入到系统</a>
    <font color="red">导入后所有【员工分组】需要重新配置权限 </font>
</div>
<br />
<table class='table table-hover '>
    <?php
    foreach ($service_annotation as $k => $v) {
        ?>
        <tr>
            <td class='title'><?php echo $k; ?></td>
            <td class='title'><?php echo $v['title']; ?></td>
            <td class='title'>URL</td>
            <td class='title'>打开</td>
        </tr>
        <?php
        if (isset($v['child'])) {
            foreach ($v['child'] as $k2 => $v2) {
                ?>
                <tr>
                    <td><?php echo $k2; ?></td>
                    <td><?php echo isset($v2['title']) ? $v2['title'] : '<span style="color:red">未设置title标签</span>'; ?></td>
                    <td><?php echo $dir . '/' . $k . '/' . $k2; ?></td>
                    <td><a href="<?php echo url($dir . '/' . $k . '/' . $k2); ?>" target="_blank">打开</a></td>
                </tr>
                <?php
            }
        }
        ?>
        <?php
    }
    ?>
</table>
{/block}