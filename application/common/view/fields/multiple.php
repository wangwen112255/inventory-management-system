<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $field['title'] ?></label>
            <div class="col-sm-6">

                <select multiple class="form-control" name="<?php echo $field['name'] ?>[]" size="10">


                    <?php
                    //$c = $key . '_values';

 

                        echo html_select($field['options'], $value_result);
                 
                    ?>



                </select>


            </div><div class="check-tips"><?php echo $field['description'] ?></div>
        </div>