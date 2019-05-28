
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $field['title'] ?></label>
            <div class="col-sm-6">




                <table id="images" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-left">商品图片</th>
                            <th class="text-left">图片描述</th>
                            <th class="text-right">选项排序</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php
                        foreach ($value[3] as $key2 => $value2) {
                            ?>


                            <tr id="gallery-image-row<?php echo $key2; ?>"> 
                                <td class="text-left">

                                    <a href="#" id="thumb-image<?php echo $key2; ?>" data-toggle="image" class="img-thumbnail">
                                        <img src="<?php echo sq_img_resize($value2['image'], 100, 0); ?>" style="max-width: 60px;max-height: 60px;" />
                                        <input type="hidden" name="image_ids[<?php echo $key2; ?>][image]" value="<?php echo $value2['image']; ?>" id="gallery-input-image<?php echo $key2; ?>"></a>
                                </td> 
                                <td class="text-right"><input type="text" name="image_ids[<?php echo $key2; ?>][description]" value="<?php echo $value2['description']; ?>" class="form-control"></td> 
                                <td class="text-right"><input type="text" name="image_ids[<?php echo $key2; ?>][listorder]" value="<?php echo $value2['listorder']; ?>" class="form-control"></td> 
                                <td class="text-left"><button type="button" onclick="$('#gallery-image-row<?php echo $key2; ?>').remove();" data-toggle="tooltip" class="btn btn-danger">
                                        <i class="fa fa-trash"></i></button>
                                </td>
                            </tr>    

                        <?php } ?>







                    </tbody>		                  
                </table>


                <a  onclick="addImage();" class="add_image btn btn-primary ">添加图片</a> 

            </div>

        </div>




        <script>
            var image_row = <?php echo count($value_result); ?>;
            function addImage() {
                html = '<tr id="gallery-image-row' + image_row + '">';
                html += '  <td class="text-left"><a href="#" id="thumb-image' + image_row + '" data-toggle="image" class="img-thumbnail"><img src="__PUBLIC__/common/images/no_image_100x100.jpg" /><input type="hidden" name="image_ids[' + image_row + '][image]" value="" id="gallery-input-image' + image_row + '" /></td>';
                html += '  <td class="text-right"><input type="text" name="image_ids[' + image_row + '][description]" value="" class="form-control" /></td>';
                html += '  <td class="text-right"><input type="text" name="image_ids[' + image_row + '][listorder]" value="' + image_row + '" class="form-control" /></td>';
                html += '  <td class="text-left"><button type="button" onclick="$(\'#gallery-image-row' + image_row + '\').remove();" data-toggle="tooltip" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>';
                html += '</tr>';
                $('#images tbody').append(html);
                image_row++;
            }
        </script>   
