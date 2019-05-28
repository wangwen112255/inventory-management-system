<div class="panel panel-default">
    <div class="panel-heading">提交报废</div>
    <div class="panel-body">
        <form class="form-inline scrapped_add" action="{:url('scrapped_add',['id'=>$Think.get.id])}" method="post">
            <table class="table table-hover">
                <tr>
                    <th style="width:130px;text-align:right">产品识别码</th>
                    <td>{$var.code}</td>
                </tr>
                <tr>
                    <th style="text-align:right">产品名称</th>
                    <td>{$var.name}</td>
                </tr>
                <tr>
                    <th style="text-align:right">出货仓库</th>
                    <td>
                        {$var.warehouse}
                    </td>
                </tr>
                <tr>
                    <th style="width:130px;line-height:30px;text-align:right">报废数量</th>
                    <td><div class="input-prepend input-append">
                            <button type="button" class="btn btn-default" onclick="$('#quantityquantity').val((Number($('#quantityquantity').val()) - 1) < 1 ? 1 : (Number($('#quantityquantity').val()) - 1))"><i class="fa fa-minus"></i></button>
                            <input type="text" id="quantityquantity"  name="quantity" value="1" placeholder="数量" class="form-control">
                            <button type="button" class="btn btn-default" onclick="$('#quantityquantity').val((Number($('#quantityquantity').val()) + 1) > {$var.quantity} ? $('#quantityquantity').val() : (Number($('#quantityquantity').val()) + 1))"><i class="fa fa-plus"></i></button>
                        </div>
                        <p class="help-block">可报废数量为:{$var.quantity}</p>
                    </td>
                </tr>
                <tr>
                    <th style="line-height:30px;text-align:right">备注</th>
                    <td><textarea name="remark" type="" class="form-control" style="height:50px"></textarea></td>
                </tr>
                <tr>
                    <th style="width:130px;line-height:30px;text-align:right"></th>
                    <td><button type="submit" class="btn btn-primary ajax-post" target-form='scrapped_add'><i class="fa fa-save"></i> 保存</button> </td>
                </tr>
            </table>
        </form>
    </div>
</div>
