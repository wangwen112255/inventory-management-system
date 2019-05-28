<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $field['title'] ?></label>
            <div class="col-sm-6">


                <a href="" id="thumb_image" data-toggle="image" class="img-thumb">              
                    <img src="<?php echo sq_img_resize($value_result, 240, 0); ?>" style='cursor:hand;' class="img-thumbnail" data-src="holder.js/160x160" />
                </a>
                <input type="hidden" name="<?php echo $field['name'] ?>" value="<?php echo $field['result'] ?>" id="input_image" />


            </div>
        </div>