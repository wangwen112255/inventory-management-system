{extend name="base:base" /} {block name="body"} 
<div class="text-left">
    <a href="javascript:history.back(-1);" title="返回" class="btn btn-default"><i class="iconfont icon-flow"></i> 返回</a>
</div>
<hr>

<div class="container">

<div id="legend" class="text-center">
    <h2>产品信息</h2> 
</div>
<table class="table table-hover">
    <tr>
        <th style="width:90px;text-align:right">产品货号</th>
        <td>{$var.code}</td>
        <th style="width:90px;text-align:right">产品名称</th>
        <td>{$var.name}</td>
        <th style="width:90px;text-align:right">产品分类</th>
        <td>{$var.category} </td>
        <th style="width:120px;text-align:right">最低库存报警</th>
        <td>{$var.lowest}</td>
    </tr>
    <tr>
        <th style="text-align:right">产品单位</th>
        <td>{$var.unit}</td>
        <th style="text-align:right">出库价</th>
        <td>{$var.sales}</td>
        <th style="text-align:right">进货价</th>
        <td>{$var.purchase}</td>
        <th style="text-align:right"></th>
        <td></td>
    </tr>
    <tr>
        <th style="text-align:right">产品类型</th>
        <td>{$var.type==='1'?'正常':'赠品'}</td>
        <th style="text-align:right">产品规格</th>
        <td>{$var.format}</td>
        <th style="text-align:right"></th>
        <td></td>
        <th style="text-align:right"></th>
        <td></td>
    </tr>
    <tr>
        <th style="text-align:right">创建人</th>
        <td>
            {$var.nickname} </td>
        <th style="text-align:right">创建日期</th>
        <td>{$var.create_time} </td>
        <th style="text-align:right">最后更新</th>
        <td>
            {$var.replace_nickname}</td>
        <th style="text-align:right">更新日期</th>
        <td>
            {$var.update_time} </td>
    </tr>
    <tr>
        <th style="text-align:right">产品备注</th>
        <td colspan="7">{$var.remark}</td>
    </tr>
</table>


{if !empty($count1)}
<div id="legend" class="text-center">
    <h2>库存信息</h2>  
</div>
<hr>
<p class="bg-warning"> <i class="iconfont icon-tishi"></i>  查询到了<strong>{$count1}</strong>个库存记录，库存合计：<?php echo $quantity_sum1; ?> </p>
<div id="tablelist1">
</div>
<div class=" text-center">
    <ul class="pagination" id='pagination1'>
    </ul>
</div>
{/if}


{if !empty($count2)}
<div id="legend" class="text-center">
    <h2>入库记录</h2>  
</div>
<hr>
<p class="bg-warning"> <i class="iconfont icon-tishi"></i>  查询到了<strong>{$count2}</strong>个入库记录，入库合计：<?php echo $quantity_sum2; ?> </p>
<div id="tablelist2">
</div>
<div class=" text-center">
    <ul class="pagination" id='pagination2'>
    </ul>
</div>
{/if}


{if !empty($count4)}
<div id="legend" class="text-center">
    <h2>出库记录</h2>  
</div>
<hr>
<p class="bg-warning"> <i class="iconfont icon-tishi"></i>  查询到了<strong>{$count4}</strong>个出库记录，出库合计：<?php echo $quantity_sum4; ?>，退货合计：<?php echo $quantity_sum42; ?> </p>
<div id="tablelist4">
</div>
<div class=" text-center">
    <ul class="pagination" id='pagination4'>
    </ul>
</div>
{/if}

{if !empty($count3)}
<div id="legend" class="text-center">
    <h2>调拨记录</h2>   
</div>
<hr />
<p class="bg-warning"> <i class="iconfont icon-tishi"></i>  查询到了<strong>{$count3}</strong>个调拨记录</p>
<div id="tablelist3">
</div>
<div class=" text-center">
    <ul class="pagination" id='pagination3'>
    </ul>
</div>
{/if}


</div>
{/block}
{block name="foot_js"} 
<script type="text/javascript" src="__PUBLIC__/libs/jqPaginator/1.1.0/dist/jqPaginator.min.js"></script>
<script type="text/javascript">
    $(function() {
    {if !empty($count1)}
    $('#pagination1').jqPaginator({
    totalCounts: {$count1},
            pageSize:{:config('base.page_size')},
            currentPage:1,
            onPageChange: function(num, type) {
            // alert(num);
            $.post("{:url('product_look',['id'=>$var.id, 'w_id'=>$Think.get.w_id])}", {looktype:1, count:{$count1}, page:num}, function(data) {
            $('#tablelist1').html(data);
            });
            }
    });
    {/if}
    {if !empty($count2)}
    $('#pagination2').jqPaginator({
    totalCounts:{$count2},
            pageSize:{:config('base.page_size')},
            currentPage:1,
            onPageChange:function(num, type) {
            $.post("{:url('product_look',['id'=>$var.id, 'w_id'=>$Think.get.w_id])}", {looktype:2, count:{$count2}, page:num}, function(data) {
            $('#tablelist2').html(data);
            });
            }
    });
    {/if}
    {if !empty($count3)}
    $('#pagination3').jqPaginator({
    totalCounts:{$count3},
            pageSize:{:config('base.page_size')},
            currentPage: 1,
            onPageChange:function(num, type) {
            $.post("{:url('product_look',['id'=>$var.id, 'w_id'=>$Think.get.w_id])}", {looktype:3, count:{$count3}, page:num}, function(data) {
            $('#tablelist3').html(data);
            });
            }
    });
    {/if}
    {if !empty($count4)}
    $('#pagination4').jqPaginator({
    totalCounts:{$count4},
            pageSize:{:config('base.page_size')},
            currentPage: 1,
            onPageChange:function(num, type) {
            $.post("{:url('product_look',['id'=>$var.id, 'w_id'=>$Think.get.w_id])}", {looktype:4, count:{$count4}, page:num}, function(data) {
            $('#tablelist4').html(data);
            });
            }
    });
    {/if}
    });
</script>{/block}
