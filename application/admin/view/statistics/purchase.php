{if $this->t_verify->is_post() && $this->t_verify->is_ajax()}
<?php if (count($list) == 0) { ?>
<p class="bg-warning center-block">   
    <i class="iconfont icon-wushuju"></i> 暂时没有相关数据
</p>
{else}
{if $chart==='1'}
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th colspan="7" style="text-align:center">仓库信息</th>
            <th colspan="6" style="text-align:center">产品信息</th>
        </tr>
        <tr>
            <th>ID</th>
            <th>仓库</th>
            <th>入库</th>
            <th>库存</th>
            <th>单位</th>
            <th>入库日期</th>
            <th>入库人</th>
            <th>识别码</th>
            <th>产品名称</th>
            <th>产品类型</th>
            <th>产品分类</th>
            <th>供应商</th>
            <th style="width:70px;text-align:center">查看</th>
        </tr>
    </thead>
    <tbody>
        {volist name="list" id="var"}
        <tr>
            <td>{:sprintf("%06d",$var.w_id)}</td>
            <td>{$var.w_name}</td>
            <td>{$var.number}</td>
            <td>{$var.quantity}</td>
            <td>{$var.unit}</td>
            <td title="{date('Y-m-d H:i:s',$var.time)}">{array_shift($this->t_date->get_lastdate((int)$var.time))}</td>
            <td>{$var.w_members}</td>
            <td>{$var.code}</td>
            <td>{$var.name}</td>
            <td>{$var.type}</td>
            <td>{$var.category}</td>
            <td>{$var.company}</td>
            <td style="text-align:center"><a href="{site 'inventory/product_look/'.$var.id}" title="查看产品"><i class="iconfont icon-sousuo"></i> 查看</a></td>
        </tr>
        {/volist}

    </tbody>
</table>
{else}
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th style="width:20px"></th>
            <th>编号</th>
            <th>入库数量</th>
            <th>入库日期</th>
            <th>入库人</th>
            <th>供应商</th>
            <th>备注</th>
        </tr>
    </thead>
    <tbody>
        {volist name="list" id="var"}
    <script type="text/javascript">
        function product_data(id){
        $('.product_data').hide(); $('.product_dataplus').html('<i class=\'icon-plus\'></i>'); $('#product_data' + id).fadeIn(); $('#product_dataplus' + id).html('<i class=\'icon-minus\'></i>');
        }
    </script>
    <tr onclick="product_data('{$var.id}')">
        <td class="product_dataplus" id="product_dataplus{$var.id}"><i class="icon-plus"></i></td>
        <td>{$var.number}</td>
        <td>{$var.quantity}</td>
        <td title="{date('Y-m-d H:i:s',$var.time)}">{array_shift($this->t_date->get_lastdate((int)$var.time))}</td>
        <td>{$var.nickname}</td>
        <td>{$var.company}</td>
        <td title="{$var.remark}">{$var.remark}</td>
    </tr>
    <tr id="product_data{$var.id}" class="product_data" style="display:none">
        <td colspan="7">
            <table class="table table-hover table-striped table-bordered" style="margin-bottom:0px">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>仓库</th>
                        <th>入库</th>
                        <th>库存</th>
                        <th>单位</th>

                        <th>识别码</th>
                        <th>产品名称</th>
                        <th>产品类型</th>
                        <th>产品分类</th>
                        <th style="width:70px;text-align:center">查看</th>
                    </tr>
                </thead>
                <tbody>
                    {loop $this->m_product_w->pr_where(null,false)->group('w.id')->where(array('w.o_id'=>$var.id))->finds() as $var2}
                    <tr>
                        <td>{:sprintf("%06d",$var2.w_id)}</td>
                        <td>{$var2.w_name}</td>
                        <td>{$var2.number}</td>
                        <td>{$var2.quantity}</td>
                        <td>{$var2.unit}</td>
                        <td>{$var2.code}</td>
                        <td>{$var2.name}</td>
                        <td>{$var2.type==='1'?'正常':'赠品'}</td>
                        <td>{$var2.category}</td>
                        <td style="text-align:center"><a href="{site 'inventory/product_look/'.$var2.id}" title="查看产品"><i class="iconfont icon-sousuo"></i> 查看</a></td>
                    </tr>
                    {/volist}

                </tbody>
            </table>
        </td>
    </tr>
    {/volist}
</tbody>
</table>
{/if}



{/if}
{else}
{view 'public/head'}
</head>
<body>
    <div class="container-fluid">

        <form id="forminventorysupplier" class="form-inline" action="{site 'statistics/purchase/'.$py}" accept-charset="utf-8" method="get">
            <table class="table table-hover">
                <tbody>

                    <tr>
                        <td>
                            <input type="text" placeholder="识别码/产品名称" name="keyword" value="{$Think.get.keyword}" class="form-control">

                            <input size="16" type="text" class="form_datetime form-control" name="timea" value="{$Think.request.timea}" placeholder="创建开始日期">
                            <i class="icon-resize-horizontal"></i>
                            <input size="16" type="text" class="form_datetime form-control" name="timeb" value="{$Think.request.timeb}" placeholder="创建结束日期">



                            <div class="btn-group" data-toggle="buttons-radio">
                                <button type="button" onclick="$('#chartinput').val(0); $('form').submit()" class="btn{empty($chart)?' active':''}"><i class="icon-bar-chart"></i> 宏观图</button>
                                <button type="button" onclick="$('#chartinput').val(1); $('form').submit()" class="btn{$chart==='1'?' active':''}"><i class="icon-table"></i> 产品列表</button>
                                <button type="button" onclick="$('#chartinput').val(2); $('form').submit()" class="btn{$chart==='2'?' active':''}"><i class="icon-list-alt"></i> 入库列表</button>

                            </div>
                            <input type="hidden" id="chartinput" name="chart" value="{$chart}" />
                            <button type="submit" class="btn btn-primary" title="查询"><i class="iconfont icon-sousuo"></i> 搜索</button>
                            <button class="btn" type="button" onclick="$('#more_search').fadeToggle(); $('#financequerysearch').val($('#financequerysearch').val() == 1?0:1)"><i class="fa fa-rss"></i> 更多</button>

                            

                            <input type="hidden" id="page" name="page" value="1" />
                            <input type="hidden" id="countinput" name="count" value="{$count}" />
                        </td>
                    </tr>
                    <tr id="more_search" {eq name="Think.request.financequerysearch" value="1"}style="display:none"{/eq}>
                        <td>
                            <input type="hidden" name="financequerysearch" id="financequerysearch" value="{$Think.request.financequerysearch?:0}" />
                            <input type="text" class="input-mini" style="width: 70px" name="lowesta" value="{$Think.request.lowesta}" placeholder="库存">
                            <i class="icon-resize-horizontal"></i>
                            <input type="text" class="input-mini" style="width: 70px" name="lowestb" value="{$Think.request.lowestb}" placeholder="库存">
                            <select name="supplier" class="form-control">
                                <option value="">所有供应商</option>
                                {volist name="supplier" id="var"}
                                <option value="{$var.id}"{eq name="Think.request.supplier" value="$var.id"} selected{/eq}>{$var.company}</option>
                                {/volist}
                            </select>

                            <select name="warehouse" class="form-control">
                                <option value="">所有仓库</option>
                                {volist name="warehouse" id="var"}
                                <option value="{$var.w_id}"{eq name="Think.request.warehouse" value="$var.w_id"} selected{/eq}>{$var.w_name}</option>
                                {/volist}
                            </select>
                            <select name="c_id" class="form-control">
                                <option value="">所有分类</option>
                                {$category}
                            </select>
                            <select name="type" class="form-control">
                                <option value="">类型</option>
                                <option value="1"{eq name="Think.request.type" value="1"} selected{/eq}>正常</option>
                                <option value="2"{eq name="Think.request.type" value="2"} selected{/eq}>赠品</option>
                            </select>
                            

                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
        {if empty($chart)}
        <p>
            <small><i class="iconfont icon-wushuju"></i> 共计:<strong>{:array_sum($list.number)}</strong>个入库记录</small>
        </p>
        <?php if (count($list) == 0) { ?>
        <p class="bg-warning center-block">   
    <i class="iconfont icon-wushuju"></i> 暂时没有相关数据
</p>
        {/if}
        <div id="main" style="height:450px;border:0px solid #ccc;padding:10px;"></div>


        {else}
        <p>
            <small><i class="iconfont icon-wushuju"></i> 查询到了<strong>{$count}</strong>个数据,共计<strong>{$sum}</strong>个入库记录</small>
        </p>
        <div id="tablelist">

        </div>
        <div class="pagination text-center">
            <ul id='pagination'>

            </ul>
        </div>
        {/if}

    </div>
    {view 'public/js'}

    {if empty($chart)} {if !empty($list)}
    {js 'assets/echarts/esl/esl.js'}
    {js 'assets/echarts/echarts-plain.js'}
    <script type="text/javascript">
                var option = {
                title : {
                text: '进货宏观图',
                        subtext: '{$Think.request.timea}至{$Think.request.timeb}'
                },
                        tooltip : {
                        trigger: 'axis'
                        },
                        legend: {
                        data:['进货']
                        },
                        toolbox: {
                        show : true,
                                feature : {
                                mark : {show: true},
                                        dataView : {show: true, readOnly: false},
                                        magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                                        restore : {show: true},
                                        saveAsImage : {show: true}
                                }
                        },
                        calculable : true,
                        xAxis : [
                        {
                        type : 'category',
                                boundaryGap : false,splitLine : {show : false},
                                data : [{implode(',', $list.date)}]
                        }
                        ],
                        yAxis : [
                        {
                        type : 'value'
                        }
                        ],
                        series : [
                        {
                        name:'进货',
                                type:'line',
                                smooth:true,
                                itemStyle: {normal: {areaStyle: {type: 'default'}}},
                                data:[{implode(',', $list.number)}],
                                markLine : {
                                data : [
                                {type : 'average', name : '平均值'}
                                ]
                                }
                        }
                        ]
                };
                echarts.init(document.getElementById('main')).setOption(option);</script>
    {/if}
    {else}
    <script type="text/javascript">
                $(document).ready(function() {
        {if !empty($count)}
        $('#pagination').jqPaginator({
        totalCounts: {$count},
                pageSize:{:config('LIST_ROWS')},
                currentPage: 1,
                onPageChange: function(num, type) {
                $('#paginationinput').val(num);
                        $.post($('#forminventorysupplier').attr('action'), $('#forminventorysupplier').serialize(), function(data) {
                        $('#tablelist').html(data);
                        });
                }
        });
        {/if}

        });
    </script>
    {/if}
</body>
</html>
{/if}