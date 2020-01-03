<div class="panel panel-default">
    <div class="panel-heading">出库退货</div>
    <div class="panel-body">
        <form class="form-inline sales_returns_add" action="{:url('sales_returns_add',['id'=>$one.id])}" method="post">
            <input type="hidden" name="url" value="" />
            <table class="table table-hover">
                <tr>
                    <th style="width:130px;text-align:right">产品识别码</th>
                    <td>{$one.product_data.code}</td>
                </tr>
                <tr>
                    <th style="text-align:right">产品名称</th>
                    <td>{$one.product_data.name}</td>
                </tr>
                <tr>
                    <th style="line-height:30px;text-align:right">退入仓库</th>
                    <td>
                        <select name="warehouse" class="form-control">
                            <option value="">所有仓库</option>
                            {volist name="warehouse" id="var"}
                            <option value="{$var.id}"{$one.w_id===$var.id?' selected':''}>{$var.name}</option>
                            {/volist}
                        </select>
                    </td>
                </tr>
                <tr>
                    <th style="width:130px;line-height:30px;text-align:right">退货数量</th>
                    <td>
                        <div class="input-prepend input-append">
                            <button type="button" class="btn btn-default" onclick="$('#quantityquantity').val((Number($('#quantityquantity').val()) - 1) < 1 ? 1 : (Number($('#quantityquantity').val()) - 1))"><i class="fa fa-minus"></i></button>
                            <input type="text" id="quantityquantity"  name="quantity" value="1" placeholder="数量" class="form-control">
                            <button type="button" class="btn btn-default" onclick="$('#quantityquantity').val((Number($('#quantityquantity').val()) + 1) > {$one.quantity - $one.returns} ? $('#quantityquantity').val() : (Number($('#quantityquantity').val()) + 1))"><i class="iconfont icon-tianjia"></i></button>
                        </div>
                        <p class="help-block">可退货数量为:{$one.quantity-$one.returns}</p>
                    </td>
                </tr>                
                <tr>
                    <th style="line-height:30px;text-align:right">备注</th>
                    <td><textarea name="remark" type="" class="form-control" style="height:50px"></textarea></td>
                </tr>
                <tr>
                    <th style="width:130px;line-height:30px;text-align:right"></th>
                    <td><button type="submit" class="btn btn-primary ajax-post" target-form="sales_returns_add"><i class="iconfont icon-tubiao_tijiao"></i> 保存</button> </td>
                </tr>
            </table>
        </form>
    </div>
</div>