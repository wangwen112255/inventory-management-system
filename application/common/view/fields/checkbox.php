<div class="form-group">
    <label class="col-sm-2 control-label"><?php echo $field['title'] ?></label>
    <div class="col-sm-6">
        <?php
        echo html_checkbox($field['name'], $field['options'], $field['result']);
        ?>
    </div><div class="check-tips"><?php echo $field['description'] ?></div>
</div>