{view 'public/head'}
</head>
<body>
    <div class="container-fluid">

        <form id="forminventorysupplier" class="form-inline" action="{site 'statistics/wage/'.$py}" accept-charset="utf-8" method="get">




            <input size="16" type="text" class="form_datetime form-control" name="timea" value="{$Think.request.timea}" placeholder="开始日期">
            <i class="icon-resize-horizontal"></i>
            <input size="16" type="text" class="form_datetime form-control" name="timeb" value="{$Think.request.timeb}" placeholder="结束日期">




            <div class="btn-group" data-toggle="buttons-radio">
                <button type="button" onclick="$('#chartinput').val(0); $('form').submit()" class="btn{empty($chart)?' active':''}"><i class="icon-bar-chart"></i> 宏观图</button>
                <button type="button" onclick="$('#chartinput').val(1); $('form').submit()" class="btn{$chart==='1'?' active':''}"><i class="icon-table"></i> 表格</button>
            </div>
            <input type="hidden" id="chartinput" name="chart" value="{$chart}" />
            <button type="submit" class="btn btn-primary" title="查询"><i class="iconfont icon-sousuo"></i> 查询</button>



            <input type="hidden" id="page" name="page" value="1" />
            <input type="hidden" id="countinput" name="count" value="{$count}" />

        </form>

        <?php if (count($list) == 0) { ?>
        <p class="bg-warning center-block">     <i class="iconfont icon-wushuju"></i> 暂时没有相关数据</p>
        {else}

        {if $chart==='1'}
        <p>
            <small><i class="iconfont icon-wushuju"></i> 查询到了<strong>{count($list)}</strong>个提成记录 </small>
        </p>
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>时间</th>
                    <th>基本工资</th>
                    <th>提成</th>
                    <th>订单</th>
                </tr>
            </thead>
            <tbody>
                {volist name="list" id="var"}
                <tr>
                    <td title="{date('Y-m-d H:i:s',$var.time)}">{array_shift($this->t_date->get_lastdate((int)$var.time))}</td>
                    <td>{$var.basic}</td>
                    <td>{$var.wage;$commission+=$var.wage}</td>
                    <td>{if !empty($var.orders)}<a href="{site 'inventory/product_sales_look/'.$var.orders}" title="查看记录"><i class="iconfont icon-sousuo"></i> 查看</a>{/if}</td>
                </tr>
                {/volist}
            </tbody>

            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>￥{$commission}</th>
                    <th></th>
                </tr>
            </thead>
        </table>
        {else}
        <p>
            <small><i class="iconfont icon-wushuju"></i> 合计提成:<strong>{:array_sum($list.wage)}</strong></small>
        </p>

        <div id="main" style="height:450px;border:0px solid #ccc;padding:10px;"></div>
        {/if}
        {/if}

    </div>
    {view 'public/js'}


    {js 'assets/echarts/esl/esl.js'}
    {js 'assets/echarts/echarts-plain.js'}
    <script type="text/javascript">
        {if empty($chart)}
        var option = {
        title: {
        text:"{$staffs.nickname} 工资宏观图",
                subtext: '{$Think.request.timea}至{$Think.request.timeb} 合计提成:{:array_sum($list.wage)}'
        },
                tooltip: {
                trigger: 'axis'
                },
                legend: {
                data: ['提成', '基本工资']
                },
                toolbox: {
                show: true,
                        feature: {
                        mark: {show: true},
                                magicType: {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                                restore: {show: true},
                                saveAsImage: {show: true}
                        }
                },
                xAxis: [
                {
                type: 'category',
                        boundaryGap: false, splitLine : {show : false},
                        data: [{implode(',', $list.date)}]
                }
                ],
                yAxis: [
                {
                type: 'value'
                }
                ],
                series: [
                {
                name: '提成',
                        type: 'line',
                        smooth: true,
                        itemStyle: {normal: {areaStyle: {type: 'default'}}},
                        data: [{implode(',', $list.wage)}],
                        markLine : {
                        data : [
                        {type : 'average', name : '平均值'}
                        ]
                        }
                },
                {
                name: '基本工资',
                        type: 'line',
                        smooth: true,
                        itemStyle: {normal: {areaStyle: {type: 'default'}}},
                        data: [{implode(',', $list.basic)}]
                }
                ]
        };
        echarts.init(document.getElementById('main')).setOption(option);
        {/if}


    </script>
</body>
</html>