{extend name="base:base" /} {block name="body"} 
<ul class="nav nav-tabs">  
    <?php
    foreach ($navs as $key => $value) {
        if (strpos($key, $category) !== false) {
            echo '<li class="active"> <a href="' . url('config', array('category' => $key)) . '">' . $value . '</a> </li>';
        } else {
            echo '<li> <a href="' . url('config', array('category' => $key)) . '">' . $value . '</a> </li>';
        }
    }
    ?>
</ul>
<div class="bg-warning" role="alert">
    系统参数，谨慎操作，调用方法config('<?php echo str_replace('.php', '', $category) ?>')
</div>


<form method="post" class="form" action="<?php echo url('config'); ?>" >


    <input type="hidden" name="category" value="<?php echo $category; ?>" />
    <input type="hidden" name="title" value="<?php echo $title ?>" />

    <table id="images" class="table table-hover">
        <col width="300" />
        <col width="300" />
        <col width="300"/>
        <col   />
        <thead>
            <tr>
                <th>键</th>
                <th>值</th>
                <th>备注</th>
                <th><a onclick="addImage();" class="add_image btn btn-primary btn-sm"><i class="iconfont icon-tianjia"></i></a> </th>
            </tr>
        </thead>
        <tbody id="tbody">
            <?php
            foreach ($lists[0] as $key2 => $value2) {
                ?>
                <tr id="gallery-image-row<?php echo $key2; ?>"> 
                    <td><input type="text" name="configs[<?php echo $key2; ?>][key]" value="<?php echo $lists[1][$key2] ?>" class="form-control"></td> 
                    <td><input type="text" name="configs[<?php echo $key2; ?>][value]" value="<?php echo $lists[2][$key2] ?>" class="form-control"></td> 
                    <td><input type="text" name="configs[<?php echo $key2; ?>][remark]" value="<?php echo ltrim($lists[4][$key2], '//') ?>" class="form-control"></td> 
                    <td><button type="button" onclick="document.getElementById('gallery-image-row<?php echo $key2; ?>').remove();value_row--;" data-toggle="tooltip" class="btn btn-danger btn-sm"><i class="iconfont icon-shanchu"></i></button></td>
                </tr>    
            <?php } ?>
        </tbody>		                  
    </table>


    <button type="submit" class="btn btn-primary ajax-post" target-form="form"><i class="iconfont icon-tubiao_tijiao"></i> 保存</button>


</form>



{/block}


{block name="foot_js"}
<script>
    var value_row = <?php echo count($lists[0]); ?>;
    function addImage() {

        var html = '';
        //  html = '<tr id="gallery-image-row' + value_row + '">';
        html += '  <td><input type="text" name="configs[' + value_row + '][key]" value="" class="form-control" /></td>';
        html += '  <td><input type="text" name="configs[' + value_row + '][value]" value="" class="form-control" /></td>';
        html += '  <td><input type="text" name="configs[' + value_row + '][remark]" value="" class="form-control" /></td>';
        html += '  <td><button type="button" onclick="document.getElementById(\'gallery-image-row' + value_row + '\').remove();value_row--;" data-toggle="tooltip" class="btn btn-danger btn-sm"><i class="iconfont icon-shanchu"></i></button></td>';
        //  html += '</tr>';       
        var tr = document.createElement("tr");
        tr.id = "gallery-image-row" + value_row + "";
        tr.innerHTML = html;
        document.getElementById("tbody").appendChild(tr);
        value_row++;

        // Holder.run();
    }
</script>
{/block}