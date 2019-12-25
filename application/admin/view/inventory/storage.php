{extend name="base:base" /} {block name="body"} 
<style>
    .table>tbody>tr>td,.table>tbody>tr>th{line-height: 30px;}
</style>
<form class="form-inline" action="" method="POST">
    <table class="table table-hover">
        <tr>
            <th style="width: 150px;text-align:right"></th>
            <td>
                <div id="legend" class="text-ceter">
                    <h3>入库单</h3> 
                </div>
            </td>
        </tr>
        <tr>
            <th style="text-align:right">产品</th>
            <td>
                <input type="text" name="code" placeholder="产品识别码或搜索" class="form-control" id="autoproduct">
                <input type="hidden" name="product_id" id="product_id" value="" />
            </td>
        </tr>
        <?php
        if (!empty($products)) {
            foreach ($products as $key => $val) {
                ?>
                <tr id="tabletbody{$key}">
                    <td colspan="2">
                        <table class="table table-hover table-striped" style="margin-bottom:0px">
                            <tbody>
                                <tr>
                                    <td style="width:10%">识别码
                                        <?php echo $val['code']; ?>
                                    </td>
                                    <td style="width:10%">产品
                                        <input type="hidden" name="product_ids[{$key}]" value="<?php echo $val['id']; ?>" />
                                        <?php echo $val['name']; ?>
                                    </td>
                                    <td style="width:15%">数量
                                        <div class="form-group">
                                            <div class="input-group">                                                
                                                <div class="input-group-addon lost" style="cursor:pointer" val="{$key}"><i class="fa fa-minus"></i></div>
                                                <input type="text" id="quantity{$key}" style="width: 80px;" 
                                                       name="product_quantity[{$key}]" 
                                                       value="<?php echo isset($_POST['product_quantity'][$key]) ? $_POST['product_quantity'][$key] : 1; ?>"
                                                       placeholder="数量" class="form-control text-center" onkeyup="calculate_money({$key})"  />
                                                <div class="input-group-addon just" style="cursor:pointer" val="{$key}"><i class="fa fa-plus"></i></div>
                                            </div>
                                        </div>       
                                    </td>
                                    <td style="width:18%">进货价
                                        <input type="text" 
                                               id="group_price{$key}"
                                               style="width:80px;" 
                                               name="group_price[{$key}]"                                              
                                               value="<?php
                                               echo isset($_POST['group_price'][$key]) ? $_POST['group_price'][$key] : $val['purchase'];
                                               ?>" 
                                               placeholder="进货价" 
                                               class="form-control group_price"
                                               onkeyup="calculate_money({$key})"  >
                                    </td>
                                    <td style="width:15%">小计
                                        <input type="text" id="money{$key}" 
                                               key='{$key}'
                                               value="<?php echo $val['purchase']; ?>" 
                                               style="width: 120px" class="form-control money" disabled>      
                                    </td>
                                    <td>加入仓库
                                        <select name="warehouse[{$key}]" class="form-control" required>
                                            <option value="">请选择</option>
                                            <?php
                                            if (isset($_POST['warehouse'][$key])) {
                                                echo html_select($warehouse, $_POST['warehouse'][$key]);
                                            } else {
                                                echo html_select($warehouse);
                                            }
                                            ?>
                                        </select><button type="button" class="btn btn-default" onclick="$('#tabletbody{$key}').empty()"><i class="fa fa-remove"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            <?php } ?>   
        <?php } ?>
        <tr>
            <th style="text-align:right">总金额</th>
            <td style="">
                <span id="productsummoney"></span>
            </td>
        </tr>
        <tr>
            <th style="text-align:right">供应商</th>
            <td>
                <select name="supplier" class="form-control">
                    <option value="">请选择</option>
                    <?php echo html_select(db('product_supplier')->column('company', 'id'), input('post.supplier')); ?>
                </select>
            </td>
        </tr>
        <tr>
            <th style="text-align:right">入库类型</th>
            <td>
                <select name="type" class="form-control">
                    <?php echo html_select(config('_dict_storage'), input('post.type')); ?>
                </select>
            </td>
        </tr>
        <tr>
            <th style="text-align:right">产品备注</th>
            <td><textarea name="remark" type="" class="form-control" style="height:60px"></textarea></td>
        </tr>
        <tr>
            <td style="text-align:right"></td>
            <td>
                <button type="submit" class="btn btn-primary ajax-post" target-form="form-inline" onclick="$('form').attr('action', '<?php echo url('storage_submit'); ?>');"><i class="fa fa-save"></i> 保存</button> 
            </td>
        </tr>
    </table>
</form>
{/block}
{block name="foot_js"} 

<link rel="stylesheet" type="text/css" href="__PUBLIC__/libs/jquery.autocomplete/jquery.autocomplete.css"></link>
<script type="text/javascript" src="__PUBLIC__/libs/jquery.autocomplete/jquery.autocomplete.min.js"></script>
<script>
                    $('#autoproduct').AutoComplete({
                        'data': "<?php echo url('json/product') ?>",
                        'ajaxDataType': 'json',
                        'listStyle': 'iconList',
                        'maxItems': 10,
                        'itemHeight': 55,
                        'width': 300,
                        'async': true,
                        'matchHandler': function (keyword, data) {
                            return true
                        },
                        'afterSelectedHandler': function (data) {
                            $('#product_id').val(data.id);
                            $('form').attr('action', "{:url('storage')}");
                            $('form').submit();
                        },
                        'onerror': function (msg) {
                            alert(msg);
                        }
                    });
</script>

<script type="text/javascript">
    $(function () {
        $('.just').click(function () {
            var key = $(this).attr('val');
            $('#quantity' + key).val(Number($('#quantity' + key).val()) + 1);
            calculate_money(key);
        });
        $('.lost').click(function () {
            var key = $(this).attr('val');
            var val = $('#quantity' + key).val();
            if (val > 1) {
                $('#quantity' + key).val((Number($('#quantity' + key).val()) - 1));
            }
            calculate_money(key);
        });
        //
        $('.money').each(function () {
            var key = $(this).attr('key');
            var quantity = $('#quantity' + key).val();
            var group_price = $('#group_price' + key).val();
            var sub_price = (group_price * quantity).toFixed(2);
            $(this).val(sub_price);
        });
        sum();
    });
    //动态计算
    function calculate_money(key) {
        var sub_price;
        var group_price = $('#group_price' + key).val();  //最终价
        var quantitynum = $('#quantity' + key).val(); //数量
        var money = $('#money' + key); //小合计   
        console.log(key);
        if (!quantitynum.match(new RegExp("^[0-9]+$")) || quantitynum <= 0) {
            $('#' + quantity).val('1');
            quantitynum = 1;
        }
        sub_price = (group_price * quantitynum).toFixed(2);
        //alert(price);
        money.val(sub_price);
        sum();
    }
    //求最终合计
    function sum() {
        var sumnum = 0;
        $('.money').each(function () {
            var key = $(this).attr('key');
            var value = $(this).val();
            var check = value.match(/[-+]?\d+/g);
            if (check != null) {
                sumnum = sumnum + Number(value);
            }
        });
        $('#productsummoney').html(sumnum.toFixed(2));
    }
</script>
{/block}