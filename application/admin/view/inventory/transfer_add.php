<div class="panel panel-default">
  <div class="panel-heading">库存调出</div>
  <div class="panel-body">
<form class="form-inline transfer_add"  action="{:url('transfer_add',['id'=>$Think.get.id])}" method="post">
    <table class="table table-hover">
         <tr>
            <th style="width:130px;text-align:right">产品识别码</th>
            <td>{$lists.code}</td>
        </tr>
        <tr>
            <th style="text-align:right">产品名称</th>
            <td>{$lists.name}</td>
        </tr>
        <tr>
            <th style="text-align:right">拨出仓库</th>
            <td>{$lists.name}</td>
        </tr>
        <tr>
            <th style="text-align:right">库存数量</th>
            <td>{$lists.quantity}</td>
        </tr>
        <tr>
            <th style="line-height:30px;text-align:right">拨入仓库</th>
            <td> <select name="warehouse" class="form-control">
                    <option value="">请选择</option>
                    {volist name="warehouse" id="var"}
                        {neq name="lists.w_id" value="$var.id"}
                            <option value="{$var.id}"  {eq name="var.default" value="1"} selected{/eq}>{$var.name}</option>
                        {/neq}
                    {/volist}
                </select>
            </td>
        </tr>
        <tr>
            <th style="line-height:30px;text-align:right">入库数量</th>
            <td>
                <div class="input-prepend input-append">
                    <button type="button" class="btn btn-default" onclick="$('#quantitynumber').val((Number($('#quantitynumber').val()) - 1) < 1 ? 1 : (Number($('#quantitynumber').val()) - 1))"><i class="fa fa-minus"></i></button>
                    <input type="number" id="quantitynumber"  name="number" value="1" placeholder="数量" class="form-control">
                    <button type="button" class="btn btn-default" onclick="$('#quantitynumber').val((Number($('#quantitynumber').val()) + 1) > {$lists.quantity} ? $('#quantitynumber').val() : (Number($('#quantitynumber').val()) + 1))"><i class="fa fa-plus"></i></button>
                </div>
                <p class="help-block">可调拨数量为:{$lists.quantity}</p>
            </td>
        </tr>
         <tr>
            <th style="line-height:30px;text-align:right">备注</th>
            <td><textarea name="remark" type="" class="form-control" style="height:50px"></textarea></td>
        </tr>
        <tr>
            <th style="text-align:right"></th>
            <td>
                <button type="submit" class="btn btn-primary ajax-post" target-form='transfer_add'><i class="iconfont icon-tubiao_tijiao"></i> 调拨</button>
            </td>
        </tr>
    </table>
</form>
</div>
</div>