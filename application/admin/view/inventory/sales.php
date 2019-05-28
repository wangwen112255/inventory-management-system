{extend name="base:base" /} {block name="body"}
<form class="form-inline" action="{:url('sales')}"  method="post" autocapitalize="off" autocomplete="off" autocorrect="off">
    <table class="table table-hover">
        <tr>
            <th style="width:120px;line-height:30px;text-align:right">选择会员</th>
            <td><input type="text" class="form-control"  value="" id="automember" placeholder="会员名称搜索">
                <input type="hidden" name="member_id" value="{$Think.post.member_id}" id="member_id" />
            </td>
        </tr>
        {if !empty($member)}
        <tr>
            <td colspan="2">
                <table class="table table-hover " style="margin-bottom:0px">
                    <tbody>
                        <tr>
                            <th style="width:150px;text-align:right">会员名称</th>
                            <td style="width:250px;">{$member.nickname|default=''}</td>
                            <th style="width:150px;text-align:right">会员分组</th>
                            <td style="">{$member.name}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        {/if}
        <tr>
            <th style="line-height:30px;text-align:right">选择产品</th>
            <td style="line-height:30px;">
                <input type="text"  placeholder="产品识别码或名称搜索" class="form-control" id="autocomplete">
                <input type="hidden" name="product_id" id="product_id" value="" />
            </td>
        </tr>
        <?php
        $key = 0;
        if (!empty($products)) {
            // dd($products);
            foreach ($products as $key => $var) {
                // $key2 = $key + 1;
                //把会员的分组价格给显示出来
                $final_price = isset($var['group_price']) ? $var['group_price'] : $var['sales'];
                ?>
                <tr id="tabletbody{$key}">
                    <td colspan="2">
                        <table class="table table-hover table-striped" style="margin-bottom:0px">
                            <tbody>
                                <tr>
                                    <th style="width:120px;line-height:30px;text-align:right">识别码</th>
                                    <td style="width:120px;line-height:30px;">
                                        {$var.code}
                                    </td>
                                    <th style="width:120px;line-height:30px;text-align:right">产品</th>
                                    <td style="width:120px;line-height:30px;"><input type="hidden" name="product_ids[{$key}]" value="{$var.id}" /> {$var.name}
                                    </td>
                                    <th style="width:120px;line-height:30px;text-align:right">销售价</th>
                                    <td style="width:120px;line-height:30px;">
                                        {$var.sales}
                                    </td>
                                    <th style="width:120px;line-height:30px;text-align:right">仓库</th>
                                    <td style="line-height:30px;">
                                        <select name="product_warehouse[{$key}]" class="form-control" required="">
                                            <option value="">选择</option>
                                            <?php
                                            $pw = isset($_POST['product_warehouse'][$key]) ? $_POST['product_warehouse'][$key] : 0;
                                            foreach ($var['warehouse'] as $vars) {
                                                if ($pw == $vars['id'] || $vars['default'] == 1) {
                                                    echo '<option value="' . $vars['id'] . '"  selected >' . $vars['name'] . '   [' . $vars['quantity'] . ']</option>';
                                                } else {
                                                    echo '<option value="' . $vars['id'] . '"   >' . $vars['name'] . '   [' . $vars['quantity'] . ']</option>';
                                                }
                                            }
                                            ?>
                                        </select>                                      
                                        <button type="button" class="btn btn-default remove" onclick="$('#tabletbody{$key}').empty();sum();"><i class="fa fa-remove"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width:120px;line-height:30px;text-align:right">数量</th>
                                    <td style="width:120px;line-height:30px;">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon lost" 
                                                     style="cursor:pointer" val="<?php echo $key; ?>" ><i class="fa fa-minus"></i></div>
                                                <input type="text"
                                                       style="width:120px;"
                                                       id="quantity{$key}" class="quantity form-control text-center" sales="{$var.sales}" 
                                                       name="product_quantity[{$key}]" 
                                                       value="<?php
                                                       //echo ($key == 0) ? 1 : $_POST['product_quantity'][$key];
                                                       echo isset($_POST['product_quantity'][$key]) ? $_POST['product_quantity'][$key] : 1;
                                                       // echo isset($_POST['product_quantity'][$key2]) ? $_POST['product_quantity'][$key2] : 1; 
                                                       ?>" 
                                                       onkeyup="calculate_money({$key})" 
                                                       placeholder="数量">
                                                <div class="input-group-addon just" style="cursor:pointer" val="<?php echo $key; ?>" ><i class="fa fa-plus"></i></div>
                                            </div>
                                        </div>
                                    </td>
                                    <th style="width:120px;line-height:30px;text-align:right">实销价</th>
                                    <td style="width:120px;line-height:30px;">
                                        <input type="text" 
                                               id="group_price{$key}"
                                               style="width:120px;" 
                                               name="group_price[{$key}]"                                              
                                               value="<?php
                                               echo isset($_POST['group_price'][$key]) ? $_POST['group_price'][$key] : $final_price;
                                               ?>" 
                                               placeholder="折扣价" 
                                               class="form-control group_price"
                                               onkeyup="calculate_money({$key})"  >
                                    </td>
                                    <th style="width:120px;line-height:30px;text-align:right">小计</th>
                                    <td style="width:120px;line-height:30px;">                                       
                                        <input type="text" id="money{$key}" 
                                               key='{$key}'
                                               value="<?php echo $final_price; ?>" 
                                               style="width: 120px" class="form-control money" disabled>                                          
                                    </td>
                                    <th style="width:120px;line-height:30px;text-align:right"></th>
                                    <td style="line-height:30px;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
        <tr>
            <th style="line-height:30px;text-align:right">总金额</th>
            <td style="line-height:30px;"><span id="productsummoney"></span></td>
        </tr>
        <tr>
            <th style="line-height:30px;text-align:right">发货日期</th>
            <td><input type="text" class="form-control" id="ship_time" name="ship_time" value="{$Think.post.ship_time?:date('Y-m-d H:i')}" placeholder="创建开始日期"></td>
        </tr>
        <tr>
            <th style="line-height:30px;text-align:right">快递公司</th>
            <td>
                <select name="express_id" class="form-control">
                    <option value="">选择</option>
                    {volist name="express" id="var"}
                    <option value="{$var.id}" {eq name="Think.get.express_id" value="$var.id"} selected{/eq} >{$var.name}</option>
                    {/volist}
                </select>
                &nbsp;单号
                <input type="text" class="form-control" id="express_num" name="express_num" value="{$Think.get.express_num}" placeholder="快递单号" />
            </td>
        </tr>
        <tr>
            <th style="line-height:30px;text-align:right">收货地址</th>
            <td>
                <input style="width: 50%" type="text" class="form-control" id="express_addr" name="express_addr" value="<?php
                $express_addr = input('post.express_addr', '');
                if (empty($express_addr)) {
                    echo isset($member['address']) ? $member['address'] : '';
                } else {
                    echo $express_addr;
                }
                ?>" placeholder="收货地址" />
            </td>
        </tr>
        <tr>
            <th style="line-height:30px;text-align:right">销售类型</th>
            <td>
                <select name="sales_type" class="form-control">
                    <?php echo html_select(config('_dict_sales'), input('get.storage_type')); ?>
                </select>
            </td>
        </tr>
        <tr>
            <th style="line-height:30px;text-align:right">销售备注</th>
            <td><textarea style="width: 20%" name="remark" type="" class="form-control" style="height:60px">{$Think.get.remark}</textarea></td>
        </tr>
        <tr>
            <td style="line-height:30px;text-align:right"></td>
            <td colspan="5">
                <button type="submit" class="btn btn-primary ajax-post" target-form="form-inline" onclick="$('form').attr('action', '<?php echo url('sales_submit'); ?>');"><i class="fa fa-save"></i> 保存</button>
            </td>
        </tr>
    </table>
</form>
{/block} 
{block name="foot_js"}
<!--加载时间框--> 
<script>
    $(function () {
        $('#ship_time').datetimepicker(
                {lang: 'zh', format: 'Y-m-d H:i', timepicker: true, step: 5, closeOnDateSelect: true});
    });</script> 
<!--加载时间框END-->
<script type="text/javascript">
    $(function () {
        $('#autocomplete').autocomplete({
            serviceUrl: "{:url('json/product')}",
            onSelect: function (suggestion) {
                $('#product_id').val(suggestion.id);
                $('form').submit();
            }
        });
        $('#automember').autocomplete({
            serviceUrl: "{:url('json/member')}",
            onSelect: function (suggestion) {
                $('#member_id').val(suggestion.id);
                $('form').submit();
            }
        });
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
        if (!quantitynum.match(new RegExp("^[0-9]+$")) || quantitynum <= 0) {
            $('#' + quantity).val('1');
            quantitynum = 1;
        }
        sub_price = (group_price * quantitynum).toFixed(2);
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
            calculate_money(key);
        }
    });
</script>
{/block}