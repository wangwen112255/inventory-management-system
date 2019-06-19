<div class="form-group">
    <label class="col-sm-2 control-label"><?php echo $field['title']; ?></label>
    <div class="col-sm-6">
        <img class="open-img-res" id="<?php echo $field['name']; ?>" data-hidden="<?php echo $field['name']; ?>_hidden" src="<?php echo img_resize($field['result'], 240, 0); ?>" style='cursor:pointer;' <?php echo $field['extra_attr'] ?>  />
        <input type="hidden" id="<?php echo $field['name']; ?>_hidden" name="<?php echo $field['name']; ?>" value="<?php echo $field['result']; ?>" />
    </div>
</div>

<script>
    $(document).on("click", ".open-img-res", function () {
        var hidden = $(this).data('hidden');
        var thumb = $(this).attr('id');
        layer.open({
            type: 2,
            title: '图片选择',
            shadeClose: true,
            shade: 0.8,
            area: ['90%', '90%'],
            content: "<?php echo url('admin/system_res/index') ?>?hidden=" + hidden + "&thumb=" + thumb + "" //iframe的url
        });
    });
</script>