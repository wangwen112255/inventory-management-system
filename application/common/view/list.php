



<?php if (count($lists) == 0) { ?>
    <p class="bg-warning center-block">   
        <i class="iconfont icon-wushuju"></i> 暂时没有相关数据
    </p>
<?php } else { ?>


    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>

                    <input type="checkbox" name=""  class="check-all">

                </th>
                <?php foreach ($table_datas as $key0 => $field) {
                    ?>
                    <?php if ($key0 == 'sort') { ?>
                        <th><button  class="btn btn-primary btn-xs ajax-post" target-form="listorders" url="<?php echo url('listorders', ['table' => $field['table']]); ?>">排序</button></th>
                    <?php } else { ?>
                        <th><?php echo $field['title'] ?></th>
                    <?php } ?>
                <?php } ?>
                <th>管理操作</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($lists as $key => $value) {
                ?>
                <tr>
                    <td>
                        <input type="checkbox" name="ids[]" title="" class="ids" value='<?php echo $value['id']; ?>' /> 

                    </td>
                    <?php foreach ($table_datas as $key0 => $field) {
                        ?>



                        <?php if ($field['type'] == 'input') { ?>
                            <td> <input name="<?php echo $key0 . '[' . $value['id'] . ']' ?>" type="text" size="3" value="<?php echo $value[$key0]; ?>" class="listorders">  </td>




                        <?php } elseif ($field['type'] == 'image') {
                            ?>
                            <td> 
                                <?php if ($value[$key0]) { ?>
                                    <img src="<?php echo img_resize($value[$key0], 80, 0); ?>" style="max-width: 80px; max-height: 80px;"  class="img-thumbnail"  />  
                                <?php } ?>
                            </td>


                        <?php } elseif (strpos($key0, ':') !== false) {
                            ?>
                            <td> <?php
                                $key0_arr = explode(':', $key0);
                                foreach ($key0_arr as $value1) {
                                    echo $value[$value1] . ' ';
                                }
                                ?>  </td>

                        <?php } else { ?>
                            <td> <?php echo isset($value[$key0]) ? $value[$key0] : '' ?>  </td>
                        <?php } ?>
                    <?php } ?>
                    <td>  
                        <?php
                        // print_r($table_actions);exit;
                        $tpl = ' <a class="layui-btn layui-btn-normal layui-btn-xs %class%" href="%href%" %attr%  >%icon%%title%</a> ';
                        foreach ($table_actions as $actions) {
                            echo str_replace(array('%title%', '%class%', '%href%', '%icon%', '%attr%'), array($actions['title'], $actions['class'], url($actions['href'], ['id' => $value['id']]), $actions['icon'], $actions['attr']), $tpl);
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>


<?php } ?>