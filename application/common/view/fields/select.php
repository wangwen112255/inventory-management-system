<div class="form-group form-inline">
    <label class="col-sm-2 control-label"><?php echo $field['title'] ?></label>
    <div class="col-sm-6 ">

        <select class="form-control" name="<?php echo $field['name'] ?>" >
            <option value="">=请选择=</option>
            <?php
            echo html_select($field['options'], $field['result']);
            ?>
        </select>
    </div>
</div>