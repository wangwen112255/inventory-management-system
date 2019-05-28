<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $field['title'] ?></label>
            <div class="col-sm-6">

                <!-- 加载编辑器的容器 -->
                <script name="<?php echo $field['name'] ?>" type="text/plain" id="container" style="width:100%;height:240px;"><?php echo $field['result'] ?></script>

            </div><div class="check-tips"><?php echo $field['description'] ?></div>
        </div>